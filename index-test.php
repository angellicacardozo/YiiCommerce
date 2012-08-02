<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../SANDBOX/yii1.1.7.r3135/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';
$constantes=dirname(__FILE__).'/protected/config/constantes.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($constantes);
require_once($yii);

Yii::createWebApplication($config)->run();
