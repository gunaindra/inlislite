<?php

namespace backend\modules\laporan\controllers;


use Yii;
use yii\helpers\Url;
use yii\web\Response;
//Widget
//use kartik\widgets\Select2;
use kartik\mpdf\Pdf;
use kartik\date\DatePicker;

//Helpers
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class SmsController extends \yii\web\Controller
{
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLaporanPeriodik()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('laporan-periodik',[
            'model' => $model,
            ]);
    }
    

public function actionLoadFilterKriteria($kriteria)
{
        if ($kriteria == 'peminjaman')
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

        else if ($kriteria == 'no_anggota')
        {  
            $sql = 'SELECT * FROM members';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 

            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['MemberNo'].' - '.$model['Fullname'];
                });
            $options[0] = "---Semua---";
            asort($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );

        }

        else if ($kriteria == 'jatuh_tempo')
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

        else
        {
            $contentOptions = null;
        }
        return $contentOptions;
        
    }

     
    public function actionLoadSelecterLaporanPeriodik($i)
    {
        return $this->renderPartial('select-laporan-periodik',['i'=>$i]);
    }

    public function actionShowPdf($tampilkan)
    {
      
        // session_start();
        $_SESSION['Array_POST_Filter'] = $_POST;

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // print_r(count(array_filter($_POST['kriterias'])));
        // print_r(isset($_POST['kota_terbit']));
        if ($tampilkan == 'laporan-periodik-frekuensi')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-laporan-periodik-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }elseif ($tampilkan == 'laporan-periodik-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-laporan-periodik-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }
        elseif ($tampilkan == 'export-excel')
        {            
            echo '<iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('export').'">';
            echo "<iframe>";
        }
        
    }

public function actionRenderLaporanPeriodikData() 
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
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
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
            if (isset($_POST['ip'])) {
            foreach ($_POST['ip'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND opaclogs.IP = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['jenis_pencarian'])) {
            foreach ($_POST['jenis_pencarian'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND opaclogs.jenis_pencarian = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['ruas_pencarian'])) {
            foreach ($_POST['ruas_pencarian'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND TRIM(SUBSTRING_INDEX(opaclogs.keyword,'=',1)) = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['keyword'])) {
            foreach ($_POST['keyword'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND TRIM(SUBSTRING_INDEX(opaclogs.keyword,'=',-1)) = '".addslashes($value)."' ";
                    }
                }
            }

                
           $sql = "SELECT DATE_FORMAT(opaclogs.waktu,'%d-%m-%Y') AS TglAkses,
                    opaclogs.IP AS ip,
                    opaclogs.jenis_pencarian AS JenisPencarian,
                    TRIM(SUBSTRING_INDEX(opaclogs.keyword,'=',1)) AS RuasPencarian,
                    TRIM(SUBSTRING_INDEX(opaclogs.keyword,'=',-1)) AS KataKunci 
                    FROM opaclogs 
                    WHERE DATE(opaclogs.waktu) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY opaclogs.waktu';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' (' .implode($_POST[implode($_POST['kriterias'])]). ')';
        // }

        // $Berdasarkan = '';
        // foreach ($_POST['kriterias'] as $key => $value) {
        //     $Berdasarkan .= $this->getRealNameKriteria($value).' ';
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
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
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
            'content' => $this->renderPartial('pdf-view-laporan-periodik-data', $content),
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


// /////////////////////////////////batas view_data dgn view_vrekuensi//////////////////////////////////// //     
public function actionRenderLaporanPeriodikFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%Y") Periode';
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


            if (isset($_POST['peminjaman'])) {
            foreach ($_POST['peminjaman'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.LoanDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['topeminjaman'])) {
                foreach ($_POST['topeminjaman'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }

            if (isset($_POST['jatuh_tempo'])) {
            foreach ($_POST['jatuh_tempo'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.DueDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['tojatuh_tempo'])) {
                foreach ($_POST['tojatuh_tempo'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }   
             
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.ID = '".addslashes($value)."' ";
                    }
                }
            }  

            
            $sql = "SELECT ".$periode_format.", 
                    notif_sms_gateway.member_id AS m_ID,
                    COUNT(notif_sms_gateway.ID) AS jum_anggota,
                    COUNT(notif_sms_gateway.collectionloanitem_id) AS jumlah_koleksi, 
                    (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'sukses' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS sukses_send, 
                     (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'gagal' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS gagal_send  
                    FROM notif_sms_gateway 
                    LEFT JOIN members ON members.ID = notif_sms_gateway.member_id 
                    LEFT JOIN collectionloanitems ON collectionloanitems.ID = notif_sms_gateway.member_id 
                    WHERE DATE(notif_sms_gateway.send_date) ";        
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(notif_sms_gateway.send_date,'%d-%m-%Y'), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' (' .implode($_POST[implode($_POST['kriterias'])]). ')';
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
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
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
            'content' => $this->renderPartial('pdf-view-laporan-periodik-frekuensi', $content),
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

public function actionExport()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

// var_dump($periode_format);
// die;

            if (isset($_POST['peminjaman'])) {
            foreach ($_POST['peminjaman'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.LoanDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['topeminjaman'])) {
                foreach ($_POST['topeminjaman'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }

            if (isset($_POST['jatuh_tempo'])) {
            foreach ($_POST['jatuh_tempo'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.DueDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['tojatuh_tempo'])) {
                foreach ($_POST['tojatuh_tempo'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }   
             
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.ID = '".addslashes($value)."' ";
                    }
                }
            }  

            
            $sql = "SELECT ".$periode_format.", 
                    notif_sms_gateway.member_id AS m_ID,
                    COUNT(notif_sms_gateway.ID) AS jum_anggota,
                    COUNT(notif_sms_gateway.collectionloanitem_id) AS jumlah_koleksi, 
                    (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'sukses' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS sukses_send, 
                     (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'gagal' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS gagal_send  
                    FROM notif_sms_gateway 
                    LEFT JOIN members ON members.ID = notif_sms_gateway.member_id 
                    LEFT JOIN collectionloanitems ON collectionloanitems.ID = notif_sms_gateway.member_id 
                    WHERE DATE(notif_sms_gateway.send_date) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(notif_sms_gateway.send_date,'%d-%m-%Y'), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

// $headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;


    $filename = 'Laporan_Periodik_Frekuensi.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="6">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Pengiriman SMS Otomatis '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <td>No.</td>
                <th>Tanggal Pengiriman</th>
                <th>Jumlah Anggota</th>
                <th>Jumlah Koleksi</th>
                <th>Jumlah Pesan Terkirim</th>
                <th>Jumlah Pesan Gagal Terkirim</th>
            </tr>
            ';
        $no = 1;
        $JumlahAnggota = 0;
        $JumlahKoleksi = 0;
        $JumlahSukses = 0;
        $JumlahGagal = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['jum_anggota'].'</td>
                    <td>'.$data['jumlah_koleksi'].'</td>
                    <td>'.$data['sukses_send'].'</td>
                    <td>'.$data['gagal_send'].'</td>
                </tr>
            ';
                        $JumlahAnggota = $JumlahAnggota + $data['jum_anggota'];
                        $JumlahKoleksi = $JumlahKoleksi + $data['jumlah_koleksi'];
                        $JumlahSukses = $JumlahSukses + $data['sukses_send'];
                        $JumlahGagal = $JumlahGagal + $data['gagal_send'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahAnggota.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahKoleksi.'
                        </td
                        <td style="font-weight: bold;">
                            '.$JumlahSukses.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahGagal.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdt()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

// var_dump($periode_format);
// die;

            if (isset($_POST['peminjaman'])) {
            foreach ($_POST['peminjaman'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.LoanDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['topeminjaman'])) {
                foreach ($_POST['topeminjaman'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }

            if (isset($_POST['jatuh_tempo'])) {
            foreach ($_POST['jatuh_tempo'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.DueDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['tojatuh_tempo'])) {
                foreach ($_POST['tojatuh_tempo'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }   
             
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.ID = '".addslashes($value)."' ";
                    }
                }
            }  

            
            $sql = "SELECT ".$periode_format.", 
                    notif_sms_gateway.member_id AS m_ID,
                    COUNT(notif_sms_gateway.ID) AS jum_anggota,
                    COUNT(notif_sms_gateway.collectionloanitem_id) AS jumlah_koleksi, 
                    (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'sukses' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS sukses_send, 
                     (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'gagal' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS gagal_send  
                    FROM notif_sms_gateway 
                    LEFT JOIN members ON members.ID = notif_sms_gateway.member_id 
                    LEFT JOIN collectionloanitems ON collectionloanitems.ID = notif_sms_gateway.member_id 
                    WHERE DATE(notif_sms_gateway.send_date) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(notif_sms_gateway.send_date,'%d-%m-%Y'), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
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



    // Open Office Calc Area
    $menu = 'Pemanfaatan Opac';

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'jum_anggota'=>$model['jum_anggota'], 'jumlah_koleksi'=>$model['jumlah_koleksi'], 'sukses_send'=>$model['sukses_send'], 'gagal_send'=>$model['gagal_send'] );
            $JumlahAnggota = $JumlahAnggota + $model['jum_anggota'];
            $JumlahKoleksi = $JumlahKoleksi + $model['jumlah_koleksi'];
            $JumlahSukses = $JumlahSukses + $model['sukses_send'];
            $JumlahGagal = $JumlahGagal + $model['gagal_send'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'Totaljum_anggota'=>$jum_anggota,
        'Totaljumlah_koleksi'=>$jumlah_koleksi,
        'Totalsukses_send'=>$sukses_send,
        'Totalgagal_send'=>$gagal_send,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sms/laporan-sms-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-OPAC-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWord()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $subjek = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

// var_dump($periode_format);
// die;

            if (isset($_POST['peminjaman'])) {
            foreach ($_POST['peminjaman'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.LoanDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['topeminjaman'])) {
                foreach ($_POST['topeminjaman'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }

            if (isset($_POST['jatuh_tempo'])) {
            foreach ($_POST['jatuh_tempo'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.DueDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['tojatuh_tempo'])) {
                foreach ($_POST['tojatuh_tempo'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }   
             
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.ID = '".addslashes($value)."' ";
                    }
                }
            }  

            
            $sql = "SELECT ".$periode_format.", 
                    notif_sms_gateway.member_id AS m_ID,
                    COUNT(notif_sms_gateway.ID) AS jum_anggota,
                    COUNT(notif_sms_gateway.collectionloanitem_id) AS jumlah_koleksi, 
                    (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'sukses' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS sukses_send, 
                     (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'gagal' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS gagal_send  
                    FROM notif_sms_gateway 
                    LEFT JOIN members ON members.ID = notif_sms_gateway.member_id 
                    LEFT JOIN collectionloanitems ON collectionloanitems.ID = notif_sms_gateway.member_id 
                    WHERE DATE(notif_sms_gateway.send_date) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(notif_sms_gateway.send_date,'%d-%m-%Y'), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

// $headers = Yii::getAlias('@webroot','/teeeesst');
// $headers = Yii::$app->urlManager->createUrl('@app',"../uploaded_files/aplikasi/kop.png");
// print_r($headers);
// die;


    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="6">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Pengiriman SMS Otomatis '.$periode2.'</th>
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
                <th>Tanggal Pengiriman</th>
                <th>Jumlah Anggota</th>
                <th>Jumlah Koleksi</th>
                <th>Jumlah Pesan Terkirim</th>
                <th>Jumlah Pesan Gagal Terkirim</th>
            </tr>
            ';
        $no = 1;
        $JumlahAnggota = 0;
        $JumlahKoleksi = 0;
        $JumlahSukses = 0;
        $JumlahGagal = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['jum_anggota'].'</td>
                    <td>'.$data['jumlah_koleksi'].'</td>
                    <td>'.$data['sukses_send'].'</td>
                    <td>'.$data['gagal_send'].'</td>
                </tr>
            ';
                        $JumlahAnggota = $JumlahAnggota + $data['jum_anggota'];
                        $JumlahKoleksi = $JumlahKoleksi + $data['jumlah_koleksi'];
                        $JumlahSukses = $JumlahSukses + $data['sukses_send'];
                        $JumlahGagal = $JumlahGagal + $data['gagal_send'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahAnggota.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahKoleksi.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahSukses.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahGagal.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}


public function actionExportPdf()
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
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(notif_sms_gateway.send_date,"%Y") Periode';
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


            if (isset($_POST['peminjaman'])) {
            foreach ($_POST['peminjaman'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.LoanDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['topeminjaman'])) {
                foreach ($_POST['topeminjaman'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }

            if (isset($_POST['jatuh_tempo'])) {
            foreach ($_POST['jatuh_tempo'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(collectionloanitems.DueDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            } 
            if (isset($_POST['tojatuh_tempo'])) {
                foreach ($_POST['tojatuh_tempo'] as $key => $value) {
                    if ($value != "0" ) {
                        $andValue .= " AND '".date("Y-m-d", strtotime( $value ) )."' ";
                    }
                }
            }   
             
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.ID = '".addslashes($value)."' ";
                    }
                }
            }  

            
            $sql = "SELECT ".$periode_format.", 
                    notif_sms_gateway.member_id AS m_ID,
                    COUNT(notif_sms_gateway.ID) AS jum_anggota,
                    COUNT(notif_sms_gateway.collectionloanitem_id) AS jumlah_koleksi, 
                    (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'sukses' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS sukses_send, 
                     (SELECT 
                    CASE 
                     WHEN notif_sms_gateway.send_status = 'gagal' THEN COUNT(notif_sms_gateway.send_status)
                     ELSE NULL
                    END 
                     ) AS gagal_send  
                    FROM notif_sms_gateway 
                    LEFT JOIN members ON members.ID = notif_sms_gateway.member_id 
                    LEFT JOIN collectionloanitems ON collectionloanitems.ID = notif_sms_gateway.member_id 
                    WHERE DATE(notif_sms_gateway.send_date) ";        
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(notif_sms_gateway.send_date,'%d-%m-%Y'), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(notif_sms_gateway.send_date), notif_sms_gateway.member_id, notif_sms_gateway.send_status ORDER BY DATE_FORMAT(notif_sms_gateway.send_date,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' (' .implode($_POST[implode($_POST['kriterias'])]). ')';
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
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
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
        $content = $this->renderPartial('pdf-view-laporan-periodik-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

    
// ////////////////////////////////batas get_real_name///////////////////////////////////////////////// //
public function getRealNameKriteria($kriterias)
    {
        if ($kriterias == 'no_anggota') 
        {
            $name = 'Penginput Data';
        } 
        elseif ($kriterias == 'petugas_perpanjangan') 
        {
            $name = 'Petugas Perpanjangan';
        }
        elseif ($kriterias == 'Kelas_dcc') 
        {
            $name = 'Kelas DCC';
        }    
        else 
        {
            $name = ' ';
        }
        
        return $name;

    }
}
