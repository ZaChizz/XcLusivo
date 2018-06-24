<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	// 'sourceLanguage' => 'en',
	

	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'site/page/<id:>' => 'site/page',
			]
		],
		'i18n' => [
                    'translations' => [
                        '*' => [
                                'class' => 'yii\i18n\PhpMessageSource',
                                'basePath' => '@common/messages',
                                'sourceLanguage' => 'en',
                                'fileMap' => [
                                        'booking' => 'booking.php',
                                ],
                        ],
                        'eauth' => array(
                                'class' => 'yii\i18n\PhpMessageSource',
                                'basePath' => '@eauth/messages',
                            ),
                    ],
		],
            
            
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
		'eauth' => array(
			'class' => 'nodge\eauth\EAuth',
			'popup' => true, // Use the popup window instead of redirecting.
			'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
			'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
	//			'httpClient' => array(
			// uncomment this to use streams in safe_mode
			//'useStreamsFallback' => true,
	//			),
	//			'tokenStorage' => array(
	//				'class' => '@app\eauth\DatabaseTokenStorage',
	//			),
			'services' => array(
                                'facebook' => array(
					// register your app here: https://developers.facebook.com/apps/
					'class' => 'nodge\eauth\services\FacebookOAuth2Service',
					//'clientId' => '1098406496862196',
					//'clientSecret' => 'b5036f115ecf113467d50c1295928e89',
                                        'clientId' => '1734796233448345',
                                        'clientSecret' => '3041f16e1f0a51d1a1b538e647a68f95',
                                    
				),
				'google_oauth' => array(
					// register your app here: https://code.google.com/apis/console/
					'class' => 'nodge\eauth\services\GoogleOAuth2Service',
					'clientId' => '202553642807-m4tok34mvtmnvjd1qitll4pdhlar0rtj.apps.googleusercontent.com',
					'clientSecret' => 'pykAYVMGUpONLZgXg8GS8OVS',
					'title' => 'Google',
				),
			),
		),
		'fixer' => [
			'class' => 'common\components\Fixer',
			'base' => 'USD',
		],
		

	],
];
