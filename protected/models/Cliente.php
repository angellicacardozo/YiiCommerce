<?php
class Cliente extends CActiveRecord
{
	private $_identity;
	public $rememberMe;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'cliente';
	}
	
	public function rules()
	{
		return array(
			array('nome, email, username, password, endereco', 'required'),
			array('email','uniqueEmail'),
			array('password','length','max'=>8, 'min'=>6),
			array('nome, email, password, endereco', 'safe'),
		);
	}
	
	public function uniqueEmail($attributes, $paramns)
	{
		$email= $this->email;
		$email_no_banco= Cliente::model()->find("email='{$email}'");
		if(count($email_no_banco)>0)
		{
			$this->addError('email',utf8_encode('O e-mail já está sendo usado.'));
		}
	}
	
	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
			$this->username= $this->email;
		}
		
		return true;
	}
	
	public function attributeLabels()
	{
		return array(
			'nome'=>'Nome',
			'email'=>'E-mail',
			'password'=>'Senha',
			'endereco'=>'Endere&ccedil;o'
		);
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		$this->_identity=new UserIdentity($this->username,$this->password);
		$this->_identity->authenticate();
		
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}