<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'Xclusivo',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'languagepicker'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => 'xclusivo@mail.ru',
                'password' => 'testpassword',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en' => 'English', 'es' => 'Spanish', 'de' => 'German', 'no' => 'Norwegian'],
            'cookieName' => 'language',
            'expireDays' => 64,
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'on missingTranslation' => ['common\components\TranslationEventHandler', 'handleMissingTranslation']
                ],
                'on missingTranslation' => ['common\components\TranslationEventHandler', 'handleMissingTranslation']
            ],
        ],
        'formatter' => [
              'dateFormat' => 'dd.MM.yyyy',
              'datetimeFormat' => 'dd.MM.yyyy HH:mm'
         ],
		/*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => false,
			'rules' => [
				'products/create/<kind:[\w\-]+>' => 'products/create',
				//Standard routes, for example: "/users/12", "/users/update/22, /users/create" 
				//Add custom routing above (priority is from top to bottom)
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
'<module:\w+>/<action:\w+>' => '<module>/default/<action>',
'<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
'<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',				
			],
		],
		*/
    ],
    'sourceLanguage' => 'en',
    'language' => 'en',
    'params' => $params,
];
