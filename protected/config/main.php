<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('booster', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../extensions/booster');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'language'=>'es',
	'sourceLanguage'=>'es',
        'defaultController' => 'site/login', 
	'name'=>'Sistema de Gestión del Estudiante',

	
	// preloading 'log' component
	'preload'=>array('log', 'booster'),
	'theme'=>'heart',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array('ext.heart.gii'),
		),
		
	),

	// application components
	'components'=>array(   
                'properties' => array(
                    'class' => 'ext.components.properties',
                ),
                'messages'=>array(
                    'basePath'=>Yiibase::getPathOfAlias('application.messages')
                    ),
				'user'=>array(
					// enable cookie-based authentication
					'allowAutoLogin'=>true,
				),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,                    
                        'cacheID' => false,
//                        'useStrictParsing'=>true,
//                        'caseSensitive'=>false,
			'rules'=>array(
                                ''=>array('site/index', 'urlSuffix'=>''),
                                'login'=>array('site/login', 'urlSuffix'=>''),
                                '<action>'=>array('site/<action>', 'urlSuffix'=>''),                                
				'<controller:\w+>'=>'<controller>/list',
                                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                                '<controller:\w+>/<id:\d+>/<title>'=>'<controller>/view',
                                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'trace, info, error, warning',
                                        'categories'=>'system.*',
                                        'logFile' => date('Ymd').'.log',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),		
		'booster'=>array(
			'class'=>'booster.components.Booster',
			'responsiveCss' => true,
			//'fontAwesomeCss'=>true,
			//'minify'=>true,
		),
		'themeManager' =>array(
			'basePath'=>'protected/extensions',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'marcosrole@gmail.com',
	),
);
