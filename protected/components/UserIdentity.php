<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Cliente::model()->find('username=? AND delete_date IS NULL',array($this->username));
		
		if($user===null) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else if ($this->password !== $user->password) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		} else {
			
			$this->_id=$user->getPrimaryKey();
			Yii::app()->getSession()->add('cliente', $user);
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
			
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}