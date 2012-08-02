<?php
class Produto extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'produto';
	}
	
	public function relations()
	{
		return array(
			'categoria' => array(self::BELONGS_TO, 'Categoria', 'categoria_id'),
		);
	}
	
	public function rules()
	{
		return array(
			array('categoria_id,nome', 'safe'),
		);
	}
	
	public function getFilesCustomPath()
	{
		Yii::log("PRODUTO :: OS ARQUIVOS SERÃO ARMAZENADOS EM {$this->getPrimaryKey()}");
		return "/produtos/{$this->getPrimaryKey()}";
	}
	
	public static function listLastAdded()
	{
		return new CActiveDataProvider('Produto', array(
		    'criteria'=>array(
		        'condition'=>'is_disponivel=1',
		        'order'=>'create_time DESC',
		    ),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
	}
	
	public function isAvaiable()
	{
		return $this->getAttribute("qtd_estoque") > 0;
	}
	
	public function isQuantityAvaiable($qtd)
	{
		return ($this->getAttribute("qtd_estoque")-$qtd)>= 0;
	}
	
	public function returnToInventory($qtd)
	{
		$this->setAttribute("qtd_estoque", $this->getAttribute("qtd_estoque")+$qtd);
		return $this->update(array("qtd_estoque"));
	}
	
	public function getFromInventory($qtd)
	{
		if(!$this->isQuantityAvaiable($qtd))
			return false;
		
		$this->setAttribute("qtd_estoque", $this->getAttribute("qtd_estoque")-$qtd);
		return $this->update(array("qtd_estoque"));
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('nome', $this->nome, true);
		$criteria->compare('categoria_id', $this->categoria_id);
		$criteria->addCondition('delete_date IS NULL');
		$criteria->addCondition('qtd_estoque > 0');
		
		return new CActiveDataProvider('Produto', array(
			'criteria'=>$criteria
		));
	}
}