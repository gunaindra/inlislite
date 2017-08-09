<?php
namespace backend\modules\sirkulasi\controllers;

use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;
class PrintController extends Controller
{
    


    public function actionPrintKuitansi(){
        $this->layout = "@app/views/layouts/print";
        $transactionID = isset($_GET['transactionID']) ? $_GET['transactionID'] : null;
        //var_dump($transactionID);
        //echo $transactionID['transactionID'];
        if($transactionID != ""){
             $model = \common\models\Collectionloans::find()->where(['ID' => $transactionID])->one();
             return $this->render('viewstruk', array(
                                'collectionLoan_id'  => $transactionID,
                                'model'            => $model,
                            )); 

        }
    }

    /**
     * [actionCetakSlipPengembalian description]
     * @return [type] [description]
     */
    public function actionCetakSlipPengembalian(){

        $this->layout = "@app/views/layouts/print";
        $NoPinjam = isset($_GET['NoPinjam']) ? $_GET['NoPinjam'] : null;
        //var_dump($transactionID);
        //echo $transactionID['transactionID'];
        if($NoPinjam != ""){
             $model = \common\models\Collectionloanitems::find()
                        ->where(['CollectionLoan_id' => $NoPinjam])
                        ->andWhere(['LoanStatus' => 'Return'])
                        ->all();
             $content= $this->renderPartial('viewSlipPengembalian', array(
                                'collectionLoan_id'  => $NoPinjam,
                                'model'            => $model,
                            )); 


             $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'destination' => Pdf::DEST_BROWSER, 
                'format' => Pdf::FORMAT_A4, 
                'content' => $content,
                'options' => [
                    'title' => 'Slip Pengembalian',
                    'subject' => Yii::$app->config->get('NamaPerpustakaan')
                    ],
                    'methods' => [ 
                        'SetJS'=>['this.print();'], 
                    ]
                ]);
            
            return $pdf->render();
            
           

        } 
       
    }


    /**
     * [actionCetakSlipPelanggaran description]
     * @return pdf
     */
    public function actionCetakSlipPelanggaran(){
        $this->layout = "@backend/views/layouts/print";
        $NoPinjam = isset($_GET['NoPinjam']) ? $_GET['NoPinjam'] : null;
        //var_dump($transactionID);
        //echo $transactionID['transactionID'];
        if($NoPinjam != ""){
             $model = \common\models\Pelanggaran::find()
                        ->where(['CollectionLoan_id' => $NoPinjam])
                        //->andWhere(['LoanStatus' => 'Return'])
                        ->all();
            
              $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'destination' => Pdf::DEST_BROWSER, 
                'format' => Pdf::FORMAT_A4, 
                'content' => $this->renderPartial('viewSlipPelanggaran', 
                    [
                        'collectionLoan_id'  => $NoPinjam,
                        'model'            => $model,
                    ]),
                'options' => [
                    'title' => 'Slip Pelanggaran',
                    'subject' => Yii::$app->config->get('NamaPerpustakaan')
                    ],
                'methods' => [ 
                    'SetJS'=>['this.print();'], 
                ]
                ]);
            
            return $pdf->render();

        }
       
    }
}
