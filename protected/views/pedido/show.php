<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="errorSummary mensagem">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="successSummary mensagem">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<form action="<?php echo $this->createUrl("pedido/guest"); ?>" method="post">
<div class="header">
	<img src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/meu_carrinho.jpg" alt="Meu Carrinho" />
	<?php if(count($pedido->itens)>0) { ?>
	<div class="total">
		<span class="total">Total =</span>
		<span class="price"><?php echo NumberDecorator::Currency($pedido->getTotal()); ?></span><br />
		<input height="30" border="0" type="image" width="138" name="refresh" value="refresh" alt="Refresh" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/btn_atualizar_carrinho.png">
	</div>
	<?php } ?>
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
					<div class="tiny">
                    	<a name="1">Item added on December 1, 2010</a>
                    </div>
					<?php echo CHtml::linkButton('Excluir',array(
					      	  'submit'=>'',
					      	  'class'=>'delete',
					      	  'params'=>array('command'=>'excluir_item_pedido','id'=>$item_pedido->produto->getPrimaryKey()),
					      	  'confirm'=>"Deseja realmente excluir o este item do seu carrinho?")); ?>
                </td>
            	<td class="product"><a href="#"><?php echo $item_pedido->produto->getAttribute("nome"); ?></a> - <span class="availGreen">Em estoque!</span>
                </td>
                <td><span class="price"><?php echo NumberDecorator::Currency($item_pedido->produto->getAttribute("preco")); ?></span></td>
                <td>
                	<?php 
                		echo CHtml::hiddenField("ItemPedido[{$n}][pedido_id]", $pedido->getPrimaryKey());
                		echo CHtml::hiddenField("ItemPedido[{$n}][produto_id]", $item_pedido->produto->getPrimaryKey());
                		echo CHtml::textField("ItemPedido[{$n}][quantidade]", $item_pedido->getAttribute("quantidade"), array('class'=>'input-qtd'));
                		/*
                		echo CHtml::dropDownList("ItemPedido[{$item_pedido->getPrimaryKey()}][quantidade]", $item_pedido->getAttribute("quantidade"), array(
                			"1"=> 1,
                			"2"=> 2,
                			"3"=> 3
                		), array("id"=>"qtd")); */
                	?>              
                </td>
            </tr>
            <?php endforeach;?>
        </table>
</form>
<?php if(count($pedido->itens)>0) { ?>
	<?php echo CHtml::link('Finalizar Compra', array('pedido/finalizar'),array('id'=>'btn-finalizar-compra')); ?>
<?php } else { ?>
	 <div class="infoSummary mensagem">
	 	Seu carrinho ainda está vazio! Navegue em nosso site e escolha alguns itens :)
	 </div>
<?php } ?>

<?php Yii::app()->clientScript->registerScript('cart_script', "
	jQuery('input[name=refresh]').click(function(){
		jQuery(this).parent('form').submit();
	});
"); ?>