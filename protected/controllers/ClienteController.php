<?php
class ClienteController extends Controller
{
	public function actionEnroll()
	{
		$client_enroll_form= new Cliente();
		$loginform=new LoginForm;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='enroll-form')
		{
			echo CActiveForm::validate($client_enroll_form);
			Yii::app()->end();
		}
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($loginform);
			Yii::app()->end();
		}
		
		if(isset($_POST['Cliente']))
		{
			$client_enroll_form->setAttributes($_POST['Cliente']);
			if($client_enroll_form->save())
			{
				if($client_enroll_form->login())
				{
					$this->redirect(array('pedido/finalizar'));
				}
			}
		}
		
		if(isset($_POST['LoginForm']))
		{
			$loginform->attributes=$_POST['LoginForm'];
			if($loginform->validate() && $loginform->login())
				$this->redirect(array('pedido/client'));
		}
		
		$this->render('enroll', array(
			'client_enroll_form'=>$client_enroll_form,
			'loginform'=>$loginform
		));
	}
}