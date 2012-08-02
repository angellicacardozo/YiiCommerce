<?php
class ProdutoController extends Controller
{
	public function actionView()
	{
		$produto= Produto::model()->findByPk(Yii::app()->getRequest()->getParam('id'));
		$this->render('view', array(
			'produto'=> $produto
		));
	}
	
	public function actionList()
	{
		$this->layout= "search";
		$produto= new Produto();
		$categoria= Categoria::model()->findByPk(Yii::app()->getRequest()->getParam('categoria', 1));
		
		$produto->setAttribute('categoria_id', Yii::app()->getRequest()->getParam('categoria', 1));
		
		$dataProvider= $produto->search();
		
		$this->render('list', array(
			'dataProvider'=>$dataProvider,
			'categoria'=>$categoria
		));
	}
	
	public function actionBusca()
	{
		$this->layout= "search";
		$produto= new Produto();
		
		$session = new CHttpSession;
		$session->open();
		$session->setTimeout(120);
		
		$categoria= null;
		
		if(isset($_POST['Produto']))
		{
			$produto->setAttribute('categoria_id', $_POST['Produto']['categoria_id']);
			$categoria= Categoria::model()->findByPk($_POST['Produto']['categoria_id']);
			$produto->setAttribute('nome', $_POST['Produto']['nome']);
			$session["post_produto"]= $_POST['Produto'];
		}
		
		if(isset($session["post_produto"]))
		{
			$produto->setAttributes($session["post_produto"]);
		}
		
		$dataProvider= $produto->search();
		
		$this->render('busca', array(
			'dataProvider'=>$dataProvider,
			'categoria'=> $categoria,
			'modelo_consulta'=> $produto
		));
	}
}