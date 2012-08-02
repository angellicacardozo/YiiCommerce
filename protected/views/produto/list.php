<h3><?php echo $categoria->getAttribute('nome'); ?></h3>

<div class="grid">
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
	'emptyText'=>'Nenhum resultado foi encontrado',
	'summaryText'=>'Exibindo {start}-{end} de {count} resultado(s)',
	'sorterHeader'=>'Ordernar por',
    'itemView'=>'_resultado_busca',   // refers to the partial view named '_post'
    'sortableAttributes'=>array(
        'preco',
    ),
)); ?>
</div>