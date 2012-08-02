<?php
class ItemPedido extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'item_pedido';
	}
	
	public function relations()
	{
		return array(
			'pedido' => array(self::BELONGS_TO, 'Pedido', 'pedido_id'),
			'produto'=> array(self::BELONGS_TO, 'Produto', 'produto_id')
		);
	}
}