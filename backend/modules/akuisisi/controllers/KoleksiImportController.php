<?php

namespace backend\modules\akuisisi\controllers;

use Yii;
use common\models\Requestcatalog;
use common\models\RequestcatalogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * KoleksiKarantinaController implements the CRUD actions for QuarantinedCollections model.
 */
class KoleksiImportController extends Controller
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
     * Lists all QuarantinedCollections models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new \backend\models\ImportAkuisisiForm();
        return $this->render('index', ['model' => $model]);

    }

    /**
     * Lists all QuarantinedCollections models.
     * @return mixed
     */
    public function actionProses()
    {
        if (Yii::$app->request->isPost) {
            $model = new \backend\models\ImportAkuisisiForm();
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            if($model->file)
            {
                if ($model->upload()) {

                   //$model->import();
                   if($model->import_aacr())
                   {
                        $model->deleteFile();
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'info',
                            'duration' => 500,
                            'icon' => 'fa fa-info-circle',
                            'message' => Yii::t('app','Data Koleksi Berhasil Diimport'),
                            'title' => 'Info',
                            'positonY' => Yii::$app->params['flashMessagePositionY'],
                            'positonX' => Yii::$app->params['flashMessagePositionX']
                            ]);
                        return $this->redirect(['index']);
                   }else{
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'danger',
                            'duration' => 500,
                            'icon' => 'fa fa-info-circle',
                            'message' => Yii::t('app','Data Koleksi Gagal Diimport'),
                            'title' => 'Info',
                            'positonY' => Yii::$app->params['flashMessagePositionY'],
                            'positonX' => Yii::$app->params['flashMessagePositionX']
                            ]);
                        return $this->redirect(['index']);
                   }
                }
            }
        }

    }


    /**
     * Finds the QuarantinedCollections model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param double $id
     * @return QuarantinedCollections the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requestcatalog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
