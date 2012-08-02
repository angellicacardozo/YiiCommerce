<div class="infoSummary mensagem">
	Olá <?php echo $cliente->getAttribute('nome'); ?>. Confira os dados da sua compra:
</div>
<form action="<?php echo $this->createUrl("pedido/finalizar"); ?>" method="post">
<div class="header">
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/meu_carrinho.jpg" alt="Meu Carrinho" />
	<div class="total">
		<span class="total">Total =</span>
		<span class="price"><?php echo NumberDecorator::Currency($pedido->getTotal()); ?></span><br />
		<input height="30" border="0" type="image" width="120" name="faturar" value="faturar" alt="Faturar Pedido" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/btn_faturar.png">
	</div>
</div>
<table cellpadding="0" cellspacing="0" id="cart-details">
        <tr>
            <th colspan="2">Itens do carrinho</th>
                <th>Preço</th>
                <th>Qtd</th>
            </tr>
            <?php foreach($pedido->itens as $n=>$item_pedido): ?>
            <tr>
            <td class="action">
                </td>
            <td class="product"><a href="#"><?php echo $item_pedido->produto->getAttribute("nome"); ?></a> - <span class="availGreen">Em estoque!</span>
                </td>
                <td><span class="price"><?php echo NumberDecorator::Currency($item_pedido->produto->getAttribute("preco")); ?></span></td>
                <td>
                <?php echo $item_pedido->getAttribute("quantidade"); ?>             
                </td>
            </tr>
            <?php endforeach;?>
</table>
</form>