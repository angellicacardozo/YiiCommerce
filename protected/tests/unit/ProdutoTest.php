<?php
class ProdutoTest extends CDbTestCase
{
	public $fixtures= array(
		'produtos'=> ':Produto',
	);
	
	public function testRetrive()
	{
		Yii::import("application.models.Produto");
		
		$produto= new Produto();
		
		$produto->setAttribute('categoria_id', 1);
		$produto->setAttribute('nome', 'Panasonic');
		
		$result= $produto->search()->getData();
		
		$this->assertTrue($result[0]->getAttribute('nome')==$this->produtos['produto_01']['nome']);
	}
}