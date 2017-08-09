<?php

namespace backend\modules\laporan\controllers;


use Yii;
use yii\helpers\Url;
//Widget
use yii\widgets\MaskedInput;
use kartik\widgets\Select2;
use kartik\mpdf\Pdf;
use kartik\date\DatePicker;

//Helpers
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//Models
use common\models\Catalogs;
use common\models\LocationLibrary;
use common\models\Locations;
use common\models\Collectionsources;
use common\models\Partners;
use common\models\Currency;
use common\models\Members;
use common\models\Users;
// use common\models\Collectioncategorys;
use common\models\Collectionrules;
// use common\models\Worksheets;
// use common\models\Collectionmedias;
// use common\models\MasterKelasBesar;
use common\models\VLapKriteriaKoleksi;


class KoleksiController extends \yii\web\Controller
{
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * [actionKoleksiPerkriteria description]
     * @return [type] [description]
     */
    public function actionPeriodik()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-periodik',[
            'model' => $model,
            ]);
    }

    
    /**
     * [actionloadFilterKriteria description]
     * @param  [type] $kriteria [description]
     * @return [type]           [description]
     */
    public function actionLoadFilterKriteria($kriteria)
    { 
        if ($kriteria == 'PublishLocation')
        {
            $sql = 'SELECT SPLIT_STR(catalogs.PublishLocation,":", 1) AS selecter FROM catalogs GROUP BY selecter';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'selecter','selecter');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'Publisher')
        {
            $sql = 'SELECT SPLIT_STR(catalogs.Publisher,",", 1) AS selecter FROM catalogs GROUP BY selecter';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'selecter','selecter');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        
        else if ($kriteria == 'PublishYear')
        {
            $sql = 'SELECT * FROM catalogs';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','PublishYear');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'location_library')
        {
            $sql = 'SELECT * FROM location_library';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'locations')
        {
            $sql = 'SELECT * FROM locations';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'collectionsources')
        {
            $sql = 'SELECT * FROM collectionsources';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'partners')
        {
            $sql = 'SELECT * FROM partners';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'currency')
        {
            $options =  ArrayHelper::map(Currency::find()->orderBy('Sort_ID')->asArray()->all(),'Currency',
                function($model) {
                    return $model['Currency'].' - '.$model['Description'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'collectioncategorys')
        {
            $sql = 'SELECT * FROM collectioncategorys';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'collectionrules')
        {
            $sql = 'SELECT * FROM collectionrules';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'kataloger')
        {
            $options =  ArrayHelper::map(Users::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['username'];
                });

            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'worksheets')
        {
            $sql = 'SELECT * FROM worksheets';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'collectionmedias')
        {
            $sql = 'SELECT * FROM collectionmedias';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Name');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'Subject')
        {
            $sql = 'SELECT * FROM catalogs';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Subject');
            $options[0] = "---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'no_klas')
        {
            $sql = 'SELECT *, SUBSTR(master_kelas_besar.kdKelas,1,1) AS test FROM master_kelas_besar';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'test','namakelas');
            $options[null] = " ---Semua---";
            $options[0] = " 000 - Karya Umum ";
            asort($options);
            $contentOptions = '<div class="input-group">'.Html::dropDownList(  $kriteria.'[]',
                'selected option', $options, 
                ['class' => 'select2','style' => 'width: 100%;']
                ).'<center class="input-group-addon"> s/d </center>'.Html::dropDownList(  'to'.$kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2','style' => 'width: 100%;']
                ).'</div>';
        }
        else if ($kriteria == 'no_panggil')
        {
            $options = ['dimulai_dengan' => 'Dimulai Dengan','tepat' => 'Tepat','diakhiri_dengan' => 'Diakhiri Dengan','salah_satu_isi' => 'Salah Satu Isi'];
            $options = array_filter($options);

            $contentOptions = '<div class="input-group">'.Html::dropDownList('ini'.$kriteria.'[]',
                'selected option', $options, 
                ['class' => 'select2','style' => 'width: 100%;']
                ).'<div class="input-group-addon"> : </div>'.Html::textInput($kriteria.'[]',$value = null,
                ['class' => 'form-control col-sm-4','style' => 'width: 400px;']
                ).'</div>';
        }    
        else if ($kriteria == 'createby')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','username');
            $options[0] = "---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'data_entry')
        {
            $contentOptions = DatePicker::widget([
                'name' => $kriteria.'[]', 
                'type' => DatePicker::TYPE_RANGE,
                'value' => date('d-m-Y'),
                'name2' => 'to'.$kriteria.'[]', 
                'value2' => date('d-m-Y'),
                'separator' => 's/d',
                'options' => ['placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Date')],
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                    'class' => 'datepicker',
                ]
                ]);
        }
        else if ($kriteria == 'createdate')
        {
            $contentOptions = DatePicker::widget([
                'name' => $kriteria.'[]', 
                'type' => DatePicker::TYPE_RANGE,
                'value' => date('d-m-Y'),
                'name2' => 'to'.$kriteria.'[]', 
                'value2' => date('d-m-Y'),
                'separator' => 's/d',
                'options' => ['placeholder' => Yii::t('app','Choose').' '.Yii::t('app','Date')],
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                    'class' => 'datepicker',
                ]
                ]);
        }
        else if ($kriteria == 'harga')
        {

            $contentOptions = '<div class="input-group">'.
            Html::textInput($kriteria.'[]',$value = null,
                ['class' => 'form-control col-sm-4','style' => 'width: 100%;','type'=>'number']
                ).
            '<center class="input-group-addon"> s/d </center>'.
            Html::textInput('to'.$kriteria.'[]',$value = null,
                ['class' => 'form-control col-sm-4','style' => 'width: 100%;','type'=>'number']
                ).'</div>';
        }
        else if ($kriteria == 'petugas')
        {
            $options =  ArrayHelper::map(Users::find()->orderBy('ID')->asArray()->all(),'username',
                function($model) {
                    return $model['username'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'AnggotaPengusul')
        {
            $sql = 'SELECT * FROM members';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['MemberNo'].' - '.$model['Fullname'];
                });
            $options[0] = " ---Semua---";
            asort($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else
        {
            $contentOptions = null;
        }
        return $contentOptions;
        
    }


    /**
     * [actionLoadSelecterKriteria description]
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    public function actionLoadSelecterKriteria($i)
    {
        return $this->renderAjax('select-kriteria',['i'=>$i]);
    }
    public function actionLoadSelecterKriteriaUsulan($i)
    {
        return $this->renderAjax('select-kriteria-usulan',['i'=>$i]);
    }



    /**
     * [actionShowPdf description]
     * @return [type] [description]
     */
    public function actionShowPdf($tampilkan)
    {
      
        // session_start();
        $_SESSION['Array_POST_Filter'] = $_POST;

        // echo "<pre>";
        // // var_dump($_POST);
        // echo 'adalah'.count(array_filter($_POST['kriterias']));
        // echo "</pre>";

        // print_r(count(array_filter($_POST['kriterias'])));
        // print_r(isset($_POST['kota_terbit']));
        // echo 'Okeee'.$_POST['periode'];
        
        if ($tampilkan == 'frekuensi') 
        {
            if (count(array_filter($_POST['kriterias'])) != 0) {
                echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf').'">';
                echo "<iframe>";
            } else {
                echo "<script>swal('Pilih kriteria terlebih dahulu');</script>";
            }
            
        } 
        else if ($tampilkan == 'data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data').'">'."<iframe>" 
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        }
        else if ($tampilkan == 'dataBukuInduk')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-buku-induk').'">'."<iframe>" 
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
            // echo '<iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-buku-induk').'">';
            // echo "<iframe>";
        }
        else if ($tampilkan == 'dataAccessionList')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-accession-list').'">'."<iframe>" 
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
            // echo '<iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-accession-list').'">';
            // echo "<iframe>";
        }
        else if ($tampilkan == 'dataUcapanTerimakasih')
        {
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-ucapan-terimakasih').'">'."<iframe>";
            // echo '<iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-accession-list').'">';
            // echo "<iframe>";
        }
        else if ($tampilkan == 'frekuensiUsulan')
        {

            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-frekuensi-usulan-koleksi').'">'."<iframe>" 
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        }
        else if ($tampilkan == 'dataUsulan')
        {

            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-usulan-koleksi').'">'."<iframe>" 
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        }
        else if ($tampilkan == 'frekuensiKinerja')
        {
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-frekuensi-kinerja-user').'">'."<iframe>" ;
        }
        else if ($tampilkan == 'dataKinerja')
        {
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-kinerja-user').'">'."<iframe>" ;
        }
    }



    /**
     * [actionRenderPdfData description]
     * @return [type] [description]
     */
    public function actionRenderPdfData() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND worksheets.ID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        $sql = "SELECT collections.NoInduk AS NoInduk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>') AS data, 
                (CASE 
                 WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 
                 THEN CONCAT('<br/>',catalogs.Edition) 
                 ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) 
                END) AS data2, 
                CONCAT('<br/>',catalogs.PublishLocation,' ') AS data3, 
                catalogs.Publisher AS data4, 
                CONCAT(' ',catalogs.PublishYear,'<br/>') AS data5, 
                CONCAT(catalogs.Subject, '<br/>') AS data6, 
                catalogs.DeweyNo AS data7,  
                collections.CallNumber as NomorPanggil,
                DATE_FORMAT(collections.TanggalPengadaan,'%d-%M-%Y') AS TanggalPengadaan, 
                collectionsources.Name as SumberPerolehan,
                worksheets.Name as JenisBahan,
                collectionmedias.Name as JenisMedia, 
                collectioncategorys.Name as Kategori,
                collectionrules.Name as JenisAkses,Currency,
                Price as Harga, 
                NomorBarcode,RFID 
                FROM collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                AND DATE(collections.TanggalPengadaan) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 

        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
            $set = 60;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'content' => $this->renderPartial('pdf-view-koleksi-tampilkan-data', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelKoleksiPeriodikData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND worksheets.ID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        $sql = "SELECT collections.NoInduk AS NoInduk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>') AS data, 
                (CASE 
                 WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 
                 THEN CONCAT('<br/>',catalogs.Edition) 
                 ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) 
                END) AS data2, 
                CONCAT('<br/>',catalogs.PublishLocation,' ') AS data3, 
                catalogs.Publisher AS data4, 
                CONCAT(' ',catalogs.PublishYear,'<br/>') AS data5, 
                CONCAT(catalogs.Subject, '<br/>') AS data6, 
                catalogs.DeweyNo AS data7,  
                collections.CallNumber as NomorPanggil,
                DATE_FORMAT(collections.TanggalPengadaan,'%d-%M-%Y') AS TanggalPengadaan, 
                collectionsources.Name as SumberPerolehan,
                worksheets.Name as JenisBahan,
                collectionmedias.Name as JenisMedia, 
                collectioncategorys.Name as Kategori,
                collectionrules.Name as JenisAkses,Currency,
                Price as Harga, 
                NomorBarcode,RFID 
                FROM collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                AND DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $filename = 'Laporan_Periodik_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="13">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="13">Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="13">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Panggil</th>
                <th>Tanggal Pengadaan</th>
                <th>Sumber Perolehan</th>
                <th>Jenis Bahan</th>
                <th>Bentuk Fisik</th>
                <th>Kategori</th>
                <th>Jenis Akses</th>
                <th>Harga</th>
                <th>Nomer Barcode</th>
                <th>Nomer RFID</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['NomorBarcode'].'</td>
                    <td>'.$data['data'], $data['data2'], $data['data3'], $data['data4'], $data['data5'], $data['data6'], $data['data7'].'</td>
                    <td>'.$data['NomorPanggil'].'</td>
                    <td>'.$data['TanggalPengadaan'].'</td>
                    <td>'.$data['SumberPerolehan'].'</td>
                    <td>'.$data['JenisBahan'].'</td>
                    <td>'.$data['JenisMedia'].'</td>
                    <td>'.$data['Kategori'].'</td>
                    <td>'.$data['JenisAkses'].'</td>
                    <td>'.$data['Harga'].'</td>
                    <td>'.$data['NomorBarcode'].'</td>
                    <td>'.$data['RFID'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtKoleksiPeriodikData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND worksheets.ID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        $sql = "SELECT collections.NoInduk AS NoInduk, 
                NoInduk AS NoInduk, 
                CONCAT('',catalogs.Title,'','') AS data, 
                (CASE 
                 WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 
                 THEN CONCAT('',catalogs.Edition) 
                 ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('',EDISISERIAL) ELSE '' END) 
                END) AS data2, 
                CONCAT('',catalogs.PublishLocation,' ') AS data3, 
                catalogs.Publisher AS data4, 
                CONCAT(' ',catalogs.PublishYear,'') AS data5, 
                CONCAT(catalogs.Subject, '') AS data6, 
                catalogs.DeweyNo AS data7, 
                collections.CallNumber as NomorPanggil,
                DATE_FORMAT(collections.TanggalPengadaan,'%d-%M-%Y') AS TanggalPengadaan, 
                collectionsources.Name as SumberPerolehan,
                worksheets.Name as JenisBahan,
                collectionmedias.Name as JenisMedia, 
                collectioncategorys.Name as Kategori,
                collectionrules.Name as JenisAkses,Currency,
                Price as Harga, 
                NomorBarcode,RFID 
                FROM collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                AND DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'NoInduk'=> $model['NoInduk'], 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3']
                         , 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'NomorPanggil'=>$model['NomorPanggil']
                         , 'TanggalPengadaan'=>$model['TanggalPengadaan'], 'SumberPerolehan'=>$model['SumberPerolehan'], 'JenisBahan'=>$model['JenisBahan'], 'JenisMedia'=>$model['JenisMedia']
                         , 'Kategori'=>$model['Kategori'], 'JenisAkses'=>$model['JenisAkses'], 'Harga'=>$model['Harga'], 'NomorBarcode'=>$model['NomorBarcode'], 'RFID'=>$model['RFID'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        );

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-periodik-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-koleksi-periodik-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKoleksiPeriodikData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND worksheets.ID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        $sql = "SELECT collections.NoInduk AS NoInduk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>') AS data, 
                (CASE 
                 WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 
                 THEN CONCAT('<br/>',catalogs.Edition) 
                 ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) 
                END) AS data2, 
                CONCAT('<br/>',catalogs.PublishLocation,' ') AS data3, 
                catalogs.Publisher AS data4, 
                CONCAT(' ',catalogs.PublishYear,'<br/>') AS data5, 
                CONCAT(catalogs.Subject, '<br/>') AS data6, 
                catalogs.DeweyNo AS data7,  
                collections.CallNumber as NomorPanggil,
                DATE_FORMAT(collections.TanggalPengadaan,'%d-%M-%Y') AS TanggalPengadaan, 
                collectionsources.Name as SumberPerolehan,
                worksheets.Name as JenisBahan,
                collectionmedias.Name as JenisMedia, 
                collectioncategorys.Name as Kategori,
                collectionrules.Name as JenisAkses,Currency,
                Price as Harga, 
                NomorBarcode,RFID 
                FROM collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                AND DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="13">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="13">Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="13">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 10px; margin-right: 10px;">
                <th>No.</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Panggil</th>
                <th>Tanggal Pengadaan</th>
                <th>Sumber Perolehan</th>
                <th>Jenis Bahan</th>
                <th>Bentuk Fisik</th>
                <th>Kategori</th>
                <th>Jenis Akses</th>
                <th>Harga</th>
                <th>Nomer Barcode</th>
                <th>Nomer RFID</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['NoInduk'].'</td>
                    <td>'.$data['data'], $data['data2'], $data['data3'], $data['data4'], $data['data5'], $data['data6'], $data['data7'].'</td>
                    <td>'.$data['NomorPanggil'].'</td>
                    <td>'.$data['TanggalPengadaan'].'</td>
                    <td>'.$data['SumberPerolehan'].'</td>
                    <td>'.$data['JenisBahan'].'</td>
                    <td>'.$data['JenisMedia'].'</td>
                    <td>'.$data['Kategori'].'</td>
                    <td>'.$data['JenisAkses'].'</td>
                    <td>'.$data['Harga'].'</td>
                    <td>'.$data['NomorBarcode'].'</td>
                    <td>'.$data['RFID'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}


public function actionExportPdfKoleksiPeriodikData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND worksheets.ID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.substr(addslashes($value),0,1).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.substr(addslashes($value),0,1).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.addslashes($value).'" ';
                }
            }
        } 

        $sql = "SELECT collections.NoInduk AS NoInduk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>') AS data, 
                (CASE 
                 WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 
                 THEN CONCAT('<br/>',catalogs.Edition) 
                 ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) 
                END) AS data2, 
                CONCAT('<br/>',catalogs.PublishLocation,' ') AS data3, 
                catalogs.Publisher AS data4, 
                CONCAT(' ',catalogs.PublishYear,'<br/>') AS data5, 
                CONCAT(catalogs.Subject, '<br/>') AS data6, 
                catalogs.DeweyNo AS data7,  
                collections.CallNumber as NomorPanggil,
                DATE_FORMAT(collections.TanggalPengadaan,'%d-%M-%Y') AS TanggalPengadaan, 
                collectionsources.Name as SumberPerolehan,
                worksheets.Name as JenisBahan,
                collectionmedias.Name as JenisMedia, 
                collectioncategorys.Name as Kategori,
                collectionrules.Name as JenisAkses,Currency,
                Price as Harga, 
                NomorBarcode,RFID 
                FROM collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                AND DATE(collections.TanggalPengadaan) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 

        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
            $set = 60;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-tampilkan-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }


    /**
     * [actionMpdfDemo1 generate data to pdf with MPDF Controller]
     * @return [pdf] [pdf to show on page]
     */
    public function actionRenderPdf() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $group='';
        $join='';
        $subjek='';
        $andQuery='';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;
        // if (isset($_POST['PublishLocation'])) {
        //     foreach ($_POST['PublishLocation'] as $key => $value) {
        //         if ($value != "0" ) {
        //             $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
        //             }
        //         }
        //     $join = 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
        //     $group = ',PublishLocation';
        //     }

            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.PublishLocation LIKE '%".addslashes($value)."%' ";
                    }
            $group .= ', catalogs.PublishLocation';
                }
            $subjek = 'catalogs.PublishLocation AS Subjek';
            }

            if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Publisher';
                }
            $subjek = 'catalogs.Publisher AS Subjek';
            }

            if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.PublishYear';
                }
            $subjek = 'catalogs.PublishYear AS Subjek';
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND location_library.ID = '".addslashes($value)."' ";
                    }
            $group .= ', location_library.Name';
            $join .= 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
                }
            $subjek = 'location_library.Name AS Subjek';
            } 

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND bacaditempat.Location_Id = '".addslashes($value)."' ";
                    }
            $group .= ', locations.Name';
            $join .= 'INNER JOIN locations ON bacaditempat.Location_Id = locations.ID ';
                }
            $subjek = 'locations.Name AS Subjek';
            } 

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Source_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionsources.Name';
            $join .= 'INNER JOIN collectionsources ON collections.Source_Id = collectionsources.ID ';
                }
            $subjek = 'collectionsources.Name AS Subjek';
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Partner_Id = '".addslashes($value)."' ";
                    }
            $group .= ', partners.Name';
            $join .= 'INNER JOIN partners ON collections.Partner_Id = partners.ID ';
                }
            $subjek = 'partners.Name AS Subjek';
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Currency = '".addslashes($value)."' ";
                    }
            $group .= ', currency.Currency';
            $join .= 'INNER JOIN currency ON collections.Currency = currency.Currency ';
                }
            $subjek = 'currency.Description AS Subjek';
            } 

            if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Price BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['toharga'])) {
                foreach ($_POST['toharga'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
            $group .= ', collections.Price';
                }
            $subjek = 'collections.Price AS Subjek';
            } 

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Category_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectioncategorys.Name';
            $join .= 'INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
                }
            $subjek = 'collectioncategorys.Name AS Subjek';
            }  

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Rule_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionrules.Name';
            $join .= 'INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
                }
            $subjek = 'collectionrules.Name AS Subjek';
            } 

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', worksheets.Name';
            $join .= 'INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
                }
            $subjek = 'worksheets.Name AS Subjek';
            }  

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionmedias.Name';
            $join .= 'INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
                }
            $subjek = 'collectionmedias.Name AS Subjek';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Subject = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Subject';
                }
            $subjek = 'catalogs.Subject AS Subjek';
            }           

            // if (isset($_POST['no_klas'])) {
            // foreach ($_POST['no_klas'] as $key => $value) {
            //     if ($value != "0" ) {
            //         $kelas = Masterkelasbesar::findOne(['id' => $value]);
            //         $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN "'.$kelas->kdKelas.'" AND "'.$kelas->kdKelas.'" ';
            //     }
            // $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            //     }
            // }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
            $subjek = 'master_kelas_besar.namakelas AS Subjek';
            }

        if (isset($_POST['no_panggil'])) {            
            if (implode($_POST['inino_panggil']) == 'dimulai_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '".addslashes($value)."%' ";
                    }
                }
            } 
            if (implode($_POST['inino_panggil']) == 'salah_satu_isi') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."%' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'tepat') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber = '".addslashes($value)."' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'diakhiri_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."' ";
                    }
                }
            }
            $subjek = 'catalogs.CallNumber AS Subjek';
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collections.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= ", CONCAT('".date("d-m-Y", strtotime( $value ) )."', ' - ', ";
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= " '".date("d-m-Y", strtotime( $value ) )."') AS subjek";
            }
            $subjek = '"'.$periode2.'" AS Subjek';
        }
        if (isset($_POST['petugas'])) {
            foreach ($_POST['petugas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            $join .= 'INNER JOIN users ON users.ID = collections.CreateBy ';
            }
        $subjek = 'users.username AS Subjek';
        }



          $sql = "SELECT ".$periode_format.",                
                    COUNT(collections.ID) AS CountEksemplar,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    ".$subjek."
                    FROM
                    collections 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID
                    ";


        $sql .= $join;
        $sql .= 'WHERE DATE(collections.TanggalPengadaan) ';
        $sql .= $sqlPeriode;
        $sql .= $andValue; 
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.TanggalPengadaan,'%d-%m-%Y')";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.TanggalPengadaan)";
                } else {
                    $sql .= " GROUP BY YEAR(collections.TanggalPengadaan)";
                }
        $sql .= $group;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";
            /*echo"<pre>";
            print_r($_POST);
                        echo" isi dari sql ".$sql;
            echo"</pre>";
            die;*/

        //$sql .= $group;
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' (' .implode($_POST[implode($_POST['kriterias'])]). ')';
        // }

        // $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
        //     $test = collectioncategorys::findOne(implode($_POST[implode($_POST['kriterias'])]))->Name; 
        //     $Berdasarkan .= ' (' .$test. ')';
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] = $Berdasarkan;
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginRight' => 0,
            'marginLeft' => 0,
            'content' => $this->renderPartial('pdf-view-koleksi', $content),
            'options' => [
            'title' => 'Laporan Frekuensi',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelKoleksiPeriodikFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $group='';
        $join='';
        $subjek='';
        $andQuery='';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;
        // if (isset($_POST['PublishLocation'])) {
        //     foreach ($_POST['PublishLocation'] as $key => $value) {
        //         if ($value != "0" ) {
        //             $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
        //             }
        //         }
        //     $join = 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
        //     $group = ',PublishLocation';
        //     }

            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.PublishLocation LIKE '%".addslashes($value)."%' ";
                    }
            $group .= ', catalogs.PublishLocation';
                }
            $subjek = 'catalogs.PublishLocation AS Subjek';
            }

            if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Publisher';
                }
            $subjek = 'catalogs.Publisher AS Subjek';
            }

            if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.PublishYear';
                }
            $subjek = 'catalogs.PublishYear AS Subjek';
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND location_library.ID = '".addslashes($value)."' ";
                    }
            $group .= ', location_library.Name';
            $join .= 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
                }
            $subjek = 'location_library.Name AS Subjek';
            } 

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND bacaditempat.Location_Id = '".addslashes($value)."' ";
                    }
            $group .= ', locations.Name';
            $join .= 'INNER JOIN locations ON bacaditempat.Location_Id = locations.ID ';
                }
            $subjek = 'locations.Name AS Subjek';
            } 

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Source_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionsources.Name';
            $join .= 'INNER JOIN collectionsources ON collections.Source_Id = collectionsources.ID ';
                }
            $subjek = 'collectionsources.Name AS Subjek';
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Partner_Id = '".addslashes($value)."' ";
                    }
            $group .= ', partners.Name';
            $join .= 'INNER JOIN partners ON collections.Partner_Id = partners.ID ';
                }
            $subjek = 'partners.Name AS Subjek';
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Currency = '".addslashes($value)."' ";
                    }
            $group .= ', currency.Currency';
            $join .= 'INNER JOIN currency ON collections.Currency = currency.Currency ';
                }
            $subjek = 'currency.Description AS Subjek';
            } 

            if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Price BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['toharga'])) {
                foreach ($_POST['toharga'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
            $group .= ', collections.Price';
                }
            $subjek = 'collections.Price AS Subjek';
            } 

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Category_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectioncategorys.Name';
            $join .= 'INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
                }
            $subjek = 'collectioncategorys.Name AS Subjek';
            }  

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Rule_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionrules.Name';
            $join .= 'INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
                }
            $subjek = 'collectionrules.Name AS Subjek';
            } 

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', worksheets.Name';
            $join .= 'INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
                }
            $subjek = 'worksheets.Name AS Subjek';
            }  

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionmedias.Name';
            $join .= 'INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
                }
            $subjek = 'collectionmedias.Name AS Subjek';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Subject = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Subject';
                }
            $subjek = 'catalogs.Subject AS Subjek';
            }           

            // if (isset($_POST['no_klas'])) {
            // foreach ($_POST['no_klas'] as $key => $value) {
            //     if ($value != "0" ) {
            //         $kelas = Masterkelasbesar::findOne(['id' => $value]);
            //         $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN "'.$kelas->kdKelas.'" AND "'.$kelas->kdKelas.'" ';
            //     }
            // $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            //     }
            // }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
            $subjek = 'master_kelas_besar.namakelas AS Subjek';
            }

        if (isset($_POST['no_panggil'])) {            
            if (implode($_POST['inino_panggil']) == 'dimulai_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '".addslashes($value)."%' ";
                    }
                }
            } 
            if (implode($_POST['inino_panggil']) == 'salah_satu_isi') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."%' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'tepat') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber = '".addslashes($value)."' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'diakhiri_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."' ";
                    }
                }
            }
            $subjek = 'catalogs.CallNumber AS Subjek';
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collections.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= ", CONCAT('".date("d-m-Y", strtotime( $value ) )."', ' - ', ";
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= " '".date("d-m-Y", strtotime( $value ) )."') AS subjek";
            }
            $subjek = '"'.$periode2.'" AS Subjek';
        }
        if (isset($_POST['petugas'])) {
            foreach ($_POST['petugas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            $join .= 'INNER JOIN users ON users.ID = collections.CreateBy ';
            }
        $subjek = 'users.username AS Subjek';
        }



          $sql = "SELECT ".$periode_format.",                
                    COUNT(collections.ID) AS CountEksemplar,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    ".$subjek."
                    FROM
                    collections 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID
                    ";
        $sql .= $join;
        $sql .= 'WHERE DATE(collections.TanggalPengadaan) ';
        $sql .= $sqlPeriode;
        $sql .= $andValue; 
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.TanggalPengadaan,'%d-%m-%Y')";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.TanggalPengadaan)";
                } else {
                    $sql .= " GROUP BY YEAR(collections.TanggalPengadaan)";
                }
        $sql .= $group;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $filename = 'Laporan_Periodik_Frekuensi.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="5">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahEksemplar = 0;
        $JumlahJudul = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['Subjek'].'</td>'; }
    echo'
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['CountEksemplar'].'</td>
                </tr>
            ';
                        $JumlahEksemplar = $JumlahEksemplar + $data['CountEksemplar'];
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="2"';} else {echo 'colspan="3"';}echo ' style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJudul.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahEksemplar.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtKoleksiPeriodikFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $group='';
        $join='';
        $subjek='';
        $andQuery='';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;
        // if (isset($_POST['PublishLocation'])) {
        //     foreach ($_POST['PublishLocation'] as $key => $value) {
        //         if ($value != "0" ) {
        //             $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
        //             }
        //         }
        //     $join = 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
        //     $group = ',PublishLocation';
        //     }

            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.PublishLocation LIKE '%".addslashes($value)."%' ";
                    }
            $group .= ', catalogs.PublishLocation';
                }
            $subjek = 'catalogs.PublishLocation AS Subjek';
            }

            if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Publisher';
                }
            $subjek = 'catalogs.Publisher AS Subjek';
            }

            if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.PublishYear';
                }
            $subjek = 'catalogs.PublishYear AS Subjek';
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND location_library.ID = '".addslashes($value)."' ";
                    }
            $group .= ', location_library.Name';
            $join .= 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
                }
            $subjek = 'location_library.Name AS Subjek';
            } 

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND bacaditempat.Location_Id = '".addslashes($value)."' ";
                    }
            $group .= ', locations.Name';
            $join .= 'INNER JOIN locations ON bacaditempat.Location_Id = locations.ID ';
                }
            $subjek = 'locations.Name AS Subjek';
            } 

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Source_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionsources.Name';
            $join .= 'INNER JOIN collectionsources ON collections.Source_Id = collectionsources.ID ';
                }
            $subjek = 'collectionsources.Name AS Subjek';
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Partner_Id = '".addslashes($value)."' ";
                    }
            $group .= ', partners.Name';
            $join .= 'INNER JOIN partners ON collections.Partner_Id = partners.ID ';
                }
            $subjek = 'partners.Name AS Subjek';
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Currency = '".addslashes($value)."' ";
                    }
            $group .= ', currency.Currency';
            $join .= 'INNER JOIN currency ON collections.Currency = currency.Currency ';
                }
            $subjek = 'currency.Description AS Subjek';
            } 

            if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Price BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['toharga'])) {
                foreach ($_POST['toharga'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
            $group .= ', collections.Price';
                }
            $subjek = 'collections.Price AS Subjek';
            } 

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Category_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectioncategorys.Name';
            $join .= 'INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
                }
            $subjek = 'collectioncategorys.Name AS Subjek';
            }  

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Rule_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionrules.Name';
            $join .= 'INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
                }
            $subjek = 'collectionrules.Name AS Subjek';
            } 

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', worksheets.Name';
            $join .= 'INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
                }
            $subjek = 'worksheets.Name AS Subjek';
            }  

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionmedias.Name';
            $join .= 'INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
                }
            $subjek = 'collectionmedias.Name AS Subjek';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Subject = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Subject';
                }
            $subjek = 'catalogs.Subject AS Subjek';
            }           

            // if (isset($_POST['no_klas'])) {
            // foreach ($_POST['no_klas'] as $key => $value) {
            //     if ($value != "0" ) {
            //         $kelas = Masterkelasbesar::findOne(['id' => $value]);
            //         $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN "'.$kelas->kdKelas.'" AND "'.$kelas->kdKelas.'" ';
            //     }
            // $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            //     }
            // }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
            $subjek = 'master_kelas_besar.namakelas AS Subjek';
            }

        if (isset($_POST['no_panggil'])) {            
            if (implode($_POST['inino_panggil']) == 'dimulai_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '".addslashes($value)."%' ";
                    }
                }
            } 
            if (implode($_POST['inino_panggil']) == 'salah_satu_isi') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."%' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'tepat') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber = '".addslashes($value)."' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'diakhiri_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."' ";
                    }
                }
            }
            $subjek = 'catalogs.CallNumber AS Subjek';
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collections.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= ", CONCAT('".date("d-m-Y", strtotime( $value ) )."', ' - ', ";
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= " '".date("d-m-Y", strtotime( $value ) )."') AS subjek";
            }
            $subjek = '"'.$periode2.'" AS Subjek';
        }
        if (isset($_POST['petugas'])) {
            foreach ($_POST['petugas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            $join .= 'INNER JOIN users ON users.ID = collections.CreateBy ';
            }
        $subjek = 'users.username AS Subjek';
        }



           $sql = "SELECT ".$periode_format.",                
                    COUNT(collections.ID) AS CountEksemplar,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    ".$subjek."
                    FROM
                    collections 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID
                    ";
        $sql .= $join;
        $sql .= 'WHERE DATE(collections.TanggalPengadaan) ';
        $sql .= $sqlPeriode;
        $sql .= $andValue; 
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.TanggalPengadaan,'%d-%m-%Y')";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.TanggalPengadaan)";
                } else {
                    $sql .= " GROUP BY YEAR(collections.TanggalPengadaan)";
                }
        $sql .= $group;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Subjek'=>$model['Subjek'], 'CountEksemplar'=>$model['CountEksemplar'], 'JumlahJudul'=>$model['JumlahJudul'] );
            $CountEksemplar = $CountEksemplar + $model['CountEksemplar'];
            $JumlahJudul = $JumlahJudul + $model['JumlahJudul'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalCountEksemplar'=>$CountEksemplar,
        'TotalJumlahJudul'=>$JumlahJudul,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-periodik.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-periodik_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-koleksi-periodik-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKoleksiPeriodikFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $group='';
        $join='';
        $subjek='';
        $andQuery='';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;
        // if (isset($_POST['PublishLocation'])) {
        //     foreach ($_POST['PublishLocation'] as $key => $value) {
        //         if ($value != "0" ) {
        //             $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
        //             }
        //         }
        //     $join = 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
        //     $group = ',PublishLocation';
        //     }

            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.PublishLocation LIKE '%".addslashes($value)."%' ";
                    }
            $group .= ', catalogs.PublishLocation';
                }
            $subjek = 'catalogs.PublishLocation AS Subjek';
            }

            if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Publisher';
                }
            $subjek = 'catalogs.Publisher AS Subjek';
            }

            if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.PublishYear';
                }
            $subjek = 'catalogs.PublishYear AS Subjek';
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND location_library.ID = '".addslashes($value)."' ";
                    }
            $group .= ', location_library.Name';
            $join .= 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
                }
            $subjek = 'location_library.Name AS Subjek';
            } 

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND bacaditempat.Location_Id = '".addslashes($value)."' ";
                    }
            $group .= ', locations.Name';
            $join .= 'INNER JOIN locations ON bacaditempat.Location_Id = locations.ID ';
                }
            $subjek = 'locations.Name AS Subjek';
            } 

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Source_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionsources.Name';
            $join .= 'INNER JOIN collectionsources ON collections.Source_Id = collectionsources.ID ';
                }
            $subjek = 'collectionsources.Name AS Subjek';
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Partner_Id = '".addslashes($value)."' ";
                    }
            $group .= ', partners.Name';
            $join .= 'INNER JOIN partners ON collections.Partner_Id = partners.ID ';
                }
            $subjek = 'partners.Name AS Subjek';
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Currency = '".addslashes($value)."' ";
                    }
            $group .= ', currency.Currency';
            $join .= 'INNER JOIN currency ON collections.Currency = currency.Currency ';
                }
            $subjek = 'currency.Description AS Subjek';
            } 

            if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Price BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['toharga'])) {
                foreach ($_POST['toharga'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
            $group .= ', collections.Price';
                }
            $subjek = 'collections.Price AS Subjek';
            } 

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Category_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectioncategorys.Name';
            $join .= 'INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
                }
            $subjek = 'collectioncategorys.Name AS Subjek';
            }  

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Rule_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionrules.Name';
            $join .= 'INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
                }
            $subjek = 'collectionrules.Name AS Subjek';
            } 

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', worksheets.Name';
            $join .= 'INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
                }
            $subjek = 'worksheets.Name AS Subjek';
            }  

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionmedias.Name';
            $join .= 'INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
                }
            $subjek = 'collectionmedias.Name AS Subjek';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Subject = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Subject';
                }
            $subjek = 'catalogs.Subject AS Subjek';
            }           

            // if (isset($_POST['no_klas'])) {
            // foreach ($_POST['no_klas'] as $key => $value) {
            //     if ($value != "0" ) {
            //         $kelas = Masterkelasbesar::findOne(['id' => $value]);
            //         $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN "'.$kelas->kdKelas.'" AND "'.$kelas->kdKelas.'" ';
            //     }
            // $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            //     }
            // }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
            $subjek = 'master_kelas_besar.namakelas AS Subjek';
            }

        if (isset($_POST['no_panggil'])) {            
            if (implode($_POST['inino_panggil']) == 'dimulai_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '".addslashes($value)."%' ";
                    }
                }
            } 
            if (implode($_POST['inino_panggil']) == 'salah_satu_isi') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."%' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'tepat') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber = '".addslashes($value)."' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'diakhiri_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."' ";
                    }
                }
            }
            $subjek = 'catalogs.CallNumber AS Subjek';
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collections.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= ", CONCAT('".date("d-m-Y", strtotime( $value ) )."', ' - ', ";
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= " '".date("d-m-Y", strtotime( $value ) )."') AS subjek";
            }
            $subjek = '"'.$periode2.'" AS Subjek';
        }
        if (isset($_POST['petugas'])) {
            foreach ($_POST['petugas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            $join .= 'INNER JOIN users ON users.ID = collections.CreateBy ';
            }
        $subjek = 'users.username AS Subjek';
        }

           $sql = "SELECT ".$periode_format.",                
                    COUNT(collections.ID) AS CountEksemplar,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    ".$subjek."
                    FROM
                    collections 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID
                    ";
        $sql .= $join;
        $sql .= 'WHERE DATE(collections.TanggalPengadaan) ';
        $sql .= $sqlPeriode;
        $sql .= $andValue; 
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.TanggalPengadaan,'%d-%m-%Y')";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.TanggalPengadaan)";
                } else {
                    $sql .= " GROUP BY YEAR(collections.TanggalPengadaan)";
                }
        $sql .= $group;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="4"';} else {echo 'colspan="5"';}echo '>Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="4"';} else {echo 'colspan="5"';}echo '>Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="4"';} else {echo 'colspan="5"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 10px; margin-left: 10px;">
                <th>No.</th>
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahEksemplar = 0;
        $JumlahJudul = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['Subjek'].'</td>'; }
    echo'
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['CountEksemplar'].'</td>
                </tr>
            ';
                        $JumlahEksemplar = $JumlahEksemplar + $data['CountEksemplar'];
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="2"';} else {echo 'colspan="3"';}echo ' style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJudul.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahEksemplar.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfKoleksiPeriodikFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $group='';
        $join='';
        $subjek='';
        $andQuery='';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collections.TanggalPengadaan,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;
        // if (isset($_POST['PublishLocation'])) {
        //     foreach ($_POST['PublishLocation'] as $key => $value) {
        //         if ($value != "0" ) {
        //             $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
        //             }
        //         }
        //     $join = 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
        //     $group = ',PublishLocation';
        //     }

            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.PublishLocation LIKE '%".addslashes($value)."%' ";
                    }
            $group .= ', catalogs.PublishLocation';
                }
            $subjek = 'catalogs.PublishLocation AS Subjek';
            }

            if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Publisher';
                }
            $subjek = 'catalogs.Publisher AS Subjek';
            }

            if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.ID = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.PublishYear';
                }
            $subjek = 'catalogs.PublishYear AS Subjek';
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND location_library.ID = '".addslashes($value)."' ";
                    }
            $group .= ', location_library.Name';
            $join .= 'INNER JOIN location_library ON collections.Location_Library_Id = location_library.ID ';
                }
            $subjek = 'location_library.Name AS Subjek';
            } 

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND bacaditempat.Location_Id = '".addslashes($value)."' ";
                    }
            $group .= ', locations.Name';
            $join .= 'INNER JOIN locations ON bacaditempat.Location_Id = locations.ID ';
                }
            $subjek = 'locations.Name AS Subjek';
            } 

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Source_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionsources.Name';
            $join .= 'INNER JOIN collectionsources ON collections.Source_Id = collectionsources.ID ';
                }
            $subjek = 'collectionsources.Name AS Subjek';
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Partner_Id = '".addslashes($value)."' ";
                    }
            $group .= ', partners.Name';
            $join .= 'INNER JOIN partners ON collections.Partner_Id = partners.ID ';
                }
            $subjek = 'partners.Name AS Subjek';
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Currency = '".addslashes($value)."' ";
                    }
            $group .= ', currency.Currency';
            $join .= 'INNER JOIN currency ON collections.Currency = currency.Currency ';
                }
            $subjek = 'currency.Description AS Subjek';
            } 

            if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Price BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['toharga'])) {
                foreach ($_POST['toharga'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
            $group .= ', collections.Price';
                }
            $subjek = 'collections.Price AS Subjek';
            } 

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Category_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectioncategorys.Name';
            $join .= 'INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
                }
            $subjek = 'collectioncategorys.Name AS Subjek';
            }  

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collections.Rule_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionrules.Name';
            $join .= 'INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
                }
            $subjek = 'collectionrules.Name AS Subjek';
            } 

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', worksheets.Name';
            $join .= 'INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
                }
            $subjek = 'worksheets.Name AS Subjek';
            }  

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Worksheet_Id = '".addslashes($value)."' ";
                    }
            $group .= ', collectionmedias.Name';
            $join .= 'INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
                }
            $subjek = 'collectionmedias.Name AS Subjek';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND catalogs.Subject = '".addslashes($value)."' ";
                    }
            $group .= ', catalogs.Subject';
                }
            $subjek = 'catalogs.Subject AS Subjek';
            }           

            // if (isset($_POST['no_klas'])) {
            // foreach ($_POST['no_klas'] as $key => $value) {
            //     if ($value != "0" ) {
            //         $kelas = Masterkelasbesar::findOne(['id' => $value]);
            //         $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN "'.$kelas->kdKelas.'" AND "'.$kelas->kdKelas.'" ';
            //     }
            // $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            //     }
            // }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $join .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
            $subjek = 'master_kelas_besar.namakelas AS Subjek';
            }

        if (isset($_POST['no_panggil'])) {            
            if (implode($_POST['inino_panggil']) == 'dimulai_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '".addslashes($value)."%' ";
                    }
                }
            } 
            if (implode($_POST['inino_panggil']) == 'salah_satu_isi') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."%' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'tepat') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber = '".addslashes($value)."' ";
                    }
                }
            }
            if (implode($_POST['inino_panggil']) == 'diakhiri_dengan') {
                foreach ($_POST['no_panggil'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND catalogs.CallNumber LIKE '%".addslashes($value)."' ";
                    }
                }
            }
            $subjek = 'catalogs.CallNumber AS Subjek';
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collections.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= ", CONCAT('".date("d-m-Y", strtotime( $value ) )."', ' - ', ";
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                }
        $andQuery .= " '".date("d-m-Y", strtotime( $value ) )."') AS subjek";
            }
            $subjek = '"'.$periode2.'" AS Subjek';
        }
        if (isset($_POST['petugas'])) {
            foreach ($_POST['petugas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            $join .= 'INNER JOIN users ON users.ID = collections.CreateBy ';
            }
        $subjek = 'users.username AS Subjek';
        }

           $sql = "SELECT ".$periode_format.",                
                    COUNT(collections.ID) AS CountEksemplar,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    ".$subjek."
                    FROM
                    collections 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID
                    ";
        $sql .= $join;
        $sql .= 'WHERE DATE(collections.TanggalPengadaan) ';
        $sql .= $sqlPeriode;
        $sql .= $andValue; 
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.TanggalPengadaan,'%d-%m-%Y')";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.TanggalPengadaan)";
                } else {
                    $sql .= " GROUP BY YEAR(collections.TanggalPengadaan)";
                }
        $sql .= $group;
        $sql .= " ORDER BY DATE_FORMAT(collections.TanggalPengadaan,'%Y-%m-%d') DESC";

        //$sql .= $group;
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' (' .implode($_POST[implode($_POST['kriterias'])]). ')';
        // }

        // $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
        //     $test = collectioncategorys::findOne(implode($_POST[implode($_POST['kriterias'])]))->Name; 
        //     $Berdasarkan .= ' (' .$test. ')';
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] = $Berdasarkan;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Frekuensi',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


    /////// Koleksi Buku Induk Area
    /**
     * [actionBukuInduk description]
     * @return [type] [description]
     */
    public function actionBukuInduk()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-buku-induk',[
            'model' => $model,
            ]);
    }



    /**
     * [actionRenderPdfDataBukuIduk description]
     * @return [type] [description]
     */
    public function actionRenderPdfDataBukuInduk() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = " SELECT collections.ID,
                collections.NoInduk,
                catalogs.Title AS Judul,
                Author AS Pengarang,
                PublishLocation AS TempatTerbit,
                Publisher AS Penerbit,
                PublishYear AS TahunTerbit,
                (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END) AS Edisi,
                collections.Currency,
                DeweyNo AS NoKelas,
                (SELECT catalogs.ISBN FROM catalogs WHERE collections.Catalog_id = catalogs.ID) AS i,
                collections.TanggalPengadaan,
                worksheets.Name AS JenisBahan,
                partners.Name AS Partner,
                collectionmedias.Name AS BentukFisik,
                catalogs.PhysicalDescription AS deskripsi,
                collectionsources.name AS JenisSumber,
                collectioncategorys.Name AS Kategori,
                collections.Price,
                (SELECT IF(catalog_ruas.Tag NOT IN ('022'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS issn
                ,
                (SELECT IF(catalog_ruas.Tag NOT IN ('020'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS isbn
                , 
                master_kelas_besar.kdKelas AS klass
                FROM collections
                LEFT JOIN catalogs ON collections.Catalog_id = catalogs.ID
                LEFT JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                LEFT JOIN partners ON collections.Partner_ID = partners.ID 
                LEFT JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID
                LEFT JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                LEFT JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                LEFT JOIN master_kelas_besar ON SUBSTRING(catalogs.DeweyNo, 1, 1) = SUBSTRING(master_kelas_besar.kdKelas, 1, 1) 
                LEFT JOIN catalog_ruas ON catalog_ruas.CatalogId = catalogs.ID
                WHERE DATE(collections.TanggalPengadaan) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " AND catalog_ruas.Tag IN ('020','022') GROUP BY collections.ID, issn, isbn";
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
            $set = 60;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'content' => $this->renderPartial('pdf-view-koleksi-tampilkan-data-buku-induk', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelBukuIndukData()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = " SELECT collections.ID,
                collections.NoInduk,
                catalogs.Title AS Judul,
                Author AS Pengarang,
                PublishLocation AS TempatTerbit,
                Publisher AS Penerbit,
                PublishYear AS TahunTerbit,
                (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END) AS Edisi,
                collections.Currency,
                DeweyNo AS NoKelas,
                (SELECT catalogs.ISBN FROM catalogs WHERE collections.Catalog_id = catalogs.ID) AS i,
                collections.TanggalPengadaan,
                worksheets.Name AS JenisBahan,
                partners.Name AS Partner,
                collectionmedias.Name AS BentukFisik,
                catalogs.PhysicalDescription AS deskripsi,
                collectionsources.name AS JenisSumber,
                collectioncategorys.Name AS Kategori,
                collections.Price,
                (SELECT IF(catalog_ruas.Tag NOT IN ('022'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS issn
                ,
                (SELECT IF(catalog_ruas.Tag NOT IN ('020'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS isbn
                , 
                master_kelas_besar.kdKelas AS klass
                FROM collections
                LEFT JOIN catalogs ON collections.Catalog_id = catalogs.ID
                LEFT JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                LEFT JOIN partners ON collections.Partner_ID = partners.ID 
                LEFT JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID
                LEFT JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                LEFT JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                LEFT JOIN master_kelas_besar ON SUBSTRING(catalogs.DeweyNo, 1, 1) = SUBSTRING(master_kelas_besar.kdKelas, 1, 1) 
                LEFT JOIN catalog_ruas ON catalog_ruas.CatalogId = catalogs.ID
                WHERE DATE(collections.TanggalPengadaan) ";
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " AND catalog_ruas.Tag IN ('020','022') GROUP BY collections.ID, issn, isbn";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $filename = 'Laporan_Periodik_Frekuensi.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="18">Laporan Detail Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="18">Buku Induk Perpustakaan '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="18">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pengadaan</th>
                <th>Nomer Induk</th>
                <th>Jenis Bahan</th>
                <th>Bentuk Fisik</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Edisi</th>
                <th>Tempat Terbit</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Deskripsi Fisik</th>
                <th>Jenis Sumber Perolehan</th>
                <th>Nama Sumber Perolehan</th>
                <th>Kategori</th>
                <th>ISBN</th>
                <th>ISSN</th>
                <th>Harga</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPengadaan'].'</td>
                    <td>'.$data['NoInduk'].'</td>
                    <td>'.$data['JenisBahan'].'</td>
                    <td>'.$data['BentukFisik'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['Edisi'].'</td>
                    <td>'.$data['TempatTerbit'].'</td>
                    <td>'.$data['Penerbit'].'</td>
                    <td>'.$data['TahunTerbit'].'</td>
                    <td>'.$data['deskripsi'].'</td>
                    <td>'.$data['JenisSumber'].'</td>
                    <td>'.$data['Partner'].'</td>
                    <td>'.$data['Kategori'].'</td>
                    <td>'.$data['isbn'].'</td>
                    <td>'.$data['issn'].'</td>
                    <td>'.$data['Currency'].' - '.$data['Price']. '</td>
                </tr>
            ';
                        $no++;
                    endforeach;        
    echo '</table>';

}

public function actionExportExcelOdtBukuIndukData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = " SELECT collections.ID,
                collections.NoInduk,
                catalogs.Title AS Judul,
                Author AS Pengarang,
                PublishLocation AS TempatTerbit,
                Publisher AS Penerbit,
                PublishYear AS TahunTerbit,
                (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END) AS Edisi,
                collections.Currency,
                DeweyNo AS NoKelas,
                (SELECT catalogs.ISBN FROM catalogs WHERE collections.Catalog_id = catalogs.ID) AS i,
                collections.TanggalPengadaan,
                worksheets.Name AS JenisBahan,
                partners.Name AS Partner,
                collectionmedias.Name AS BentukFisik,
                catalogs.PhysicalDescription AS deskripsi,
                collectionsources.name AS JenisSumber,
                collectioncategorys.Name AS Kategori,
                collections.Price,
                (SELECT IF(catalog_ruas.Tag NOT IN ('022'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS issn
                ,
                (SELECT IF(catalog_ruas.Tag NOT IN ('020'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS isbn
                , 
                master_kelas_besar.kdKelas AS klass
                FROM collections
                LEFT JOIN catalogs ON collections.Catalog_id = catalogs.ID
                LEFT JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                LEFT JOIN partners ON collections.Partner_ID = partners.ID 
                LEFT JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID
                LEFT JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                LEFT JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                LEFT JOIN master_kelas_besar ON SUBSTRING(catalogs.DeweyNo, 1, 1) = SUBSTRING(master_kelas_besar.kdKelas, 1, 1) 
                LEFT JOIN catalog_ruas ON catalog_ruas.CatalogId = catalogs.ID
                WHERE DATE(collections.TanggalPengadaan) ";
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " AND catalog_ruas.Tag IN ('020','022') GROUP BY collections.ID, issn, isbn";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');


    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'TanggalPengadaan'=> $model['TanggalPengadaan'], 'NoInduk'=>$model['NoInduk'], 'JenisBahan'=>$model['JenisBahan'], 'BentukFisik'=>$model['BentukFisik'], 'Judul'=>$model['Judul']
                         , 'Pengarang'=>$model['Pengarang'], 'Edisi'=>$model['Edisi'], 'TempatTerbit'=>$model['TempatTerbit'], 'Penerbit'=>$model['Penerbit'], 'TahunTerbit'=>$model['TahunTerbit'], 'deskripsi'=>$model['deskripsi'], 'JenisSumber'=>$model['JenisSumber']
                         , 'Partner'=>$model['Partner'], 'Kategori'=>$model['Kategori'], 'isbn'=>$model['isbn'], 'issn'=>$model['issn'], 'Currency'=>$model['Currency'], 'Price'=>$model['Price'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-buku-induk-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-buku-induk.ods');
    // !Open Office Calc Area


}

public function actionExportWordBukuIndukData()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = " SELECT collections.ID,
                collections.NoInduk,
                catalogs.Title AS Judul,
                Author AS Pengarang,
                PublishLocation AS TempatTerbit,
                Publisher AS Penerbit,
                PublishYear AS TahunTerbit,
                (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END) AS Edisi,
                collections.Currency,
                DeweyNo AS NoKelas,
                (SELECT catalogs.ISBN FROM catalogs WHERE collections.Catalog_id = catalogs.ID) AS i,
                collections.TanggalPengadaan,
                worksheets.Name AS JenisBahan,
                partners.Name AS Partner,
                collectionmedias.Name AS BentukFisik,
                catalogs.PhysicalDescription AS deskripsi,
                collectionsources.name AS JenisSumber,
                collectioncategorys.Name AS Kategori,
                collections.Price,
                (SELECT IF(catalog_ruas.Tag NOT IN ('022'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS issn
                ,
                (SELECT IF(catalog_ruas.Tag NOT IN ('020'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS isbn
                , 
                master_kelas_besar.kdKelas AS klass
                FROM collections
                LEFT JOIN catalogs ON collections.Catalog_id = catalogs.ID
                LEFT JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                LEFT JOIN partners ON collections.Partner_ID = partners.ID 
                LEFT JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID
                LEFT JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                LEFT JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                LEFT JOIN master_kelas_besar ON SUBSTRING(catalogs.DeweyNo, 1, 1) = SUBSTRING(master_kelas_besar.kdKelas, 1, 1) 
                LEFT JOIN catalog_ruas ON catalog_ruas.CatalogId = catalogs.ID
                WHERE DATE(collections.TanggalPengadaan) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " AND catalog_ruas.Tag IN ('020','022') GROUP BY collections.ID, issn, isbn";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="18">Laporan Detail Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="18">Buku Induk Perpustakaan '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="18">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pengadaan</th>
                <th>Nomer Induk</th>
                <th>Jenis Bahan</th>
                <th>Bentuk Fisik</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Edisi</th>
                <th>Tempat Terbit</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Deskripsi Fisik</th>
                <th>Jenis Sumber Perolehan</th>
                <th>Nama Sumber Perolehan</th>
                <th>Kategori</th>
                <th>ISBN</th>
                <th>ISSN</th>
                <th>Harga</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPengadaan'].'</td>
                    <td>'.$data['NoInduk'].'</td>
                    <td>'.$data['JenisBahan'].'</td>
                    <td>'.$data['BentukFisik'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['Edisi'].'</td>
                    <td>'.$data['TempatTerbit'].'</td>
                    <td>'.$data['Penerbit'].'</td>
                    <td>'.$data['TahunTerbit'].'</td>
                    <td>'.$data['deskripsi'].'</td>
                    <td>'.$data['JenisSumber'].'</td>
                    <td>'.$data['Partner'].'</td>
                    <td>'.$data['Kategori'].'</td>
                    <td>'.$data['isbn'].'</td>
                    <td>'.$data['issn'].'</td>
                    <td>'.$data['Currency'].' - '.$data['Price']. '</td>
                </tr>
            ';
                        $no++;
                    endforeach;        
    echo '</table>';

}

    public function actionExportPdfBukuIndukData() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = " SELECT collections.ID,
                collections.NoInduk,
                catalogs.Title AS Judul,
                Author AS Pengarang,
                PublishLocation AS TempatTerbit,
                Publisher AS Penerbit,
                PublishYear AS TahunTerbit,
                (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END) AS Edisi,
                collections.Currency,
                DeweyNo AS NoKelas,
                (SELECT catalogs.ISBN FROM catalogs WHERE collections.Catalog_id = catalogs.ID) AS i,
                collections.TanggalPengadaan,
                worksheets.Name AS JenisBahan,
                partners.Name AS Partner,
                collectionmedias.Name AS BentukFisik,
                catalogs.PhysicalDescription AS deskripsi,
                collectionsources.name AS JenisSumber,
                collectioncategorys.Name AS Kategori,
                collections.Price,
                (SELECT IF(catalog_ruas.Tag NOT IN ('022'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS issn
                ,
                (SELECT IF(catalog_ruas.Tag NOT IN ('020'),NULL, SPLIT_STR(catalog_ruas.Value,' ',2))) AS isbn
                , 
                master_kelas_besar.kdKelas AS klass
                FROM collections
                LEFT JOIN catalogs ON collections.Catalog_id = catalogs.ID
                LEFT JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                LEFT JOIN partners ON collections.Partner_ID = partners.ID 
                LEFT JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID
                LEFT JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                LEFT JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                LEFT JOIN master_kelas_besar ON SUBSTRING(catalogs.DeweyNo, 1, 1) = SUBSTRING(master_kelas_besar.kdKelas, 1, 1) 
                LEFT JOIN catalog_ruas ON catalog_ruas.CatalogId = catalogs.ID
                WHERE DATE(collections.TanggalPengadaan) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " AND catalog_ruas.Tag IN ('020','022') GROUP BY collections.ID, issn, isbn";
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
            $set = 60;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Frekuensi',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-tampilkan-data-buku-induk', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

}

    /////// Koleksi AccessionList Area
    /**
     * [actionAccessionList description]
     * @return [type] [description]
     */
    public function actionAccessionList()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-accession-list',[
            'model' => $model,
            ]);
    }




    /**
     * [actionRenderPdfDataBukuIduk description]
     * @return [type] [description]
     */
    public function actionRenderPdfDataAccessionList() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $accesion = "CONCAT( '<b>',SUBSTRING_INDEX(catalogs.Title,' ',1),'</b>', SUBSTRING( Title,
                    LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', IFNULL((CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                    Edition END),' '),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('','<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',NoInduk) ) SEPARATOR '') )";

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian <br/>Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan <br/>Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan <br/>Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = "SELECT 
                Title AS judul, 
                (CASE
                 WHEN LENGTH(CONCAT( '',SUBSTRING_INDEX(catalogs.Title,' ',1),'', SUBSTRING( Title,
                LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                Edition END),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '',
                CONCAT('',' ',NoInduk) ) SEPARATOR '') )) >= 136 THEN 
                 CONCAT(SUBSTRING(".$accesion.",1,136),'<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                 SUBSTRING(".$accesion.",137))
                 ELSE ".$accesion."
                 END) AS AccessionList
                FROM 
                collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                WHERE DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " GROUP BY title,author,publishlocation,publisher,publishyear ORDER BY collections.TanggalPengadaan";

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
        

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-tampilkan-data-accession-lists', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelAccesionListData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
       $accesion = "CONCAT( '<b>',SUBSTRING_INDEX(catalogs.Title,' ',1),'</b>', SUBSTRING( Title,
                    LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', IFNULL((CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                    Edition END),' '),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('','<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',NoInduk) ) SEPARATOR '') )";

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian <br/>Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan <br/>Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan <br/>Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = "SELECT 
                Title AS judul, 
                CONCAT(
                (CASE
                 WHEN LENGTH(CONCAT( '',SUBSTRING_INDEX(catalogs.Title,' ',1),'', SUBSTRING( Title,
                LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                Edition END),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '',
                CONCAT('',' ',NoInduk) ) SEPARATOR '') )) >= 136 THEN 
                 CONCAT(SUBSTRING(".$accesion.",1,126),'<br>','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',SUBSTRING(".$accesion.",127))
                 ELSE ".$accesion."
                 END)
                ) AS AccessionList
                FROM 
                collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                WHERE DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " GROUP BY title,author,publishlocation,publisher,publishyear ORDER BY collections.TanggalPengadaan";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $filename = 'Laporan_Accession_List_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="7">Accession List (Daftar Koleksi Tambahan) '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="7">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr>
                    <td style="vertical-align: top;">'.$no.'</td>
                    <td colspan="7">'.$data['AccessionList'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtAcessionListData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $accesion = "CONCAT( '<b>',SUBSTRING_INDEX(catalogs.Title,' ',1),'</b>', SUBSTRING( Title,
                    LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', IFNULL((CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                    Edition END),' '),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('','<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',NoInduk) ) SEPARATOR '') )";

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian';
                $periode2 = ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan ';
                $periode2 = ' Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan ';
                $periode2 = ' Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = "SELECT 
                Title AS judul, 
                SUBSTRING_INDEX(catalogs.Title,' ',1) AS data,
                CONCAT(SUBSTRING( Title, LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1), ' -- ') AS data2,
                CONCAT(CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE Edition END,' -- ') AS data3,
                PublishLocation AS data4,
                Publisher AS data5,
                PublishYear AS data6,
                GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('</n>','','',NoInduk) ) SEPARATOR '') AS data7
                FROM 
                collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                WHERE DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " GROUP BY title,author,publishlocation,publisher,publishyear ORDER BY collections.TanggalPengadaan";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');


    // Open Office Calc Area
    $menu = 'Pemanfaatan Opac';

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'data'=> $model['data'],'data2'=> $model['data2'],'data3'=> $model['data3'],'data4'=> $model['data4'],'data5'=> $model['data5'],'data6'=> $model['data6'],'data7'=> $model['data7'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode'=>$periode,
        'periode2'=>$periode2,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-acession-list-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-koleksi-acession-list.ods');
    // !Open Office Calc Area


}

public function actionExportWordAccesionListData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $accesion = "CONCAT( '<b>',SUBSTRING_INDEX(catalogs.Title,' ',1),'</b>', SUBSTRING( Title,
                    LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', IFNULL((CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                    Edition END),' '),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('','<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',NoInduk) ) SEPARATOR '') )";

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian <br/>Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan <br/>Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan <br/>Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = "SELECT 
                Title AS judul, 
                CONCAT(
                (CASE
                 WHEN LENGTH(CONCAT( '',SUBSTRING_INDEX(catalogs.Title,' ',1),'', SUBSTRING( Title,
                LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                Edition END),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '',
                CONCAT('',' ',NoInduk) ) SEPARATOR '') )) >= 136 THEN 
                 CONCAT(SUBSTRING(".$accesion.",1,126),'<br>','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',SUBSTRING(".$accesion.",127))
                 ELSE ".$accesion."
                 END)
                ) AS AccessionList
                FROM 
                collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                WHERE DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " GROUP BY title,author,publishlocation,publisher,publishyear ORDER BY collections.TanggalPengadaan";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $type = $_GET['type'];
    $filename = 'Laporan_Accession_List_Data.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
                <p align="center"> <b>Accession List (Daftar Koleksi Tambahan) '.$format_hari.' <br />Berdasarkan '.$Berdasarkan.' </b></p>
            ';
    echo '</table>';
        $no = 1;
    echo '<table border="0" align="center"> ';
        foreach($model as $data):
        echo '
                <tr align="left">
                    <td style="vertical-align: top;">'.$no.'</td>
                    <td colspan="6">'.$data['AccessionList'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfAccesionListData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $accesion = "CONCAT( '<b>',SUBSTRING_INDEX(catalogs.Title,' ',1),'</b>', SUBSTRING( Title,
                    LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', IFNULL((CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                    Edition END),' '),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '', CONCAT('','<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',NoInduk) ) SEPARATOR '') )";

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode = 'Harian <br/>Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan <br/>Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan <br/>Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }



        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Library_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Location_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Source_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Partner_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Currency = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Category_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0"  ) {
                    $andValue .= ' AND Rule_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.Worksheet_id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Media_Id = "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Subject = "'.addslashes($value).'" ';
                }
            }
        } 


        if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) >= "'.substr($value,0,1).'" ';
                }
            }
        } 
        if (isset($_POST['tono_klas'])) {
            foreach ($_POST['tono_klas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND SUBSTR(catalogs.DeweyNo,1,1) <= "'.substr($value,0,1).'" ';
                }
            }
        } 
            // End No Klas

        if (isset($_POST['no_panggil'])) {
            foreach ($_POST['no_panggil'] as $key => $value) {
                if ($value != "0" ) {

                    if ($_POST['pilihNoPanggil'][$key] == "dimulai_dengan") 
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'%" ';
                    } 
                    else if ($_POST['pilihNoPanggil'][$key] == "diakhiri_dengan")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'" ';
                    }
                    else if ($_POST['pilihNoPanggil'][$key] == "salah_satu_isi")
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "%'.addslashes(substr($value,0,1)).'%" ';
                    }
                    else
                    {
                        $andValue .= ' AND collections.CallNumber LIKE "'.addslashes(substr($value,0,1)).'" ';
                    } 
                }
            }
        } 

        if (isset($_POST['createdate'])) {
            foreach ($_POST['createdate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['tocreatedate'])) {
            foreach ($_POST['tocreatedate'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(collections.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 

        if (isset($_POST['createby'])) {
            foreach ($_POST['createby'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  collections.CreateBy = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['harga'])) {
            foreach ($_POST['harga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price >= "'.$value.'" ';
                }
            }
        } 

        if (isset($_POST['toharga'])) {
            foreach ($_POST['toharga'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Price <= "'.$value.'" ';
                }
            }
        } 

        $sql = "SELECT 
                Title AS judul, 
                CONCAT(
                (CASE
                 WHEN LENGTH(CONCAT( '',SUBSTRING_INDEX(catalogs.Title,' ',1),'', SUBSTRING( Title,
                LENGTH(SUBSTRING_INDEX(catalogs.Title,' ',1))+1),' -- ', (CASE WHEN EDISISERIAL IS NOT NULL THEN EdisiSerial ELSE
                Edition END),' -- ', PublishLocation,' ', Publisher,' ', PublishYear, GROUP_CONCAT( IF(NoInduk IS NULL OR NoInduk = '', '',
                CONCAT('',' ',NoInduk) ) SEPARATOR '') )) >= 136 THEN 
                 CONCAT(SUBSTRING(".$accesion.",1,136),'<br />','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',SUBSTRING(".$accesion.",137))
                 ELSE ".$accesion."
                 END)
                ) AS AccessionList
                FROM 
                collections 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID 
                INNER JOIN collectionsources ON collections.Source_ID = collectionsources.ID 
                INNER JOIN collectionmedias ON collections.Media_ID = collectionmedias.ID 
                INNER JOIN collectioncategorys ON collections.Category_ID = collectioncategorys.ID 
                INNER JOIN collectionrules ON collections.Rule_ID = collectionrules.ID 
                WHERE DATE(collections.TanggalPengadaan) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " GROUP BY title,author,publishlocation,publisher,publishyear ORDER BY collections.TanggalPengadaan";

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
        

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] = $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ',$Berdasarkan);

        // if (count($_POST['kriterias']) == 1) {
        //     $Berdasarkan .= ' '.implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-tampilkan-data-accession-lists', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

    /**
     * [actionUcapanTerimakasih description]
     * @return [type] [description]
     */
    public function actionUcapanTerimakasih()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-ucapan-terimakasih',[
            'model' => $model,
            ]);
    }

    /**
     * [actionRenderPdfUcapanTerimakasih description]
     * @return [type] [description]
     */
    public function actionRenderPdfUcapanTerimakasih() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue1 = '';
        $andValue2 = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        //
        // $periode = $_POST['perolehan_date'];
        $periode = date("d-m-Y", strtotime($_POST['perolehan_date']) );

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue1 .= " collectionsources.ID = '".$value."' ";
                    }
                }
            } 
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue2 .= " partners.ID = '".$value."' ";
                    }
                }
            }  

        if (implode($_POST['collectionsources'])  == '0' && implode($_POST['partners']) == '0') {
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id ";
        }else if (implode($_POST['collectionsources'])  != '0' && implode($_POST['partners']) != '0'){
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ".$andValue1." and ".$andValue2." ";
        }else{
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ";
        $sql .= $andValue1;
        $sql .= $andValue2;
        }

// print_r($periode);
// die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['sql'] = $sql; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-tampilkan-ucapanterimakasih', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelUcapanTerimaKasih()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue1 = '';
        $andValue2 = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        //
        // $periode = $_POST['perolehan_date'];
        $periode = date("d-m-Y", strtotime($_POST['perolehan_date']) );

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue1 .= " collectionsources.ID = '".$value."' ";
                    }
                }
            } 
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue2 .= " partners.ID = '".$value."' ";
                    }
                }
            }  

        if (implode($_POST['collectionsources'])  == '0' && implode($_POST['partners']) == '0') {
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id ";
        }else if (implode($_POST['collectionsources'])  != '0' && implode($_POST['partners']) != '0'){
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ".$andValue1." and ".$andValue2." ";
        }else{
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ";
        $sql .= $andValue1;
        $sql .= $andValue2;
        }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    // $Berdasarkan = array();
    //     foreach ($_POST['kriterias'] as $key => $value) {
    //         $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
    //     }
    //     $Berdasarkan = implode(' dan ', $Berdasarkan);

    $filename = 'Laporan_Periodik_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <td width="100px">Nomor </td>
                <td>:</td>
            </tr>
            <tr>
                <td>Perihal </td>
                <td>: Ucapan Terima Kasih </td>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
                <td>Dengan Hormat, </td>
            </tr>
            <tr>
                <td colspan="3">Melalui surat ini kami informasikan bahwa sumbangan koleksi berupa : </td>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['pengarang'].'</td>
                    <td>'.$data['penerbit'].'</td>
                </tr>
            ';
        $no++;
        endforeach;

        echo '<table border="0" align="center"> 
            <tr>
            </tr>
            <tr>
                <td colspan="3">Telah kami terima dalam keadaan baik. Sumbangan tersebut sangat bermanfaat bagi kami.</td>
            </tr>
            <tr>
                <td colspan="3">Atas partisipasi dan perhatiannya kami ucapkan terima kasih.</td>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
                <td>Jakarta, ' .$periode.'</td>
            </tr>
            ';
        
    echo '</table>';

}

public function actionExportExcelOdtUcapanTerimaKasih()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue1 = '';
        $andValue2 = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        //
        // $periode = $_POST['perolehan_date'];
        $periode = date("d-m-Y", strtotime($_POST['perolehan_date']) );

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue1 .= " collectionsources.ID = '".$value."' ";
                    }
                }
            } 
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue2 .= " partners.ID = '".$value."' ";
                    }
                }
            }  

        if (implode($_POST['collectionsources'])  == '0' && implode($_POST['partners']) == '0') {
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id ";
        }else if (implode($_POST['collectionsources'])  != '0' && implode($_POST['partners']) != '0'){
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ".$andValue1." and ".$andValue2." ";
        }else{
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ";
        $sql .= $andValue1;
        $sql .= $andValue2;
        }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $format_hari = $periode;

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Judul'=> $model['Judul'], 'pengarang'=>$model['pengarang'], 'penerbit'=>$model['penerbit'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode'=>$periode,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-ucapan-terima-kasih.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-ucapan-terimakasih.ods');
    // !Open Office Calc Area


}

public function actionExportWordUcapanTerimaKasih()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue1 = '';
        $andValue2 = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        //
        // $periode = $_POST['perolehan_date'];
        $periode = date("d-m-Y", strtotime($_POST['perolehan_date']) );

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue1 .= " collectionsources.ID = '".$value."' ";
                    }
                }
            } 
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue2 .= " partners.ID = '".$value."' ";
                    }
                }
            }  

        if (implode($_POST['collectionsources'])  == '0' && implode($_POST['partners']) == '0') {
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id ";
        }else if (implode($_POST['collectionsources'])  != '0' && implode($_POST['partners']) != '0'){
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ".$andValue1." and ".$andValue2." ";
        }else{
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ";
        $sql .= $andValue1;
        $sql .= $andValue2;
        }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    // $Berdasarkan = array();
    //     foreach ($_POST['kriterias'] as $key => $value) {
    //         $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
    //     }
    //     $Berdasarkan = implode(' dan ', $Berdasarkan);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '

                <p>Nomor :</p>
                <p>Perihal : Ucapan Terima Kasih</p>


                <p>Dengan Hormat,<br>Melalui surat ini kami informasikan bahwa sumbangan koleksi berupa : </p>




        ';
     if ($type != "doc") {
        echo '<table border="0">';
     }else{echo '<table border="1">';}
        '<tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['pengarang'].'</td>
                    <td>'.$data['penerbit'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        echo '</table>';

        echo '

                <p>Telah kami terima dalam keadaan baik. Sumbangan tersebut sangat bermanfaat bagi kami.<br />Atas partisipasi dan perhatiannya kami ucapkan terima kasih.<br /><br /><br /></p>




                <p>Jakarta, ' .$periode.'</p>

            ';
        

}

public function actionExportPdfUcapanTerimaKasih()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue1 = '';
        $andValue2 = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        //
        $periode = $_POST['perolehan_date'];

        if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue1 .= " collectionsources.ID = '".$value."' ";
                    }
                }
            } 
        if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue2 .= " partners.ID = '".$value."' ";
                    }
                }
            }  

        if (implode($_POST['collectionsources'])  == '0' && implode($_POST['partners']) == '0') {
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id ";
        }else if (implode($_POST['collectionsources'])  != '0' && implode($_POST['partners']) != '0'){
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ".$andValue1." and ".$andValue2." ";
        }else{
            $sql = "SELECT catalogs.Title AS Judul, 
                    catalogs.Author AS pengarang, 
                    catalogs.Publisher AS penerbit 
                    FROM catalogs 
                    INNER JOIN collections ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN collectionsources ON collectionsources.ID = collections.Source_id
                    INNER JOIN partners ON partners.ID = collections.Partner_id 
                    where ";
        $sql .= $andValue1;
        $sql .= $andValue2;
        }


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['sql'] = $sql; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-tampilkan-ucapanterimakasih', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

    // Laporan Usulan Koleksi
    
    /**
     * [actionUcapanTerimakasih description]
     * @return [type] [description]
     */
    public function actionUsulanKoleksi()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-usulan-koleksi',[
            'model' => $model,
            ]);
    }

    /**
     * [actionRenderPdfFrekuensiUsulanKoleksi description]
     * @return [type] [description]
     */
    public function actionRenderPdfFrekuensiUsulanKoleksi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'CONCAT(members.MemberNo, ' - ', members.Fullname) AS Subjek';
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.PublishLocation AS Subjek';
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.Publisher AS Subjek';
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishYear = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'requestcatalog.PublishYear AS Subjek';
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode,
        DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode2, 
        ".$subjek.",
        COUNT(DISTINCT Title) AS CountJudul 
        FROM requestcatalog   
        INNER JOIN members ON requestcatalog.MemberID = members.ID 
        WHERE DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;

        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(requestcatalog.DateRequest,'%d-%m-%Y') ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        // Untuk Sub Judul Berdasarkan
        // if (count($_POST['kriterias']) == 1) {
        //     $kriteria = implode($_POST['kriterias']);
        //     $value = implode($_POST[$kriteria]);
        //     // $Berdasarkan = $this->getRealNameKriteria($kriteria).' : '.$value;
        //     $Berdasarkan = $this->getRealNameKriteria($kriteria);
        // } else {
        //     $Berdasarkan = '';
        //     foreach ($_POST['kriterias'] as $key => $value) {
        //         ($key != 1 ? null : $Berdasarkan .= ' dan ');
        //         $Berdasarkan .= $this->getRealNameKriteria($value);
        //     }
        // }

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['Berdasarkan'] = $Berdasarkan; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-frekuensi-usulan', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelUsulanKoleksiFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'CONCAT(members.MemberNo, ' - ', members.Fullname) AS Subjek';
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.PublishLocation AS Subjek';
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.Publisher AS Subjek';
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishYear = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'requestcatalog.PublishYear AS Subjek';
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode,
        DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode2, 
        ".$subjek.",
        COUNT(DISTINCT Title) AS CountJudul 
        FROM requestcatalog   
        INNER JOIN members ON requestcatalog.MemberID = members.ID 
        WHERE DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;

        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(requestcatalog.DateRequest,'%d-%m-%Y') ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $filename = 'Laporan_Periodik_Frekuensi.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Usulan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode Pengadaan</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Judul Diusulkan</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['Subjek'].'</td>'; }
    echo'
                    <td>'.$data['CountJudul'].'</td>
                </tr>
            ';
                        $Jumlah = $Jumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="2"';} else {echo 'colspan="3"';}echo ' style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtUsulanKoleksiFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'CONCAT(members.MemberNo, ' - ', members.Fullname) AS Subjek';
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.PublishLocation AS Subjek';
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.Publisher AS Subjek';
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishYear = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'requestcatalog.PublishYear AS Subjek';
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode,
        DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode2, 
        ".$subjek.",
        COUNT(DISTINCT Title) AS CountJudul 
        FROM requestcatalog   
        INNER JOIN members ON requestcatalog.MemberID = members.ID 
        WHERE DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;

        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(requestcatalog.DateRequest,'%d-%m-%Y') ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Subjek'=>$model['Subjek'], 'CountJudul'=>$model['CountJudul'] );
            $CountJudul = $CountJudul + $model['CountJudul'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalCountJudul'=>$CountJudul,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-usulan-koleksi-frekuensi.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-usulan-koleksi-frekuensi_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-usulan-koleksi-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordUsulanKoleksiFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'CONCAT(members.MemberNo, ' - ', members.Fullname) AS Subjek';
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.PublishLocation AS Subjek';
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.Publisher AS Subjek';
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishYear = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'requestcatalog.PublishYear AS Subjek';
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode,
        DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode2, 
        ".$subjek.",
        COUNT(DISTINCT Title) AS CountJudul 
        FROM requestcatalog   
        INNER JOIN members ON requestcatalog.MemberID = members.ID 
        WHERE DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;

        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(requestcatalog.DateRequest,'%d-%m-%Y') ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Usulan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode Pengadaan</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Judul Diusulkan</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['Subjek'].'</td>'; }
    echo'
                    <td>'.$data['CountJudul'].'</td>
                </tr>
            ';
                        $Jumlah = $Jumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="2"';} else {echo 'colspan="3"';}echo ' style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfUsulanKoleksiFrekuensi()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'CONCAT(members.MemberNo, ' - ', members.Fullname) AS Subjek';
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.PublishLocation AS Subjek';
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        $subjek = 'requestcatalog.Publisher AS Subjek';
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND requestcatalog.PublishYear = "'.addslashes($value).'" ';
                }
            }
        $subjek = 'requestcatalog.PublishYear AS Subjek';
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode,
        DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS Periode2, 
        ".$subjek.",
        COUNT(DISTINCT Title) AS CountJudul 
        FROM requestcatalog   
        INNER JOIN members ON requestcatalog.MemberID = members.ID 
        WHERE DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;

        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(requestcatalog.DateRequest,'%d-%m-%Y') ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(requestcatalog.DateRequest) ORDER BY DATE_FORMAT(requestcatalog.DateRequest,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        // Untuk Sub Judul Berdasarkan
        // if (count($_POST['kriterias']) == 1) {
        //     $kriteria = implode($_POST['kriterias']);
        //     $value = implode($_POST[$kriteria]);
        //     // $Berdasarkan = $this->getRealNameKriteria($kriteria).' : '.$value;
        //     $Berdasarkan = $this->getRealNameKriteria($kriteria);
        // } else {
        //     $Berdasarkan = '';
        //     foreach ($_POST['kriterias'] as $key => $value) {
        //         ($key != 1 ? null : $Berdasarkan .= ' dan ');
        //         $Berdasarkan .= $this->getRealNameKriteria($value);
        //     }
        // }

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['Berdasarkan'] = $Berdasarkan; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Frekuensi',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-frekuensi-usulan', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


    /**
     * [actionRenderPdfDataUsulanKoleksi description]
     * @return [type] [description]
     */
    public function actionRenderPdfDataUsulanKoleksi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Usulan Koleksi Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS TanggalPengusulan, 
                Title as Judul, 
                CONCAT(PublishLocation,' ',Publisher,' ',PublishLocation) as Penerbitan,
                members.FullName as Anggota, 
                (CASE WHEN Status IS NULL THEN 'Usulan' ELSE Status END) as StatusUsulan 
                FROM requestcatalog 
                INNER JOIN members ON requestcatalog.MemberID = members.ID AND 
                DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY requestcatalog.DateRequest ";

        // Untuk Sub Judul Berdasarkan
        // if (count($_POST['kriterias']) == 1) {
        //     $kriteria = implode($_POST['kriterias']);
        //     $value = implode($_POST[$kriteria]);
        //     // $Berdasarkan = $this->getRealNameKriteria($kriteria).' : '.$value;
        //     $Berdasarkan = $this->getRealNameKriteria($kriteria);
        // } else {
        //     $Berdasarkan = '';
        //     foreach ($_POST['kriterias'] as $key => $value) {
        //         ($key != 1 ? null : $Berdasarkan .= ' dan ');
        //         $Berdasarkan .= $this->getRealNameKriteria($value);
        //     }
        // }
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);


        $content['LaporanKriteria'] = ""; 
        $content['Berdasarkan'] = $Berdasarkan; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;   
        } else {
            $header =  [''];
            $set = 10;   
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-data-usulan', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelUsulanKoleksiData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan'; 
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS TanggalPengusulan, 
                Title as Judul, 
                CONCAT(PublishLocation,' ',Publisher,' ',PublishLocation) as Penerbitan,
                members.FullName as Anggota, 
                (CASE WHEN Status IS NULL THEN 'Usulan' ELSE Status END) as StatusUsulan 
                FROM requestcatalog 
                INNER JOIN members ON requestcatalog.MemberID = members.ID AND 
                DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY requestcatalog.DateRequest ";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $filename = 'Laporan_Periodik_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="6">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pengusulan</th>
                <th>Judul</th>
                <th>Penerbitan</th>
                <th>Anggota Pengusul</th>
                <th>Status Usulan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPengusulan'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Penerbitan'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['StatusUsulan'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtUsulanKoleksiData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan'; 
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS TanggalPengusulan, 
                Title as Judul, 
                CONCAT(PublishLocation,' ',Publisher,' ',PublishLocation) as Penerbitan,
                members.FullName as Anggota, 
                (CASE WHEN Status IS NULL THEN 'Usulan' ELSE Status END) as StatusUsulan 
                FROM requestcatalog 
                INNER JOIN members ON requestcatalog.MemberID = members.ID AND 
                DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY requestcatalog.DateRequest ";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'TanggalPengusulan'=> $model['TanggalPengusulan'], 'Judul'=>$model['Judul'], 'Penerbitan'=>$model['Penerbitan'], 'Anggota'=>$model['Anggota'], 'StatusUsulan'=>$model['StatusUsulan'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-koleksi-usulan-koleksi.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-koleksi-usulan-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordUsulanKoleksiData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan'; 
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS TanggalPengusulan, 
                Title as Judul, 
                CONCAT(PublishLocation,' ',Publisher,' ',PublishLocation) as Penerbitan,
                members.FullName as Anggota, 
                (CASE WHEN Status IS NULL THEN 'Usulan' ELSE Status END) as StatusUsulan 
                FROM requestcatalog 
                INNER JOIN members ON requestcatalog.MemberID = members.ID AND 
                DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY requestcatalog.DateRequest ";

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Data.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th colspan="6">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Pengadaan Koleksi '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 10px; margin-left: 10px;">
                <th>No.</th>
                <th>Tanggal Pengusulan</th>
                <th>Judul</th>
                <th>Penerbitan</th>
                <th>Anggota Pengusul</th>
                <th>Status Usulan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPengusulan'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Penerbitan'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['StatusUsulan'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfUsulanKoleksiData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Tahunan';
                $periode2 = 'Usulan Koleksi Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['AnggotaPengusul'])) {
            foreach ($_POST['AnggotaPengusul'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND MemberID = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND catalogs.PublishLocation LIKE "%'.addslashes($value).'%" ';
                }
            }
        } 

        if (isset($_POST['Publisher'])) {
            foreach ($_POST['Publisher'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND Publisher LIKE "%'.addslashes($value).'%" ';
                }
            }
        }   

        if (isset($_POST['PublishYear'])) {
            foreach ($_POST['PublishYear'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishYear = "'.addslashes($value).'" ';
                }
            }
        } 



        $sql = "SELECT DATE_FORMAT(requestcatalog.DateRequest,'".$periode_format."') AS TanggalPengusulan, 
                Title as Judul, 
                CONCAT(PublishLocation,' ',Publisher,' ',PublishLocation) as Penerbitan,
                members.FullName as Anggota, 
                (CASE WHEN Status IS NULL THEN 'Usulan' ELSE Status END) as StatusUsulan 
                FROM requestcatalog 
                INNER JOIN members ON requestcatalog.MemberID = members.ID AND 
                DATE(requestcatalog.DateRequest) ";

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= " ORDER BY requestcatalog.DateRequest ";

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);


        $content['LaporanKriteria'] = ""; 
        $content['Berdasarkan'] = $Berdasarkan; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;   
        } else {
            $header =  [''];
            $set = 10;   
        }


        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-data-usulan', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

}

    // Laporan Koleksi Kinerja user
    
    /**
     * [actionKinerjaUser description]
     * @return [type] [description]
     */
    public function actionKinerjaUser()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-kinerja-user',[
            'model' => $model,
            ]);
    }

    /**
     * [actionRenderPdfFrekuensiKinerjaUser description]
     * @return [type] [description]
     */
    public function actionRenderPdfFrekuensiKinerjaUser() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];   
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Koleksi';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = " SELECT DATE_FORMAT(modelhistory.date,'".$periode_format."') AS Periode,
                UserName as Kataloger,
                COUNT(modelhistory.ID) AS Jumlah 
                FROM modelhistory 
                INNER JOIN users ON modelhistory.user_id = users.ID
                WHERE DATE(modelhistory.date) ";

        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        if(sizeof($DetailFilter['kataloger']) != '' || ($_POST['Action']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(sizeof($DetailFilter['kataloger']) != '' && ($_POST['Action']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // print_r($dan);
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['DetailFilter'] = $DetailFilter; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['a'] = $a; 
        $content['dan'] = $dan; 
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-frekuensi-kinerja', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

}

public function actionExportExcelKinerjaUserFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];   
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Koleksi';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = " SELECT DATE_FORMAT(modelhistory.date,'".$periode_format."') AS Periode,
                UserName as Kataloger,
                COUNT(modelhistory.ID) AS Jumlah 
                FROM modelhistory 
                INNER JOIN users ON modelhistory.user_id = users.ID
                WHERE DATE(modelhistory.date) ";

        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        if(sizeof($DetailFilter['kataloger']) != '' || ($_POST['Action']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(sizeof($DetailFilter['kataloger']) != '' && ($_POST['Action']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // print_r($dan);
        // die;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode; 

    $filename = 'Laporan_Periodik_Frekuensi.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="4">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="4">Kinerja User '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="4">'.$a.' '.$DetailFilter['action'].' '.$dan.' '.$DetailFilter['kataloger'].'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 20px; margin-left: 20px;">
                <th>No.</th>
                <th>Periode</th>
                <th>Kataloger</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
        $Jumlah = $Jumlah + $data['Jumlah'];
        $no++;
        endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>                   
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtKinerjaUserFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];   
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Koleksi';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = " SELECT DATE_FORMAT(modelhistory.date,'".$periode_format."') AS Periode,
                UserName as Kataloger,
                COUNT(modelhistory.ID) AS Jumlah 
                FROM modelhistory 
                INNER JOIN users ON modelhistory.user_id = users.ID
                WHERE DATE(modelhistory.date) ";

        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        if(sizeof($DetailFilter['kataloger']) != '' || ($_POST['Action']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(sizeof($DetailFilter['kataloger']) != '' && ($_POST['Action']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    $DetailFilterKriteria = $DetailFilter['action'];
    $DetailFilterKataloger = $DetailFilter['kataloger'];

    $headers = Yii::getAlias('@webroot','/teeeesst');


    // Open Office Calc Area
    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Kataloger'=>$model['Kataloger'], 'Jumlah'=>$model['Jumlah'] );
            $TotalJumlah = $TotalJumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$TotalJumlah,
        'a'=>$a,
        'dan'=>$dan,
        'DetailFilterKriteria'=>$DetailFilterKriteria,
        'DetailFilterKataloger'=>$DetailFilterKataloger,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-katalog-kinerja-user.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-koleksi-kinerja-user-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];   
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Koleksi';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = " SELECT DATE_FORMAT(modelhistory.date,'".$periode_format."') AS Periode,
                UserName as Kataloger,
                COUNT(modelhistory.ID) AS Jumlah 
                FROM modelhistory 
                INNER JOIN users ON modelhistory.user_id = users.ID
                WHERE DATE(modelhistory.date) ";

        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        if(sizeof($DetailFilter['kataloger']) != '' || ($_POST['Action']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(sizeof($DetailFilter['kataloger']) != '' && ($_POST['Action']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // print_r($dan);
        // die;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode; 

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");

    echo '<table border="0" align="center"> 
                <p align="center"> <b>Laporan Frekuensi '.$format_hari.' </b></p>
                <p align="center"> <b>Kinerja User '.$periode2.' </b></p>
                <p align="center"> <b>'.$a.' '.$DetailFilter['action'].' '.$dan.' '.$DetailFilter['kataloger'].'</b></p>
            ';
    echo '</table>';
        
    if ($type == 'odt') {
    echo '<table border="0" align="center" width="700"> ';
    }else{echo '<table border="1" align="center" width="700"> ';}
        echo '
                <tr>
                    <th>No.</th>
                    <th>Periode</th>
                    <th>Kataloger</th>
                    <th>Jumlah</th>
                </tr>
            '; 
    $no = 1;
    $Jumlah = 0;
    if ($type == 'odt') {
    echo '<table border="0" align="center"> ';
    }
    foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
        $Jumlah = $Jumlah + $data['Jumlah'];
        $no++;
        endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>                   
                    </tr>
                    ';
    
    echo '</table>';

}

public function actionExportPdfKinerjaUserFrekuensi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = '%d-%M-%Y';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = '%M-%Y';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];   
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = '%Y';
                $periode = 'Koleksi';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = " SELECT DATE_FORMAT(modelhistory.date,'".$periode_format."') AS Periode,
                UserName as Kataloger,
                COUNT(modelhistory.ID) AS Jumlah 
                FROM modelhistory 
                INNER JOIN users ON modelhistory.user_id = users.ID
                WHERE DATE(modelhistory.date) ";

        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        if(sizeof($DetailFilter['kataloger']) != '' || ($_POST['Action']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(sizeof($DetailFilter['kataloger']) != '' && ($_POST['Action']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // print_r($dan);
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['DetailFilter'] = $DetailFilter; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['a'] = $a; 
        $content['dan'] = $dan; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Frekuensi',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-frekuensi-kinerja', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

}

    /**
     * [actionRenderPdfDataUsulanKoleksi description]
     * @return [type] [description]
     */
    public function actionRenderPdfDataKinerjaUser() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

        if (isset($_POST['periode'])) 
        {
            
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = "SELECT ".$periode_format.",
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Menambahkan' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections'";
        $sql .= $andValue;

        // print_r($dan);
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['DetailFilter'] = $DetailFilter;
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf-view-koleksi-data-kinerja', $content),
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelKinerjaUserData()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }

            if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Menambahkan' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $filename = 'Laporan_Periodik_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="5">Laporan data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Kinerja User Katalog '.$periode2.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Username</th>
                <th>Aktifitas Jenis</th>
                <th>Kegiatan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['nama_kriteria'].'</td>
                    <td>'.$data['actions'].'</td>
                </tr>
            ';
         $no++;
        endforeach; 
    echo '</table>';

}

public function actionExportExcelOdtKinerjaUserData()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }

            if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Menambahkan' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog' ,'' )
                END
                ) AS actions,
                catalogs.Title AS title
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    // Open Office Calc Area
    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Kataloger'=>$model['Kataloger'], 'f_id'=>$model['f_id'], 'kriteria'=>$model['kriteria'], 'nama_kriteria'=>$model['nama_kriteria'], 'actions'=>$model['actions'], 'title'=>$model['title'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'a'=>$a,
        'dan'=>$dan,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/koleksi/laporan-katalog-kinerja-user-data.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-kinerja-user-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserData()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }

            if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Menambahkan' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
                 END AS nama_kriteria,
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;

$headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;
// $test = self::getRealNameKriteria($kriterias);

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
               <p align="center"> <b>Laporan Frekuensi '.$format_hari.' </b></p>
               <p align="center"> <b>Kinerja User Katalog '.$periode2.' </b></p>
            ';
    echo '</table>';
    if ($type == 'odt') {
    echo '<table border="0" align="center" width="700"> ';
    }else{echo '<table border="1" align="center" width="700"> ';}
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Username</th>
                <th>Aktifitas Jenis</th>
                <th>Kegiatan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['nama_kriteria'].'</td>
                    <td>'.$data['actions'].'</td>
                </tr>
            ';
         $no++;
        endforeach; 
    echo '</table>';

}

public function actionExportPdfKinerjaUserData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

        if (isset($_POST['periode'])) 
        {
            
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['kataloger'])) {
            foreach ($_POST['kataloger'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND modelhistory.user_id  = '".$value."' ";
                    $DetailFilter['kataloger'] = "Kataloger "; 
                    }else{
                        $DetailFilter['kataloger'] = null;
                    }
                }
            }
        
        if ($_POST['Action'] != '') {
                $andValue .= ' AND modelhistory.type = "'.$_POST['Action'].'" ';
            } 

            switch ($_POST['Action']) {
            case '0':
                $DetailFilter['action'] = ' (Koleksi dibuat) ';
                break;
            
            case '1':
                $DetailFilter['action'] = ' (Koleksi dimutakhirkan) ';
                break;

            case '2':
                $DetailFilter['action'] = ' (Koleksi dihapus) ';
                break;
            
            default:
                $DetailFilter['action'] = null;
                break;
        }

        $sql = "SELECT ".$periode_format.",
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Menambahkan' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collections'";
        $sql .= $andValue;

        // print_r($dan);
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['DetailFilter'] = $DetailFilter;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Page {PAGENO}</div>'],
            ],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-data-kinerja', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


    /**
     * [getRealNameKriteria description]
     * @param  [type] $kriterias [description]
     * @return [type]            [description]
     */
    public function getRealNameKriteria($kriterias)
    {
        if ($kriterias == 'PublishLocation') 
        {
            $name = 'Kota Terbit';
        } 
        elseif ($kriterias == 'Publisher') 
        {
            $name = 'Nama Penerbit';
        }
        elseif ($kriterias == 'PublishYear') 
        {
            $name = 'Tahun Terbit';
        }
        elseif ($kriterias == 'location_library') 
        {
            $name = 'Lokasi Perpustakaan';
        }
        elseif ($kriterias == 'locations') 
        {
            $name = 'Lokasi';
        }
        elseif ($kriterias == 'collectioncategorys') 
        {
            $name = 'Kategori';
        }
        elseif ($kriterias == 'collectionsources') 
        {
            $name = 'Jenis Sumber Perolehan';
        }
        elseif ($kriterias == 'partners') 
        {
            $name = 'Nama Sumber/Rekanan Perolehan';
        }
        elseif ($kriterias == 'currency') 
        {
            $name = 'Mata Uang';
        }
        elseif ($kriterias == 'harga') 
        {
            $name = 'Harga';
        }
        elseif ($kriterias == 'kategori') 
        {
            $name = 'Kategori';
        }
        elseif ($kriterias == 'petugas') 
        {
            $name = 'Kataloger';
        }
        elseif ($kriterias == 'collectionrules') 
        {
            $name = 'Jenis Akses';
        }
        elseif ($kriterias == 'worksheets') 
        {
            $name = 'Jenis Bahan';
        }
        elseif ($kriterias == 'collectionmedias') 
        {
            $name = 'Jenis Media';
        }
        elseif ($kriterias == 'Subject') 
        {
            $name = 'Subjek';
        }
        elseif ($kriterias == 'no_klas') 
        {
            $name = 'No. Klas';
        }
        elseif ($kriterias == 'no_panggil') 
        {
            $name = 'No. Panggil';
        }
        elseif ($kriterias == 'createdate') 
        {
            $name = 'Tanggal Entri';
        }
        elseif ($kriterias == 'createby') 
        {
            $name = 'Kataloger';
        }
        elseif ($kriterias == 'data_entry') 
        {
            $name = 'Tanggal Entri Data';
        }
        elseif ($kriterias == 'AnggotaPengusul') 
        {
            $name = 'Anggota Pengusul';
        }
        else 
        {
            $name = ' ';
        }
        
        return $name;

    }
}
