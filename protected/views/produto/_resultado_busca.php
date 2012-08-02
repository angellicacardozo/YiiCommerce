<?php if(isset($_GET['ajax'])) { ?>
    	<div>
        	<div class="imagem">
				<a class="popup" href="<?php echo $this->createUrl("/produto/view", array("id"=>$data->getPrimaryKey())); ?>"><img src="<?php echo $this->createUrl("/imagem/show", array("path"=>$data->getFilesCustomPath(), "file"=>$data->imagem, "width"=>160)); ?>" /></a>
			</div>
            <div>
            	<a href="#" class="nome"><?php echo utf8_encode($data->getAttribute("nome")); ?></a>
            	<span class="preco_por"><?php echo NumberDecorator::Currency($data->getAttribute('preco')); ?></span>
                <span class="descricao">
                	<?php echo utf8_encode($data->getAttribute('descricao_breve')); ?>
                </span>
            </div>
        </div>
<?php } else { ?>
    	<div>
        	<div class="imagem">
				<a class="popup" href="<?php echo $this->createUrl("/produto/view", array("id"=>$data->getPrimaryKey())); ?>"><img src="<?php echo $this->createUrl("/imagem/show", array("path"=>$data->getFilesCustomPath(), "file"=>$data->imagem, "width"=>160)); ?>" /></a>
			</div>
            <div>
            	<a href="#" class="nome"><?php echo $data->getAttribute("nome"); ?></a>
            	<span class="preco_por"><?php echo NumberDecorator::Currency($data->getAttribute('preco')); ?></span>
                <span class="descricao">
                	<?php echo $data->getAttribute('descricao_breve'); ?>
                </span>
            </div>
        </div>
<?php  } ?>

	<?php 
		if($index>0 && $index%3==0)
		{
			echo '<br class="unfloat" />';
		}
	?>