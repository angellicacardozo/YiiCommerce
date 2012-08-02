<?php
class PedidoTest extends CDbTestCase
{
	public $fixtures= array(
		'clientes'=> ':Cliente',
		'pedidos'=>':Pedido',
		'produtos'=> ':Produto',
		'itens'=>':Item_pedido'
	);
	
	public function testRetrieveSessionId()
	{
		$session_id= Yii::app()->getSession()->getSessionID();
		$this->assertTrue(strlen($session_id)>0);
	}
	
	public function testOpenInvoiceGuestUser()
	{
		Yii::import("application.models.Pedido");
		
		$pedido= Pedido::open();
		$this->assertTrue(is_null($pedido->getAttribute("cliente_id")));
	}
	
	public function testOpenInvoiceLoggedUser()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		
		$cliente_01= Cliente::model()->findByPk(1);
		$pedido= Pedido::open($cliente_01);
		
		$this->assertTrue($pedido->getAttribute("id_cliente")==$cliente_01->getPrimaryKey());
	}
	
	public function testAddItem()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Produto");
		
		$produto= Produto::model()->findByPk(1);
		
		$pedido= Pedido::open();
		$pedido->addItem($produto, 2);
		
		$this->assertTrue(count($pedido->getItem($produto))>0 && $pedido->getItem($produto)->getAttribute("quantidade")==2);
	}
	
	public function testAddTwoItem()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Produto");
		
		$produto= Produto::model()->findByPk(1);
		
		$pedido= Pedido::open();
		$pedido->addItem($produto, 2);
		
		$produto= Produto::model()->findByPk(2);
		
		$item= $pedido->getItem($produto);
		$this->assertTrue(count($item)==0);
	}
	
	public function testIncreaseQuantity()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Produto");
		
		$produto= Produto::model()->findByPk(1);
		
		$pedido= Pedido::open();
		$pedido->addItem($produto, 2);
		$pedido->addItem($produto, 2);
		
		$this->assertTrue($pedido->getItem($produto)->getAttribute("quantidade")==4);
	}
	
	public function testRemoveItem()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Produto");
		
		$produto= Produto::model()->findByPk(1);
		
		$pedido= Pedido::open();
		$pedido->addItem($produto, 2);
		$pedido->removeItem($produto);
		
		// Testar a reposição da quantidade no estoque
		$this->assertTrue(count($pedido->getItem($produto))==0);
	}
	
	public function testBatchItemUpdate()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Produto");
		
		$pedido= Pedido::open();
		$produto= Produto::model()->findByPk(1);
		$pedido->addItem($produto, 2);
		
		$post_array= array(
			'ItemPedido'=>array(
				array(
					'produto_id'=>1,
					'pedido_id'=>1,
					'quantidade'=>3
				),
			)
		);
		
		foreach($post_array['ItemPedido'] as $item)
		{
			$produto= Produto::model()->findByPk($item['produto_id']);
			if(count($produto)>0)
			{
				$itempedido= $pedido->getItem($produto);
				$produto->returnToInventory($itempedido->getAttribute('quantidade'));
				
				$quantidade= $item['quantidade'];
				if($produto->getFromInventory($quantidade))
				{
					if(count($itempedido)>0)
					{
						$itempedido->setAttribute('quantidade', $quantidade);
						if(!$itempedido->update(array('quantidade')))
						{
							throw new CHttpException(500,"Falha ao atualizar carrinho de compras");
						}
					}
					else
					{
						throw new CHttpException(500,"O inventario foi atualizado sem atualizacao de item de produto");
					}
				}
			}
		}
		
		$item= $pedido->getItem($produto);
		$this->assertTrue($item->getAttribute('quantidade')==3);
		$this->assertTrue($produto->getAttribute('qtd_estoque')==7);
	}
	
	public function testFaturarPedido()
	{
		Yii::import("application.models.Pedido");
		Yii::import("application.models.Cliente");
		Yii::import("application.models.Fatura");
		Yii::import("application.components.Mailer.Mailer");
		
		// Devemos faturar o pedido para o cliente em questao
		$cliente= Cliente::model()->findByPk($this->clientes['cliente_01']);
		$cliente->login();
		
		$mailer= new Mailer('MailerController');
		$this->assertTrue($mailer->sendWelcomeEmail($cliente));
		
		$pedido= Pedido::open();
		$produto= Produto::model()->findByPk(1);
		
		$pedido->addItem($produto, 2);
		$pedido->setAttribute('id_cliente', $cliente->getPrimaryKey());
		$pedido->setAttribute('status', 'FATURADO');

		$fatura= new Fatura();
		$fatura->setAttribute('create_date', date('Y-m-d H:i:s', time()));
		$fatura->save();
		
		$pedido->setAttribute('fatura_id', $fatura->getPrimaryKey());
		$pedido->save();
		
		$this->assertTrue($mailer->sendInvoiceEmail($pedido));
		
		$this->assertTrue($pedido->getAttribute('status')=='FATURADO');
	}
}