<div class="successSummary mensagem">
	Sua fatura foi gerada com sucesso! Um e-mail foi enviado para <?php echo $cliente->getAttribute('email'); ?>, informando os dados de seu pedido.
</div>
<div>
	<h2>Você será redirecionado para o site do PagSeguro. Obrigada por comprar conosco.</h2>
	<img src="<?php echo Yii::app()->theme->baseUrl."/css/images/PagSeguro1.jpg"; ?>" />
</div>