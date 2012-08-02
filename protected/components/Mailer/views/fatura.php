<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
	<div style="font-family:'Century Gothic', sans-serif;font-size:26px;color: #333333">NegóciosDaInternet</div>
	<p>Olá, <?php echo $cliente->getAttribute('nome'); ?>. Obrigado por comprar em nossa loja virtual!</p>
	<p>Confira os dados de sua compra:</p>
	<div style="font-family:'Century Gothic', sans-serif;font-size:20px;color: #333333">Pedido número <?php echo $pedido->getPrimaryKey(); ?></div>
	<table style="width: 100%">
		<tr>
			<td style="background-color: #00CCFF; color: #333; font-weight: bold;padding: 4px">Item</td>
			<td style="background-color: #00CCFF; color: #333; font-weight: bold;padding: 4px">Quantidade</td>
			<td style="background-color: #00CCFF; color: #333; font-weight: bold;padding: 4px">Valor unitário</td>
		</tr>
	<?php Yii::import("application.components.NumberDecorator"); ?>
	<?php foreach($pedido->itens as $item) { ?>
		<tr>
			<td style="padding: 4px"><?php echo $item->produto->getAttribute('nome'); ?></td>
			<td style="padding: 4px"><?php echo $item->getAttribute('quantidade'); ?></td>
			<td style="padding: 4px"><?php echo NumberDecorator::Currency($item->produto->getAttribute('preco')); ?></td>
		</tr>
	<?php } ?>
	</table>
	<div>
		<p style="font-family:'Century Gothic', sans-serif;font-size:28px;color: #333333;padding: 4px">Total: <?php echo NumberDecorator::Currency($pedido->getTotal()); ?></p>
	</div>
</body>
</html>