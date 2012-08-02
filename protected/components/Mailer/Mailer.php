<?php
class Mailer extends CExtController
{
	public $layout= false;
	const FROMNAME= "Meu comercio eletronico";
	
	public function sendInvoiceEmail(Pedido $pedido)
	{
		Yii::import("application.components.Mailer.PHPMailer");
		global $debug;
	    $debug= false;
	    
	    $mail= new PHPMailer(true);
	    $mail->IsSMTP();
	    
	 	try {
	     
	      $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	      $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	      $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	      $mail->SMTPAuth   = true;                  // enable SMTP authentication
	      $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
	      $mail->Username   = "xxxxxx@gmail.com"; // SMTP account username
	      $mail->Password   = "xxxxx";        // SMTP account password
	      
	      if ($debug) {
	          $mail->AddAddress("xxxxx@gmail.com", $destinationName);
	      } else
	          $mail->AddAddress($pedido->cliente->getAttribute('email'), $pedido->cliente->getAttribute('nome'));
	      
	      $mail->From= 'xxxxx@gmail.com';
	      $mail->FromName= self::FROMNAME;
	      $mail->Subject = 'Obrigada por comprar em nosso site!';
	     
	      $mail->MsgHTML($this->renderFile($this->getViewPath().'\fatura.php', array('cliente'=>$pedido->cliente, 'pedido'=>$pedido), true));
	      $mail->Send();
	      // echo "Message Sent to {$destination} OK</p>\n";
	      
		} catch (phpmailerException $e) {
			//echo $e->errorMessage();
			return false;
		} catch (Exception $e) {
			//echo $e->getMessage();
			return false;
		}
			return true;
	}
	
	public function sendWelcomeEmail(Cliente $cliente)
	{
		Yii::import("application.components.Mailer.PHPMailer");
		global $debug;
	    $debug= false;
	    
	    $mail= new PHPMailer(true);
	    $mail->IsSMTP();
	    
	 	try {
	     
	      $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	      $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	      $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	      $mail->SMTPAuth   = true;                  // enable SMTP authentication
	      $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
	      $mail->Username   = "xxxxxxx@gmail.com"; // SMTP account username
	      $mail->Password   = "xxxxxxx";        // SMTP account password
	      
	      if ($debug) {
	          $mail->AddAddress("xxxxxxt@gmail.com", $destinationName);
	      } else
	          $mail->AddAddress($cliente->getAttribute('email'), $cliente->getAttribute('nome'));
	      
	      $mail->From= 'xxxxx@gmail.com';
	      $mail->FromName= self::FROMNAME;
	      $mail->Subject = 'Bem-vindo ao site';
	     
	      $mail->MsgHTML($this->renderFile($this->getViewPath().'\bemvindo.php', array('cliente'=>$cliente), true));
	      $mail->Send();
	      // echo "Message Sent to {$destination} OK</p>\n";
	      
		} catch (phpmailerException $e) {
			//echo $e->errorMessage();
			return false;
		} catch (Exception $e) {
			//echo $e->getMessage();
			return false;
		}
			return true;
	}
}