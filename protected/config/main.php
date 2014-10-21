<?php

Yii::setPathOfAlias('vendor', $_SERVER['DOCUMENT_ROOT'] . '/vendor');

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Barcode Generator',
	'language' => 'ru',
	// preloading 'log' component
	'preload' => array(
		'log',
	),
	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.components.Barcode.Barcode',
	),
	'defaultController' => 'system',
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'razdva',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array('*'),
		),
	),
	// application components
	'components' => array(
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'/' => '/system/index',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		'clientScript' => array(
			'coreScriptPosition' => CClientScript::POS_END,
			'defaultScriptPosition' => CClientScript::POS_END,
			'defaultScriptFilePosition' => CClientScript::POS_END,
			'packages' => array(
				'jquery' => array(
					'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/',
					'js' => array('jquery.min.js'),
				),
				'bootstrap-custom' => [
					'baseUrl' => '',
					'css' => array('web/css/bootstrap.min.css')
				],
				'bootstrap' => array(
					'baseUrl' => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/',
					'js' => array('js/bootstrap.min.js'),
					'depends' => array('jquery', 'bootstrap-custom')
				),
			)
		),
		'assetManager' => array(
			'forceCopy' => defined('YII_DEBUG') && YII_DEBUG
		),
		'db' => require_once 'db.php',
		'errorHandler' => array(
			'errorAction' => 'system/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CWebLogRoute',
					'enabled' => YII_DEBUG,
					'levels' => 'error, warning, profile, info'
				),
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
			),
		)
	),
	'params' => array(
	),
);
