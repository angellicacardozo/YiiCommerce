<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/cart.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.hoverIntent.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/short_menu.js"></script>
<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<body class="cart">
<div id="container">
<div id="header">
	<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
	<?php if(Yii::app()->user->isGuest) { ?>
		<span>Olá convidado! <a href="<?php echo $this->createUrl('site/login'); ?>">Efetuar login</a></span>
	<?php } else { ?>
		<span>Olá <?php echo Yii::app()->getSession()->get('cliente')->getAttribute('nome'); ?>! <a href="<?php echo $this->createUrl('site/logout'); ?>">Sair</a></span>
	<?php } ?>
</div>
<div id="busca">
	<form action="<?php echo $this->createUrl('produto/busca');?>" method="post">
    	<div>
        	<select name="Produto[categoria_id]">
        		<option value="">TODOS</option>
            	<option value="1">Televisores</option>
                <option value="2">Livros</option>
            </select>
        </div>
        <div>
        	<input name="Produto[nome]" type="text" size="40" />
        </div>
        <div>
        	<input value="Buscar" type="submit" />
        </div>
    </form>
</div>

<div id="wrapper">
    <div id="content">
	<?php echo $content; ?>
    </div>
</div>
<div id="navigation">
	<ul>
    	<li id="show_cats"><a href="#">Loja (+)</a>
	        	<ul>
	            	<li><a href="<?php echo $this->createUrl('produto/list', array('categoria'=>1));?>">Televisores</a></li>
	            	<li><a href="<?php echo $this->createUrl('produto/list', array('categoria'=>2));?>">Livros</a></li>
	        	</ul>
        </li>
    </ul>
</div>

<div id="footer"><p>Negócios da Internet</p></div>
</div>
</body>
</html>