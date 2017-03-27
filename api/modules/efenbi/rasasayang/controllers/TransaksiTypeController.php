<?php
namespace api\modules\efenbi\rasasayang\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;


use api\modules\efenbi\rasasayang\models\TransaksiType;
use api\modules\efenbi\rasasayang\models\TransaksiTypeSearch;
		
/**
 * StoreController implements the CRUD actions for Store model.
 */
class TransaksiTypeController extends ActiveController
{
    /**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\efenbi\rasasayang\models\TransaksiTypeSearch';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'TYPE',
	]; 
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 // ['class' => HttpBearerAuth::className()],
                 // ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
            ], 
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				],
				'languages' => [
					'en',
					'de',
				],
			],			
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['*'],
					'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
        ]);
		
    }
	
	public function actions()
    {		
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function () {
					
					$param=["TransaksiTypeSearch"=>Yii::$app->request->queryParams];
					//return $param;
                    $searchModel = new TransaksiTypeSearch();
                    return $searchModel->search($param);
					
					/**
					  * Manipulation Class Molel search & Yii::$app->request->queryParams.
					  * Author	: ptr.nov@gmail.com
					  * Since	: 06/03/2017
					 */
                    //return $searchModel->search(Yii::$app->request->queryParams);
					//Use URL : item-groups?ItemGroupSearch[ITEM_BARCODE]=0001.0001
					//UPDATE
					//Use URL : item-groups?ITEM_BARCODE=0001.0001
					//$param=["ItemGroupSearch"=>Yii::$app->request->queryParams];
					//return$searchModel->search($param);
                },
            ],
        ];
    }	
}

