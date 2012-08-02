<?php
class Pedido extends CActiveRecord
{
	/**
	 * Método Fábrica para a abertura de pedidos
	 * Cobre as seguintes regras de negócio
	 * CC02, CC04
	 * @param CWebUser $user
	 * @return Pedido $pedido
	 */
	public static function open( Cliente $cliente= null)
	{
		$today_date= date("Y-m-d H:i:s", time());
		$session_id= Yii::app()->getSession()->getSessionID();
		
		$pedido= Pedido::model()->find("id_session= '{$session_id}' AND status='ABERTO'");
		if(count($pedido)>0 && !is_null($cliente))
		{
			$pedido->setAttribute('id_cliente', $cliente->getPrimaryKey());
			$pedido->save();
		}
		else if(is_null($cliente) && !count($pedido)>0)
		{
			$pedido= new Pedido();
			$pedido->setAttribute("id_session", $session_id);
			$pedido->setAttribute("create_date", date("Y-m-d H:i:s"));
			$pedido->setAttribute("status", "ABERTO");
			$pedido->save();
		}
		else if(!count($pedido)>0 && !is_null($cliente))
		{
			// @todo Projetar query para calcular timestamp em total de horas
			$pedido= Pedido::model()->find("id_cliente= '{$cliente->getPrimaryKey()}' AND DATE(create_date)= DATE('{$today_date}') AND status='ABERTO'");
			if(!count($pedido)>0)
			{
				$pedido= new Pedido();
				$pedido->setAttribute("id_session", $session_id);
				$pedido->setAttribute("id_cliente", $cliente->getPrimaryKey());
				$pedido->setAttribute("create_date", date("Y-m-d H:i:s"));
				$pedido->setAttribute("status", "ABERTO");
				$pedido->save();
			}
		}
		
		return $pedido;
	}
	
	public function getTotal()
	{
		$total= 0;
		foreach($this->itens as $item)
		{
			$total += $item->getAttribute("quantidade") * $item->produto->getAttribute("preco");
		}
		
		return $total;
	}
	
	public function addItem(Produto $produto, $quantidade= 1)
	{
		// Verificar se há disponibilidade no estoque
		if(!$produto->isQuantityAvaiable($quantidade))
		{
			// Anotação para o log: Não há disponibilidade em estoque
			return;
		}
		
		// Verificar se o item já não esta adicionado ao carrinho
		$item= $this->getItem($produto);
		if(count($item)==0)
		{
			// o item não consta no carrinho
			// Adicionar o item ao carrinho
			if($produto->getFromInventory($quantidade))
			{
				$item= new ItemPedido();
				$item->setAttribute("pedido_id", $this->getPrimaryKey());
				$item->setAttribute("produto_id", $produto->getPrimaryKey());
				$item->setAttribute("quantidade", $quantidade);
				$item->save();
			}
			
			return;
		}
		
		foreach($this->itens as $item)
		{
			if($item->produto_id==$produto->getPrimaryKey())
			{
				$nova_quantidade_carrinho= $item->getAttribute("quantidade") + $quantidade;
				if($produto->getFromInventory($nova_quantidade_carrinho))
				{
					$item->setAttribute("quantidade", $nova_quantidade_carrinho);
					$item->update(array("quantidade"));
					
					return;
				}
				else 
				{
					// Anotação para o log: Não há disponibilidade em estoque
					return;
				}
			}
		}
	}
	
	public function batchItemUpdate($post_array)
	{
		$transaction= Yii::app()->db->beginTransaction();
		
		try 
		{
			$erros= false;
			foreach($post_array['ItemPedido'] as $item)
			{
				$produto= Produto::model()->findByPk($item['produto_id']);
				if(count($produto)>0)
				{
					$itempedido= $this->getItem($produto);
					$produto->returnToInventory($itempedido->getAttribute('quantidade'));
					
					$quantidade= $item['quantidade'];
					if($produto->getFromInventory($quantidade))
					{
						if(count($itempedido)>0)
						{
							$itempedido->setAttribute('quantidade', $quantidade);
							if($quantidade==0)
							{
								$itempedido->delete();
							}
							else 
							{
								if(!$itempedido->update(array('quantidade')))
								{
									throw new CHttpException(500,"Falha ao atualizar carrinho de compras");
								}
							}
						}
						else
						{
							throw new CHttpException(500,"O inventario foi atualizado sem atualizacao de item de produto");
						}
					}
					else 
					{
						// O estoque encontra-se baixo
						$erros= true;
					}
				}
			}
			
			$transaction->commit();
			return !$erros;
		}
		catch(Exception $e)
		{
			Yii::log("FALHA AO ATUALIZAR CARRINHO {$e->getMessage()}");
			$transaction->rollback();
		}
		
		return false;
	}
	
	public function faturar()
	{
		$transaction= Yii::app()->db->beginTransaction();
		
		try {
			
			Yii::import("application.components.Mailer.Mailer");
			$this->setAttribute('status', 'FATURADO');

			$fatura= new Fatura();
			$fatura->setAttribute('create_date', date('Y-m-d H:i:s', time()));
			$fatura->save();
		
			$this->setAttribute('fatura_id', $fatura->getPrimaryKey());
			$this->save();
		
			$mailer= new Mailer('MailerController');
			$mailer->sendInvoiceEmail($this);
			
			$transaction->commit();
			return true;
		}
		catch (Exception $e)
		{
			$transaction->rollback();
		}
		
		return false;
	}
	
	public function getItem(Produto $produto)
	{
		return ItemPedido::model()->find("produto_id= {$produto->getPrimaryKey()} AND pedido_id= {$this->getPrimaryKey()}");
	}
	
	public function removeItem(Produto $produto)
	{
		$item=  ItemPedido::model()->find("produto_id= {$produto->getPrimaryKey()} AND pedido_id= {$this->getPrimaryKey()}");
		if(count($item)>0)
		{
			$transaction= Yii::app()->db->beginTransaction();
			try {
				
				$quatidade_a_ser_reposta= $item->getAttribute("quantidade");
				if($item->delete())
				{
					$produto->setAttribute("qtd_estoque", $produto->getAttribute("qtd_estoque") + $quatidade_a_ser_reposta);
					if(!$produto->update(array("qtd_estoque")))
					{
						throw new CHttpException(500, 'Um produto foi removido e não houve reposição de estoque!');
					}
					
					$transaction->commit();
					return true;
				}
			}
			catch(Exception $e)
			{
				$transaction->rollback();
			}
		}
		
		return false;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pedido';
	}
	
	public function relations()
	{
		return array(
			'itens' => array(self::HAS_MANY, 'ItemPedido', 'pedido_id'),
			'cliente' => array(self::BELONGS_TO, 'Cliente', 'id_cliente'),
		);
	}
}