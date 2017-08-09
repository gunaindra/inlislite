<?php

namespace keanggotaan\controllers;

use Yii;
use common\models\Requestcatalog;
use common\models\RequestcatalogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsulanKoleksiController implements the CRUD actions for Requestcatalog model.
 */
class UsulanKoleksiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Requestcatalog models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new RequestcatalogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);*/

        $model = new Requestcatalog;
        
        if ($model->load(Yii::$app->request->post())) {
            $model->MemberID = Yii::$app->user->identity->id;
            $model->DateRequest = date('Y-m-d');
            
            $model->Status = 'Usulan';
            if($model->save()){
                return $this->redirect(['index']);
              
            }else{
                print_r($model->getErrors());
                
            }
           /* Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Save'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);*/
           
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    
}
