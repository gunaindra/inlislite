<?php

namespace backend\modules\opac\history\controllers;
use Yii;
use common\models\Opaclogs;
use common\models\OpaclogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BrowseController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $searchModel = new OpaclogsSearch;
        $params=Yii::$app->request->getQueryParams();
        $params['pencarian']='browse';
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    	
        return $this->render('index');

    }

}
