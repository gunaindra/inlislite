<?php

namespace backend\modules\member\controllers;

use Yii;
use common\models\MemberPerpanjangan;
use common\models\MemberPerpanjanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PerpanjangController implements the CRUD actions for MemberPerpanjangan model.
 */
class PerpanjangController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MemberPerpanjangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberPerpanjanganSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single MemberPerpanjangan model.
     * @param double $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 
        return $this->redirect(['view', 'id' => $model->ID]);
        } else {
        return $this->render('view', ['model' => $model]);
}
    }

    /**
     * Creates a new MemberPerpanjangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

       
        $member = explode('-',$_POST['MemberPerpanjangan']['Member_id']);
        $memberNo = trim($member[0]);

        $modelMember = \common\models\Members::find()->where(['MemberNo'=>$memberNo])->one();
        /*echo ($modelMember->Fullname);
        die;*/
        $model = new MemberPerpanjangan;

        if ($model->load(Yii::$app->request->post())) {
            $model->Member_id = $modelMember->ID;
            $model->Tanggal = \common\components\Helpers::DateToMysqlFormat('-',$model->Tanggal);
            if($model->save()){
                $modelMember->EndDate =$model->Tanggal;
                $modelMember->save(false);
            }
			Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Save'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MemberPerpanjangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param double $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Edit'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MemberPerpanjangan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param double $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Delete'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the MemberPerpanjangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param double $id
     * @return MemberPerpanjangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberPerpanjangan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Find the data members by member numbers.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  string $memberNo
     * @return json members data
     * @throws HttpException if the model cannot be found
     */
    public function actionCheckMembership($memberNo)
    {
        if (($model = \common\models\Members::findOne(['MemberNo'=>$memberNo])) !== null) {
             $data = [
                          
                          'Fullname' => $model->Fullname,
                          'EndDate' =>  \common\components\Helpers::DateTimeToViewFormat($model->EndDate),
                          'Biaya' =>   $model->jenisAnggota->BiayaPerpanjangan,
                            
                      ];

            return \yii\helpers\Json::encode($data);
        } else {
            throw new \yii\web\HttpException(404, 'No.Anggota '. $memberNo . ' tidak ada pada database kami.');
        }
    }
}
