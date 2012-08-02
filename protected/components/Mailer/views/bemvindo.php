<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
	<div style="font-family:'Century Gothic', sans-serif;font-size:26px;color: #333333">NegóciosDaInternet</div>
	<p>Seja bem-vindo a nossa loja virtual!</p>
	<p>Agora, toda vez que quiser voltar a nossa loja, basta efetuar login com os dados abaixo:</p>
	<ul>
		<li><strong>Usuário: </strong><span><?php echo $cliente->getAttribute('username'); ?></span></li>
		<li><strong>Senha: </strong><span><?php echo $cliente->getAttribute('password'); ?></span></li>
	</ul>
</body>
</html>