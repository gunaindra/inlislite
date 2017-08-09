<?php

namespace backend\modules\sirkulasi\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Stockopname;
use common\models\Stockopnamedetail;
use common\models\StockopnameSearch;
use common\models\StockopnamedetailSearch;
use common\models\Collections;
use yii\helpers\Json;

/**
 * StockopnameController implements the CRUD actions for Stockopname model.
 */
class StockopnameController extends Controller
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
     * Lists all Stockopname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockopnameSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Stockopname model.
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
     * Creates a new Stockopname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stockopname;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Save'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
            return $this->redirect(['update', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Stockopname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
            return $this->redirect(['update', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Stockopname model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * [actionDeleteDetail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionDeleteDetail($id)
    {
        $this->findModelDetail($id)->delete();
		Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 500,
                    'icon' => 'fa fa-info-circle',
                    'message' => Yii::t('app','Success Delete'),
                    'title' => 'Info',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Stockopname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stockopname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stockopname::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function findModelDetail($id)
    {
        if (($model = Stockopnamedetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * [actionDetail description]
     * @param  int $id stockopname
     * @return [type]     [description]
     */
    public function actionDetail($id)
    {

        /*echo \Yii::$app->params['footerInfoLeft'];
        echo \Yii::$app->params['footerInfoRight'];
        die;*/

        $model = new \yii\base\DynamicModel([
            'nomorBarcode'
        ]);

        $modelStockOpname = $this->findModel($id);
        $model->addRule(['nomorBarcode'], 'required');


        //Get data from model
        $searchModel = new StockopnamedetailSearch;

        $queryParams= Yii::$app->request->getQueryParams();
        $queryParams['StockopnamedetailSearch']['StockOpnameID'] = $id;
        $dataProvider = $searchModel->search($queryParams);


        // $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        // !get data from model

        // Get Scanned collections
        $ScannedCollections = Stockopnamedetail::find()->select('collections.NomorBarcode')->joinWith('collection')->where(['StockOpnameID'=>$id])->asArray()->all();
        foreach ($ScannedCollections as $ScannedCollections) {
            $ScannedCollectionItems[] = $ScannedCollections['NomorBarcode'];
        }
        // print_r($ScannedCollectionItems);die;
        // Get data for Unscanned Collections
        $sqlSelectCol = Collections::find(); 
        if ($ScannedCollectionItems) {
            $sqlSelectCol->Where(['NOT IN', 'NomorBarcode', $ScannedCollectionItems]);
        } 
        
        
        $dataProviderUnscannedCollections = new yii\data\ActiveDataProvider([
                'query' => $sqlSelectCol,
                // 'totalCount' => $count,
            ]);

        //Rekap Jumlah Koleksi Hasil Stock Opname
        $sqlCollectionStatus = 'SELECT ID,Name FROM collectionstatus';
        $command = Yii::$app->db->createCommand($sqlCollectionStatus)->queryAll();
        $sqlCountStatus = "";
        if(count($command) > 0){
            foreach($command as $item)
            {
                $sqlCountStatus .= ", (SELECT COUNT(*) FROM collections WHERE collections.Location_id=locations.ID AND collections.Status_id='" .$item['ID'] . "') as 'JumlahStatus" . $item['Name']."'";

            }
            $sqlSelect = 'SELECT ID,Name as LocationName,';
            $sqlSelect .= '(SELECT COUNT(*) FROM collections WHERE collections.Location_id=locations.ID) as JumlahKoleksi';
            $sqlSelect .= ',(SELECT COUNT(*) FROM stockopnamedetail INNER JOIN stockopname ON stockopnamedetail.StockOpnameID=stockopname.ID WHERE stockopnamedetail.CurrentLocationID=locations.ID AND stockopnamedetail.StockOpnameID='.$id.')as JumlahStockOpname';
            $sqlSelect .= $sqlCountStatus;
            $sqlSelect .= ' FROM locations';
            //echo  $sqlSelect . '<br/>';
            $count = Yii::$app->db->createCommand("SELECT count(*) from locations")->queryScalar();
            $dataProviderHasilStockOpname = new \yii\data\SqlDataProvider([
                'sql' => $sqlSelect,
                'totalCount' => $count,
            ]);
        }



        if(Yii::$app->request->post('hasEditable'))
        {
            $message= '';
            $id = Yii::$app->request->post('editableKey');
            $index = Yii::$app->request->post('editableIndex');
            $model = $this->findModelDetail($id);
            $post= [];
            $status = Yii::$app->request->post('Stockopnamedetail')[$index]['CurrentLocationID'];
            $post['Stockopnamedetail']['CurrentLocationID'] =  $status;
            if($model->load($post))
            {
                if($model->save())
                {
                    //$message = Yii::t('app','Success Save');
                }else{
                    //$message = /*print_r($model->getError())*/ 'Error save';
                }
            }else{
                //$message = 'Failed load model';
            }
            $out= Json::encode(['output'=>'','message'=>$message]);
            echo $out;


            $this->getView()->registerJs('
                $.pjax({container: "#stockopnameGrid-pjax"});
                $.pjax({container: "#summarykoleksiGrid-pjax"});
                ');
            return;
        }


        //var_dump($command);
        //die;


        return $this->render('createDetail', [
                    'model' => $model,
                    'modelStockOpname'=>$modelStockOpname,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'dataProdiverHasilStockOpname'=>$dataProviderHasilStockOpname,
                    'dataProviderUnscannedCollections'=>$dataProviderUnscannedCollections
                ]);
       
    }

    public function actionViewKoleksi()
    {
        if (Yii::$app->request->post()) {


            $stockopnameID = trim($_POST["StockopnameID"]);
            $NomorBarcode = trim($_POST["NomorBarcode"]);
            //echo $stockopnameID;
            //die;
            //$NoAnggota = trim($_POST["NoAnggota"]);
            //$memberID = trim($_POST["memberID"]);
            $TglTransaksi = trim($_POST["TglTransaksi"]);

            if ($TglTransaksi == ""){
                $LoanDate = date('Y-m-d');
            }
            else
            {
                $LoanDate = \common\components\Helpers::DateToMysqlFormat('-',$TglTransaksi);
            }

            if(isset($NomorBarcode) && $NomorBarcode != "")
            {
                $modelStockOpnameDetail = new Stockopnamedetail;

                $model              = \common\models\Collections::find()->where(['NomorBarcode'=>$NomorBarcode])->one();
                $modelStockOpnameCheck = Stockopnamedetail::find()->joinWith('collection')->where(['StockOpnameID'=>$stockopnameID,'collections.NomorBarcode'=>$NomorBarcode])->one();

                if ($modelStockOpnameCheck) 
                {
                    throw new \yii\web\HttpException(404, 'Item dengan nomor ini Sudah ada.');
                } 
                else 
                {    
                    if ($model) {
                        $modelStockOpnameDetail->StockOpnameID = $stockopnameID;
                        $modelStockOpnameDetail->CollectionID = $model->ID;
                        $modelStockOpnameDetail->PrevLocationID = $model->Location_id;
                        $modelStockOpnameDetail->CurrentLocationID = $model->Location_id;
                        $modelStockOpnameDetail->PrevStatusID = $model->Status_id;
                        $modelStockOpnameDetail->CurrentStatusID = $model->Status_id;
                        $modelStockOpnameDetail->PrevCollectionRuleID = $model->Rule_id;
                        $modelStockOpnameDetail->CurrentCollectionRuleID = $model->Rule_id;
                        $modelStockOpnameDetail->save();
                    } else {
                        throw new \yii\web\HttpException(404, 'Nomor Barcode tidak valid.');
                    }
                    
                }
                

              
                    
            }
            else
            {
                 throw new \yii\web\HttpException(404, 'Nomor Barcode tidak boleh kosong.');
            }
            
                
               
        }
                 
    }

}
