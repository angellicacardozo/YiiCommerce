<?php
return array(
	// Pedido n�o faturado para visitante do site
	'pedido_01'=> array(
		'id_session'=>Yii::app()->getSession()->getSessionID(),
		'status'=>'ABERTO',
		'create_date'=> date("Y-m-d H:i:s", time()),
	),
	// Pedido n�o faturado para cliente registrado
	'pedido_02'=> array(
		'status'=>'ABERTO',
		'create_date'=> date("Y-m-d H:i:s", time()),
		'id_cliente'=> '1',
	),
);