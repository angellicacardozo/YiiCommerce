<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/produto.css"); ?>
	<div id="handleBuy">
    	<div id="img_cell">
        	<img src="<?php echo $this->createUrl("/imagem/show", array("path"=>$produto->getFilesCustomPath(), "file"=>$produto->imagem, "width"=>300)); ?>" />
        </div>
        <div id="buying">
        	<h1><?php echo $produto->getAttribute("nome"); ?></h1>
			<div><span>Categoria: <?php echo $produto->categoria->getAttribute("nome"); ?></span></div>
			
			<?php if($produto->isAvaiable()) { ?>
            	<span class="availGreen">Em estoque!</span>
            <?php } ?>
            
            <div id="fechar_pedido">
            	<div>
                    <span class="preco_por"><?php echo NumberDecorator::Currency($produto->getAttribute('preco')); ?></span>
                </div>
                <form method="post" action="<?php echo $this->createCartUrl()?>">
                	<input type="hidden" name="Produto[id]" value="<?php echo $produto->getPrimaryKey(); ?>" /> 
                	<div>
                    	<label for="qtd">Quantidade</label>
                        <select name="Produto[qtd]" id="qtd">
                        	<option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>    
                    <div>
                    	<input type="submit" value="Comprar" />
                    </div>
                </form>
            </div>
            
        </div>
    </div>