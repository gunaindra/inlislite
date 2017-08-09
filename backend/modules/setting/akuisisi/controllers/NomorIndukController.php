<?php
/**
 * @copyright Copyright &copy; Perpustakaan Nasional RI, 2016
 * @version 1.0.0
 * @author Andy Kurniawan <dodot.kurniawan@gmail.com>
 */

namespace backend\modules\setting\akuisisi\controllers;

use Yii;
use common\models\Settingparameters;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;

/**
 * SumberKoleksiController implements the CRUD actions for Collectionsources model.
 */
class NomorIndukController extends Controller
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
     * Form setting Settingparamaters models for akuisisi.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new DynamicModel([
            'NomorInduk',
            //'NomorIndukTengah',
            'FormatNomorBarcode',
            'FormatNomorInduk',
            'FormatNomorRFID'
        ]);
        $model->addRule([
            'NomorInduk',
            //'NomorIndukTengah',
            'FormatNomorBarcode',
            'FormatNomorInduk',
            'FormatNomorRFID'], 'required');

        $model->NomorInduk=Yii::$app->config->get('NomorInduk');
        //$model->NomorIndukTengah=Yii::$app->config->get('NomorIndukTengah');
        $model->FormatNomorBarcode=Yii::$app->config->get('FormatNomorBarcode');
        $model->FormatNomorInduk=Yii::$app->config->get('FormatNomorInduk');
        $model->FormatNomorRFID=Yii::$app->config->get('FormatNomorRFID');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) 
            {
                $post = Yii::$app->request->post();
                Yii::$app->config->set('NomorInduk', $post['DynamicModel']['NomorInduk']);
                //Yii::$app->config->set('NomorIndukTengah', Yii::$app->request->post('DynamicModel')['NomorIndukTengah']);
                Yii::$app->config->set('FormatNomorBarcode', $post['DynamicModel']['FormatNomorBarcode']);
                if(strtolower($post['DynamicModel']['NomorInduk'])=='otomatis')
                {
                    foreach ($post['cbTemplate'] as $key => $dataFormat) {
                       
                            if($dataFormat==1 && ($key == 0 || $key == 2 || $key == 4))
                            {
                                $post['cbTemplate'][$key] =  '{'.$post['cbTemplateInput'][$key].'}';
                            }
                        
                    }
                    Yii::$app->config->set('FormatNomorInduk', implode('|',$post['cbTemplate']));
                }
                Yii::$app->config->set('FormatNomorRFID', $post['DynamicModel']['FormatNomorRFID']);
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
            }else{

                var_dump($model);
            }
         }else{
                return $this->render('index', [
                'model' => $model,
            ]);
         }
    }
}
