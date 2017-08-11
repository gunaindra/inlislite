<?php

namespace backend\modules\setting\umum\controllers;

use Yii;
use yii\base\DynamicModel;

class SettingUpdateController extends \yii\web\Controller
{
    public function actionIndex()
    {

    	$model = new DynamicModel([
            'IsActivatingImportingAuthorityData',
            'AuthorityDataLastDate',
            'IsActivatingKII',
            'KIICode',
            'KIILastUploadDate',            

        ]);
        $model->addRule([
            'IsActivatingImportingAuthorityData',
            'IsActivatingKII',], 'required');

        $model->IsActivatingImportingAuthorityData = Yii::$app->config->get('IsActivatingImportingAuthorityData');
        $model->AuthorityDataLastDate = Yii::$app->config->get('AuthorityDataLastDate');

        $model->IsActivatingKII = Yii::$app->config->get('IsActivatingKII');
        $model->KIICode = Yii::$app->config->get('KIICode');
        $model->KIILastUploadDate = Yii::$app->config->get('KIILastUploadDate');

        

        if ($model->load(Yii::$app->request->post())) 
        {
        	if ($model->validate()) 
        	{
                $date=date('Y-m-d H:i:s');
        		Yii::$app->config->set('IsActivatingImportingAuthorityData', Yii::$app->request->post('DynamicModel')['IsActivatingImportingAuthorityData']);
        		Yii::$app->config->set('IsActivatingKII', Yii::$app->request->post('DynamicModel')['IsActivatingKII']);
        		
        		Yii::$app->config->set('AuthorityDataLastDate', $date);
        		Yii::$app->config->set('KIILastUploadDate', $date); 
        		
        		Yii::$app->getSession()->setFlash('success', [
        			'type' => 'info',
        			'duration' => 500,
        			'icon' => 'fa fa-info-circle',
        			'message' => Yii::t('app','Success Save'),
        			'title' => 'Info',
        			'positonY' => Yii::$app->params['flashMessagePositionY'],
        			'positonX' => Yii::$app->params['flashMessagePositionX']
        			]);
        	}
        	else
        	{

        		Yii::$app->getSession()->setFlash('failed', [
        			'type' => 'error',
        			'duration' => 500,
        			'icon' => 'fa fa-info-circle',
        			'message' => Yii::t('app','Failed Save'),
        			'title' => 'Info',
        			'positonY' => Yii::$app->params['flashMessagePositionY'],
        			'positonX' => Yii::$app->params['flashMessagePositionX']
        			]);
        	}
        	return $this->redirect(['index']);
        }
        else
        {
        return $this->render('index',[
          'model' => $model,]);
        }
    }



    public function actionSetImportAuthority()
    {
        $data = Yii::$app->request->post();
        $param = $data['value'];
        Yii::$app->config->set($param, $data[$param]);
        
        Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Save'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                    ]);
        return print_r($data);
        // return $this->redirect('index');
    }

}
