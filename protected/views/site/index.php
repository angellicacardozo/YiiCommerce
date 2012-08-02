<div class="grid">
	<?php $count= 1; ?>
	<?php foreach($lastAddedProducts->getData() as $product): ?>
    	<div>
        	<div class="imagem">
				<a class="popup" href="<?php echo $this->createUrl("/produto/view", array("id"=>$product->getPrimaryKey())); ?>"><img src="<?php echo $this->createUrl("/imagem/show", array("path"=>$product->getFilesCustomPath(), "file"=>$product->imagem, "width"=>160)); ?>" /></a>
			</div>
            <div>
            	<a href="#" class="nome"><?php echo $product->getAttribute("nome"); ?></a>
            	<span class="preco_por"><?php echo NumberDecorator::Currency($product->getAttribute('preco')); ?></span>
                <span class="descricao">
                	<?php echo $product->getAttribute('descricao_breve'); ?>
                </span>
            </div>
        </div>
	<?php 
		$count++;
		if($count==4)
		{
			echo '<br class="unfloat" />';
			$count= 1;
		}
	?>
	<?php endforeach; ?>
</div>