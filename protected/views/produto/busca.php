<h3><?php // I think a Decorator fits my need
	if(is_null($categoria))
	{
		if(strlen($modelo_consulta->getAttribute('nome'))==0)
		{
			echo 'Buscando em todas as categorias';
		}
		else
		{
			echo "Resultados para <i>{$modelo_consulta->getAttribute('nome')}</i> em todas as categorias";
		}
	}
	else
	{
		if(strlen($modelo_consulta->getAttribute('nome'))==0)
		{
			echo "Todos os resultados na categoria {$categoria->getAttribute('nome')}";
		}
		else
		{
			echo "Resultados para <i>{$modelo_consulta->getAttribute('nome')}</i> na categoria {$categoria->getAttribute('nome')}";
	
		}
	}
?></h3>
<div class="grid">
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
	'emptyText'=>'Nenhum resultado foi encontrado',
	'summaryText'=>'Exibindo {start}-{end} de {count} resultado(s)',
	'sorterHeader'=>'Ordernar por',
    'itemView'=>'_resultado_busca',   // refers to the partial view named '_resultado_busca'
    'sortableAttributes'=>array(
        'preco',
    ),
)); ?>
</div>