<?php
$yii=dirname(__FILE__).'/yii1.1.7.r3135/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$constantes=dirname(__FILE__).'/protected/config/constantes.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($constantes);
require_once($yii);

Yii::createWebApplication($config)->run();
