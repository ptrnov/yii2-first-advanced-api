<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
		'login' => [
            'basePath' => '@app/modules/login',
            'class' => 'api\modules\login\Module',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
			'loginUrl' => null,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		/*input Json -ptr.nov- */
		'request' => [
			'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		/*
		'errorHandler' => [
			'errorAction' => ''v1/country',
		],
		*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
					[
					'class' => 'yii\rest\UrlRule',
                    'controller' =>
						[   //ptr,.nov penting buat API
							'site/error',
							'contoh/chart-bar2d',
							'login/user',
							'login/password',
							'login/signature',
							'login/profile'							
					],

                    //Ini dibutuhkan jika ID primary key bukan digital dalam bentuk regex
                    //contoh: CUS.001.CGK.1512
                    'tokens' =>
                    [
                      '{id}' => '<id:\\w+>',
                    ],
                ]
            ],
        ],
		/* Author -ptr.nov- : Test Project  */
		'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
		'errorHandler' => [
            'maxSourceLines' => 20,
        ],
		/**
		 * Handle Ajax content parsing & _CSRF
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		 */
		'request' => [
            'cookieValidationKey' => 'dWut4SrmYAaXg0NfqpPwnJa23RMIUG7j_it',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
            ]
        ],
    ],
    'params' => $params,
];



