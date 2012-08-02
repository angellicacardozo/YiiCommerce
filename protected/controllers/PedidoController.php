<?php
class PedidoController extends Controller
{
	public $layout="cart";
	
	public function actionFinalizar()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array("cliente/enroll"));
		}
		
		// Fatura pedido
		$cliente= Cliente::model()->findByPk(Yii::app()->user->getId());
		$pedido= Pedido::open($cliente);
		
		if(isset($_POST['faturar']))
		{
			if($pedido->faturar())
			{
				$this->redirect(array('poscompra'));
			}
			else 
			{
				Yii::app()->user->setFlash('error', 'Falha ao finalizar o pedido.');
			}
		}
		
		$this->render('faturar', array('cliente'=>$cliente, 'pedido'=> $pedido));
	}
	
	public function actionPoscompra()
	{
		$cliente= Cliente::model()->findByPk(Yii::app()->user->getId());
		$this->render('poscompra', array('cliente'=>$cliente));
	}
	
	public function actionGuest()
	{
		$pedido= Pedido::open();
		
		$this->comandoExcluirItemPedido($pedido);
		
		if(isset($_POST['Produto']))
		{
			$produto= Produto::model()->findByPk($_POST['Produto']['id']);
			if(count($produto)>0)
			{
				$pedido->addItem($produto, $_POST['Produto']['qtd']);
			}
		}
		
		if(isset($_POST['refresh']))
		{
			if($pedido->batchItemUpdate($_POST))
			{
				Yii::app()->user->setFlash('success', 'Pedido atualizado com sucesso!');
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Falha ao atualizar o pedido. Alguns itens econtram-se com estoque limitado.');
			}
		}
		
		$this->render('show', array(
			'pedido'=> $pedido
		));
	}
	
	protected function comandoExcluirItemPedido(Pedido $pedido)
	{
		if(isset($_POST['command']) && $_POST['command']==='excluir_item_pedido')
		{
			$produto= Produto::model()->findByPk($_POST['id']);
			if($pedido->removeItem($produto))
			{
				$this->refresh();
			}
			else
			{
				Yii::app()->user->setFlash("warning","Falha ao remover item do carrinho.");
			}
		}
	}
	
	public function actionClient()
	{
		$cliente= Cliente::model()->findByPk(Yii::app()->user->getId());
		$pedido= Pedido::open($cliente);
		
		$this->comandoExcluirItemPedido($pedido);
		
		if(isset($_POST['Produto']))
		{
			$produto= Produto::model()->findByPk($_POST['Produto']['id']);
			if(count($produto)>0)
			{
				$pedido->addItem($produto, $_POST['Produto']['qtd']);
			}
		}
		
		if(isset($_POST['refresh']))
		{
			if($pedido->batchItemUpdate($_POST))
			{
				Yii::app()->user->setFlash('success', 'Pedido atualizado com sucesso!');
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Falha ao atualizar o pedido. Alguns itens econtram-se com estoque limitado.');
			}
		}
		
		$this->render('show', array(
			'pedido'=> $pedido
		));
	}
}