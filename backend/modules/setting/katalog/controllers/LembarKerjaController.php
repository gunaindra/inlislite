<?php

namespace backend\modules\setting\katalog\controllers;

use Yii;
use common\models\Worksheets;
use common\models\Worksheetfields;
use common\models\WorksheetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\base\DynamicModel;


/**
 * LembarKerjaController implements the CRUD actions for Worksheets model.
 */
class LembarKerjaController extends Controller
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
     * Lists all Worksheets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorksheetSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Worksheets model.
     * @param integer $id
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
     * Creates a new Worksheets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //echo ($_GET['copy'])?$_GET['copy']:'';
        $model = new Worksheets;
        //$model2 = [new Worksheetfields()];

        $model3 = new DynamicModel(['copyWorksheet',]);
        $model3->addRule(['copyWorksheet'], 'string');


        if ($_GET['copy']) 
        {
            if($this->findModel2($_GET['copy'])!=NULL)
            {
                $model2 = $this->findModel2($_GET['copy']);
            }
            else
            {
                $model2 = [new Worksheetfields()];
            }
        } else {
            $model2 = [new Worksheetfields()];
        }
        


        if ($model->load(Yii::$app->request->post())) {
            $model->Format_id = 1;
            if($model->save()){
                

                if(Worksheetfields::loadMultiple($model2, Yii::$app->request->post())){
                    $arr = Yii::$app->request->post('Worksheetfields', []);
                    foreach ($arr as $arra) {
                        $model2new = new Worksheetfields;
                        $model2new->Worksheet_id=$model->ID;
                        $model2new->Field_id=$arra['Field_id'];

                        $model2new->save();

                    }


                }
                
                //Management folder for digital content n cover
                
                //konten digital
                $pathKontenDigital = Yii::getAlias('@uploaded_files/dokumen_isi/'.$model->Name);

                //cover ori
                $pathCoverOriginal = Yii::getAlias('@uploaded_files/sampul_koleksi/original/'.$model->Name);

                //cover thumb
                $pathCoverThumbnail = Yii::getAlias('@uploaded_files/sampul_koleksi/thumbnail/'.$model->Name);


                if(!is_dir($pathKontenDigital))
                {
                    mkdir($pathKontenDigital , 0777);
                }

                if(!is_dir($pathCoverOriginal))
                {
                    mkdir($pathCoverOriginal , 0777);
                }

                if(!is_dir($pathCoverThumbnail))
                {
                    mkdir($pathCoverThumbnail , 0777);
                }

                //end Managament folder digital content  n cover
                
                
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
                    'model2' => $model2,
                    'model3' => $model3,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
                'model3' => $model3,
            ]);
        }
    }

    /**
     * Updates an existing Worksheets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($this->findModel2($id)!=NULL)
        {
            $model2 = $this->findModel2($id);
        }
        else
        {
            $model2 = [new Worksheetfields()];
        }
        $nameOld = $model->Name;
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->Format_id = 1;
            if($model->save())
            {
                if(Worksheetfields::loadMultiple($model2, Yii::$app->request->post()))
                {

                    $arr = Yii::$app->request->post('Worksheetfields', []);

                    $workshielfield = Worksheetfields::deleteAll(['Worksheet_id' => $id]);
                    // $sqldelcol = "DELETE FROM `worksheetfields` WHERE `Worksheet_id`=" . $id . ";";
                    // Yii::$app->db->createCommand($sqldelcol)->query();
                    
                    foreach ($arr as $loc) {
                        $model2new = new Worksheetfields;
                        $model2new->Worksheet_id=$model->ID;
                        $model2new->Field_id=$loc['Field_id'];
                        $model2new->save();

                    }}
                
                //Management folder for digital content n cover
                
                //konten digital
                $pathKontenDigitalOld = Yii::getAlias('@uploaded_files/dokumen_isi/'.$nameOld);
                $pathKontenDigitalNew = Yii::getAlias('@uploaded_files/dokumen_isi/'.$model->Name);

                //cover ori
                $pathCoverOriginalOld = Yii::getAlias('@uploaded_files/sampul_koleksi/original/'.$nameOld);
                $pathCoverOriginalNew = Yii::getAlias('@uploaded_files/sampul_koleksi/original/'.$model->Name);

                //cover thumb
                $pathCoverThumbnailOld = Yii::getAlias('@uploaded_files/sampul_koleksi/thumbnail/'.$nameOld);
                $pathCoverThumbnailNew = Yii::getAlias('@uploaded_files/sampul_koleksi/thumbnail/'.$model->Name);


                if($nameOld != $model->Name)
                {

                    if(is_dir($pathKontenDigitalOld))
                    {
                        rename($pathKontenDigitalOld,$pathKontenDigitalNew);
                    }else{
                        mkdir($pathKontenDigitalNew , 0777);
                    }

                    if(is_dir($pathCoverOriginalOld))
                    {
                        rename($pathCoverOriginalOld,$pathCoverOriginalNew);
                    }else{
                        mkdir($pathCoverOriginalNew , 0777);
                    }

                    if(is_dir($pathCoverThumbnailOld))
                    {
                        rename($pathCoverThumbnailOld,$pathCoverThumbnailNew);
                    }else{
                        mkdir($pathCoverThumbnailNew , 0777);
                    }

                }else{
                    if(!is_dir($pathKontenDigitalNew))
                    {
                        mkdir($pathKontenDigitalNew , 0777);
                    }

                    if(!is_dir($pathCoverOriginalNew))
                    {
                        mkdir($pathCoverOriginalNew , 0777);
                    }

                    if(!is_dir($pathCoverThumbnailNew))
                    {
                        mkdir($pathCoverThumbnailNew , 0777);
                    }
                }
                //end Managament folder digital content  n cover
                

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
                    'model2' => $model2,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    /**
     * Deletes an existing Worksheets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // $this->findModel2($id)->delete();
        Worksheetfields::deleteAll(['Worksheet_id' => $id]);
        // $col = "DELETE FROM `worksheetfields` WHERE `Worksheet_id` = " . $id . "; ";
        
        // Yii::$app->db->createCommand($col)->query();
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
     * Finds the Worksheets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Worksheets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Worksheets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
     protected function findModel2($id) {
        if (($model2 = Worksheetfields::findAll(['Worksheet_id' => $id]  )) !== null) {
            return $model2;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
