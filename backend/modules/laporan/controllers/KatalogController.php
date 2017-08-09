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
// use common\models\Catalogs;
// use common\models\LocationLibrary;
use common\models\Locations;
// use common\models\Collectionsources;
// use common\models\Partners;
//use common\models\Currency;
use common\models\Users;
// use common\models\Collectionrules;
// use common\models\Worksheets;
// use common\models\Collectionmedias;
use common\models\MasterKelasBesar;
use common\models\VLapKriteriaKatalog;


class KatalogController extends \yii\web\Controller
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
     * [actionKatalogPerkriteria description]
     * @return [type] [description]
     */

public function actionKinerjaUser()
    {

    	$model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('kinerja-user',[
        	'model' => $model,
        	]);
    }

public function actionKatalogPerkriteria()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('katalog-perkriteria',[
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
        // if ($kriteria !== 'currency' && $kriteria !== 'no_klas' && $kriteria !== 'no_panggil' && $kriteria !== 'createdate' && $kriteria !== 'harga' && $kriteria !== '' ) 
        // {
        //     $options = ArrayHelper::map(VLapKriteriaKatalog::find()->where(['kriteria'=>$kriteria])->all(),'id_dtl_kriteria','dtl_kriteria');
        //     $options[0] = " ---Semua---";
        //     asort($options);
        //     $options = array_filter($options);
        //     $contentOptions = Html::dropDownList( $kriteria.'[]',
        //         'selected option',  
        //         $options, 
        //         ['class' => 'select2 col-sm-6',]
        //     );
        // } 
        // else 
        if ($kriteria == 'kataloger')
        {
            $options =  ArrayHelper::map(Users::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['username'];
                });

            //array_push( $options, "---Semua---");
            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
            //var_dump($options2);
        }        
        else if ($kriteria == 'kriteria')
        {

            $options = ['0' => 'Cantuman (katalog) Dibuat','1' => 'Cantuman (katalog) Dimuktahirkan','2' => 'Cantuman (katalog) Dihapus'];
           
            $options2 = \yii\helpers\ArrayHelper::merge([""=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'location')
        {
            $options =  ArrayHelper::map(Locations::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Name'];
                });

            //array_push( $options, "---Semua---");
            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
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
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6']
                ).'</div>';
        }
        else if ($kriteria == 'kelas_ddc')
        {
            $options =  ArrayHelper::map(MasterKelasBesar::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['namakelas'];
                });

            //array_push( $options, "---Semua---");
            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
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
public function actionLoadSelecterKinerjaUser($i)
    {
        return $this->renderPartial('select-kinerja-user',['i'=>$i]);
    }


public function actionShowPdf($tampilkan)
    {
      
        // session_start();
        $_SESSION['Array_POST_Filter'] = $_POST;


        if ($tampilkan == 'katalog-perkriteria-frekuensi') 
        {
            echo (count(array_filter($_POST['kriterias'])) != '' ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-katalog-perkriteria-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        } 

        if ($tampilkan == 'katalog-perkriteria-data') 
        {
            echo (count(array_filter($_POST['kriterias'])) != '' ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-katalog-perkriteria-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        } 
        if ($tampilkan == 'katalog-kinerja-user') 
        {
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'katalog-kinerja-user-data') 
        {
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-data').'">';
            echo "<iframe>";
        }
        

    }


public function actionRenderPdfKatalogPerkriteriaData() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT callnumber AS NoPanggil,
                    BIBID, 
                    author AS Pengarang, 
                    Title AS Judul, 
                    publisher AS Penerbitan, 
                    PhysicalDescription AS Deskripsifisik,
                    PUBLISHYEAR AS PUBLISHYEAR, 
                    SUBJECT AS subjek, 
                    users.username AS UserName,
                    DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y %H:%i%s') AS CreateDate 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= " ORDER BY catalogs.CreateDate";
            }

            if (implode($_POST['kriterias']) == 'no_klas') {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND SUBSTRING(catalogs.DeweyNo,1,1) = '".addslashes($value)."' ";
                }
            }
            $sql = "SELECT DATE_FORMAT(catalogs.CreateDate,'%d-%M-%Y %h:%i:%s') Periode, 
                    namakelas AS NamaKriteria, 
                    ControlNumber AS NoPanggil,
                    BIBID AS BIBID, 
                    title AS Judul,
                    Author AS Pengarang, 
                    ISBN AS ISbn, 
                    PublishLocation, 
                    Publisher AS publisher, 
                    PublishYear 
                    FROM catalogs 
                    LEFT JOIN collections ON collections.Catalog_id = catalogs.ID 
                    LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(catalogs.DeweyNo,1,1) 
                    WHERE DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') 
                    ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= 'ORDER BY DATE_FORMAT(catalogs.CreateDate,"%Y-%m-%d") DESC';
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT DATE_FORMAT(CreateDate,'%d-%m-%Y') AS Periode, 
                        DATE_FORMAT(CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                $sql .= " GROUP BY DATE_FORMAT(CreateDate,'%d-%m-%Y'), DATE_FORMAT(CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id 
                    ORDER BY Periode2 DESC";
                }

            if (implode($_POST['kriterias']) == 'subjek' || implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT ".$periode_format.",
                        catalogs.Subject AS NamaKriteria,
                        ControlNumber AS NoPanggil,
                        BIBID AS BIBID,
                        catalogs.Title AS Judul,
                        Author AS Pengarang,
                        ISBN AS ISbn,
                        PublishLocation,
                        Publisher AS publisher, 
                        PublishYear 
                        FROM catalogs 
                        WHERE catalogs.Subject <> ''  AND DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                $sql .= " ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                }

            // print_r($sql);
            // die;

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan;  
       // $content['isi_berdasarkan'] = $isi_kriteria;
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
            'content' => $this->renderPartial('pdf-view-katalog-perkriteria-data', $content),
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

public function actionExportExcelKatalogPerkriteriaData()
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
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT callnumber AS NoPanggil,
                    BIBID, 
                    author AS Pengarang, 
                    Title AS Judul, 
                    publisher AS Penerbitan, 
                    PhysicalDescription AS Deskripsifisik,
                    PUBLISHYEAR AS PUBLISHYEAR, 
                    SUBJECT AS subjek, 
                    users.username AS UserName,
                    DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y %H:%i%s') AS CreateDate 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= " ORDER BY catalogs.CreateDate";
            }

            if (implode($_POST['kriterias']) == 'no_klas') {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND SUBSTRING(catalogs.DeweyNo,1,1) = '".addslashes($value)."' ";
                }
            }
            $sql = "SELECT DATE_FORMAT(catalogs.CreateDate,'%d-%M-%Y %h:%i:%s') Periode, 
                    namakelas AS NamaKriteria, 
                    ControlNumber AS NoPanggil,
                    BIBID AS BIBID, 
                    title AS Judul,
                    Author AS Pengarang, 
                    ISBN AS ISbn, 
                    PublishLocation, 
                    Publisher AS publisher, 
                    PublishYear 
                    FROM catalogs 
                    LEFT JOIN collections ON collections.Catalog_id = catalogs.ID 
                    LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(catalogs.DeweyNo,1,1) 
                    WHERE DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') 
                    ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= 'ORDER BY DATE_FORMAT(catalogs.CreateDate,"%Y-%m-%d") DESC';
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT DATE_FORMAT(CreateDate,'%d-%m-%Y') AS Periode, 
                        DATE_FORMAT(CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                $sql .= " GROUP BY DATE_FORMAT(CreateDate,'%d-%m-%Y'), DATE_FORMAT(CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id 
                    ORDER BY Periode2 DESC";
                }

            if (implode($_POST['kriterias']) == 'subjek' || implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT ".$periode_format.",
                        catalogs.Subject AS NamaKriteria,
                        ControlNumber AS NoPanggil,
                        BIBID AS BIBID,
                        catalogs.Title AS Judul,
                        Author AS Pengarang,
                        ISBN AS ISbn,
                        PublishLocation,
                        Publisher AS publisher, 
                        PublishYear 
                        FROM catalogs 
                        WHERE catalogs.Subject <> ''  AND DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                $sql .= " ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
            }

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
                <th colspan="11">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="11">Katalog Perkriteria '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="11">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    if (implode($_POST["kriterias"]) == "kataloger"){
    echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Nomer Panggil</th>
                <th>BIB ID</th>
                <th>Pengarang</th>
                <th>Judul</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Deskripsi Fisik</th>
                <th>Subjek</th>
                <th>Username</th>
                <th>Create Date</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>';
                if (implode($_POST["kriterias"]) != "subjek")
                {
                  echo '<td>'.$data['NoPanggil'].'</td>';
                }echo '
                    <td>'.$data['BIBID'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Penerbitan'].'</td>
                    <td>'.$data['Deskripsifisik'].'</td>
                    <td>'.$data['PUBLISHYEAR'].'</td>
                    <td>'.$data['subjek'].'</td>
                    <td>'.$data['UserName'].'</td>
                    <td>'.$data['CreateDate'].'</td>
                </tr>
            ';
        $no++;
        endforeach;        
    echo '</table>';
}elseif (implode($_POST["kriterias"]) == 'subjek' || implode($_POST["kriterias"]) == 'judul' || implode($_POST["kriterias"]) == 'no_klas'){
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>';
                if (implode($_POST["kriterias"]) != "judul")
                {
                  echo '<th>'; if ($kriterias != 'no_klas'){echo "Subjek";}else{echo "Kelas Besar";}'</th>';
                }echo '
                <th>Control Number</th>
                <th>BIB-ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
            </tr>
    ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>';
                    if (implode($_POST["kriterias"]) != "subjek")
                {
                  echo  '<td>'.$data['Judul'].'</td>';
                }echo '
                    <td>'.$data['NoPanggil'].'</td>
                    <td>'.$data['BIBID'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['publisher'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';
} 

}

public function actionExportExcelOdtKatalogPerkriteriaData()
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
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT callnumber AS NoPanggil,
                    BIBID, 
                    author AS Pengarang, 
                    Title AS Judul, 
                    publisher AS Penerbitan, 
                    PhysicalDescription AS Deskripsifisik,
                    PUBLISHYEAR AS PUBLISHYEAR, 
                    SUBJECT AS subjek, 
                    users.username AS UserName,
                    DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y %H:%i%s') AS CreateDate 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= " ORDER BY catalogs.CreateDate";
            }

            if (implode($_POST['kriterias']) == 'no_klas') {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND SUBSTRING(catalogs.DeweyNo,1,1) = '".addslashes($value)."' ";
                }
            }
            $sql = "SELECT DATE_FORMAT(catalogs.CreateDate,'%d-%M-%Y %h:%i:%s') Periode, 
                    namakelas AS NamaKriteria, 
                    ControlNumber AS NoPanggil,
                    BIBID AS BIBID, 
                    title AS Judul,
                    Author AS Pengarang, 
                    ISBN AS ISbn, 
                    PublishLocation, 
                    Publisher AS publisher, 
                    PublishYear 
                    FROM catalogs 
                    LEFT JOIN collections ON collections.Catalog_id = catalogs.ID 
                    LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(catalogs.DeweyNo,1,1) 
                    WHERE DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') 
                    ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= 'ORDER BY DATE_FORMAT(catalogs.CreateDate,"%Y-%m-%d") DESC';
            }

            if (implode($_POST['kriterias']) == 'subjek' || implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT ".$periode_format.",
                        catalogs.Subject AS NamaKriteria,
                        ControlNumber AS NoPanggil,
                        BIBID AS BIBID,
                        catalogs.Title AS Judul,
                        Author AS Pengarang,
                        ISBN AS ISbn,
                        PublishLocation,
                        Publisher AS publisher, 
                        PublishYear 
                        FROM catalogs 
                        WHERE catalogs.Subject <> ''  AND DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                $sql .= " ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
            }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = $inValue;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    if (implode($_POST['kriterias']) == 'no_klas') {$sub = 'Kelas Besar';}else {$sub = 'Subjek';}

    $headers = Yii::getAlias('@webroot','/teeeesst');


    // Open Office Calc Area

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 
            'BIBID'=>$model['BIBID'], 'Penerbitan'=>$model['Penerbitan'], 'Deskripsifisik'=>$model['Deskripsifisik'], 'PUBLISHYEAR'=>$model['PUBLISHYEAR'], 'subjek'=>$model['subjek'], 'UserName'=>$model['UserName'], 'CreateDate'=>$model['CreateDate'],
            'Judul'=>$model['Judul'], 'NoPanggil'=>$model['NoPanggil'], 'Pengarang'=>$model['Pengarang'], 'publisher'=>$model['publisher'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'sub'=>$sub,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    // $template = Yii::getAlias('@uploaded_files').'/templates/laporan/baca_ditempat/laporan-baca_ditempat-sering-baca.ods'; 

    if (implode($_POST['kriterias']) == 'kataloger') {
        $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-perkriteria-kataloger-data.ods'; 
    }else{
        $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-perkriteria-data.ods'; 
    }

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-katalog-perkriteria-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKatalogPerkriteriaData()
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
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT callnumber AS NoPanggil,
                    BIBID, 
                    author AS Pengarang, 
                    Title AS Judul, 
                    publisher AS Penerbitan, 
                    PhysicalDescription AS Deskripsifisik,
                    PUBLISHYEAR AS PUBLISHYEAR, 
                    SUBJECT AS subjek, 
                    users.username AS UserName,
                    DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y %H:%i%s') AS CreateDate 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= " ORDER BY catalogs.CreateDate";
            }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND SUBSTRING(catalogs.DeweyNo,1,1) = '".addslashes($value)."' ";
                }
            }
            $sql = "SELECT DATE_FORMAT(catalogs.CreateDate,'%d-%M-%Y %h:%i:%s') Periode, 
                    namakelas AS NamaKriteria, 
                    ControlNumber AS NoPanggil,
                    BIBID AS BIBID, 
                    title AS Judul,
                    Author AS Pengarang, 
                    ISBN AS ISbn, 
                    PublishLocation, 
                    Publisher AS publisher, 
                    PublishYear 
                    FROM catalogs 
                    LEFT JOIN collections ON collections.Catalog_id = catalogs.ID 
                    LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(catalogs.DeweyNo,1,1) 
                    WHERE DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') 
                    ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= 'ORDER BY DATE_FORMAT(catalogs.CreateDate,"%Y-%m-%d") DESC';
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT DATE_FORMAT(CreateDate,'%d-%m-%Y') AS Periode, 
                        DATE_FORMAT(CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                $sql .= " GROUP BY DATE_FORMAT(CreateDate,'%d-%m-%Y'), DATE_FORMAT(CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id 
                    ORDER BY Periode2 DESC";
                }

            if (implode($_POST['kriterias']) == 'subjek' || implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT ".$periode_format.",
                        catalogs.Subject AS NamaKriteria,
                        ControlNumber AS NoPanggil,
                        BIBID AS BIBID,
                        catalogs.Title AS Judul,
                        Author AS Pengarang,
                        ISBN AS ISbn,
                        PublishLocation,
                        Publisher AS publisher, 
                        PublishYear 
                        FROM catalogs 
                        WHERE catalogs.Subject <> ''  AND DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    }
                }

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
                <th colspan="11">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="11">Katalog Perkriteria '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="11">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    if (implode($_POST["kriterias"]) == "kataloger"){
    echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Nomer Panggil</th>
                <th>BIB ID</th>
                <th>Pengarang</th>
                <th>Judul</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Deskripsi Fisik</th>
                <th>Subjek</th>
                <th>Username</th>
                <th>Create Date</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>';
                if (implode($_POST["kriterias"]) != "subjek")
                {
                  echo '<td>'.$data['NoPanggil'].'</td>';
                }echo '
                    <td>'.$data['BIBID'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Penerbitan'].'</td>
                    <td>'.$data['Deskripsifisik'].'</td>
                    <td>'.$data['PUBLISHYEAR'].'</td>
                    <td>'.$data['subjek'].'</td>
                    <td>'.$data['UserName'].'</td>
                    <td>'.$data['CreateDate'].'</td>
                </tr>
            ';
        $no++;
        endforeach;        
    echo '</table>';
}elseif (implode($_POST["kriterias"]) == 'subjek' || implode($_POST["kriterias"]) == 'judul' || implode($_POST["kriterias"]) == 'no_klas'){
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>';
                if (implode($_POST["kriterias"]) != "judul")
                {
                  echo '<th>'; if (implode($_POST["kriterias"]) != 'no_klas'){echo "Subjek";}else{echo "Kelas Besar";}'</th>';
                }echo '
                <th>Control Number</th>
                <th>BIB-ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
            </tr>
    ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>';
                    if (implode($_POST["kriterias"]) != "judul")
                {
                  echo  '<td>'.$data['Judul'].'</td>';
                }echo '
                    <td>'.$data['NoPanggil'].'</td>
                    <td>'.$data['BIBID'].'</td>
                    <td>'.$data['Judul'].'</td>
                    <td>'.$data['Pengarang'].'</td>
                    <td>'.$data['publisher'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';
} 

}

public function actionExportPdfKatalogPerkriteriaData()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT callnumber AS NoPanggil,
                    BIBID, 
                    author AS Pengarang, 
                    Title AS Judul, 
                    publisher AS Penerbitan, 
                    PhysicalDescription AS Deskripsifisik,
                    PUBLISHYEAR AS PUBLISHYEAR, 
                    SUBJECT AS subjek, 
                    users.username AS UserName,
                    DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y %H:%i%s') AS CreateDate 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= " ORDER BY catalogs.CreateDate";
            }

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND SUBSTRING(catalogs.DeweyNo,1,1) = '".addslashes($value)."' ";
                }
            }
            $sql = "SELECT DATE_FORMAT(catalogs.CreateDate,'%d-%M-%Y %h:%i:%s') Periode, 
                    namakelas AS NamaKriteria, 
                    ControlNumber AS NoPanggil,
                    BIBID AS BIBID, 
                    title AS Judul,
                    Author AS Pengarang, 
                    ISBN AS ISbn, 
                    PublishLocation, 
                    Publisher AS publisher, 
                    PublishYear 
                    FROM catalogs 
                    LEFT JOIN collections ON collections.Catalog_id = catalogs.ID 
                    LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(catalogs.DeweyNo,1,1) 
                    WHERE DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') 
                    ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= 'ORDER BY DATE_FORMAT(catalogs.CreateDate,"%Y-%m-%d") DESC';
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT DATE_FORMAT(CreateDate,'%d-%m-%Y') AS Periode, 
                        DATE_FORMAT(CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                $sql .= " GROUP BY DATE_FORMAT(CreateDate,'%d-%m-%Y'), DATE_FORMAT(CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id 
                    ORDER BY Periode2 DESC";
                }

            if (implode($_POST['kriterias']) == 'subjek' || implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT ".$periode_format.",
                        catalogs.Subject AS NamaKriteria,
                        ControlNumber AS NoPanggil,
                        BIBID AS BIBID,
                        catalogs.Title AS Judul,
                        Author AS Pengarang,
                        ISBN AS ISbn,
                        PublishLocation,
                        Publisher AS publisher, 
                        PublishYear 
                        FROM catalogs 
                        WHERE catalogs.Subject <> ''  AND DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    }
                }
            // print_r($sql);
            // die;

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan;  
       // $content['isi_berdasarkan'] = $isi_kriteria;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-katalog-perkriteria-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderKinerjaUserData() 
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT DATE_FORMAT(modelhistory.date,'%d-%M-%Y <br /> %h:%i:%s') Periode,
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Entri' 
                 WHEN modelhistory.type = '1' THEN 'Edit' 
                 ELSE 'Hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['a'] = $a; 
        $content['dan'] = $dan;
        $content['DetailFilter'] = $DetailFilter;
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" />'];
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
            'content' => $this->renderPartial('pdf-view-katalog-kinerja-user-data', $content),
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT DATE_FORMAT(modelhistory.date,'%d-%M-%Y <br /> %h:%i:%s') Periode,
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Entri' 
                 WHEN modelhistory.type = '1' THEN 'Edit' 
                 ELSE 'Hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;
    
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 

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
                <th>Periode</th>
                <th>Kataloger</th>
                <th>Kriteria</th>
                <th>History</th>
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT DATE_FORMAT(modelhistory.date,'%d-%M-%Y %h:%i:%s') Periode,
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Entri' 
                 WHEN modelhistory.type = '1' THEN 'Edit' 
                 ELSE 'Hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': ', 'Katalog' )
                END
                ) AS actions,
                catalogs.Title as title
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}


    $DetailFilterKriteria = $DetailFilter['kriteria'];
    $DetailFilterKataloger = $DetailFilter['kataloger'];

    $headers = Yii::getAlias('@webroot','/teeeesst');


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
        'DetailFilterKriteria'=>$DetailFilterKriteria,
        'DetailFilterKataloger'=>$DetailFilterKataloger,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-kinerja-user-data.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-katalog-data.ods');
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT DATE_FORMAT(modelhistory.date,'%d-%M-%Y <br /> %h:%i:%s') Periode,
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Entri' 
                 WHEN modelhistory.type = '1' THEN 'Edit' 
                 ELSE 'Hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;
    
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 

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
                <th>Kataloger</th>
                <th>Kriteria</th>
                <th>History</th>
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT DATE_FORMAT(modelhistory.date,'%d-%M-%Y <br /> %h:%i:%s') Periode,
                users.UserName AS Kataloger, 
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'Entri' 
                 WHEN modelhistory.type = '1' THEN 'Edit' 
                 ELSE 'Hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'Mengentri' WHEN modelhistory.type = '1' THEN 'Mengedit' ELSE 'Menghapus' END, ': ', 'Katalog' ,'<br />', catalogs.Title )
                END
                ) AS actions
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['a'] = $a; 
        $content['dan'] = $dan;
        $content['DetailFilter'] = $DetailFilter;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" />'];
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
        $content = $this->renderPartial('pdf-view-katalog-kinerja-user-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


// /////////////////////////////////batas view_data dgn view_vrekuensi//////////////////////////////////// //     


public function actionRenderPdfKatalogPerkriteriaFrekuensi() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%d-%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 ='periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT ".$periode_kataloger.",
                    users.username AS Kataloger,
                    COUNT(Title) AS Jumlah 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate),users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                }      
            }

            if (isset($_POST['location'])) {
            foreach ($_POST['location'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Location_id = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT locations.Name AS Kataloger,
                    COUNT(collections.ID) AS Jumlah,
                    ".$periode_location."
                    FROM collections 
                    JOIN catalogs ON collections.Catalog_id=catalogs.ID 
                    JOIN locations ON collections.Location_id=locations.ID 
                    WHERE collections.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.CreateDate,'%d-%m-%Y'), DATE_FORMAT(collections.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                }   
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT ".$periode_bahan_pustaka.",
                        DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        LEFT JOIN worksheets ON worksheets.ID = catalogs.Worksheet_id
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } 
                }

             if (isset($_POST['no_klas'])) {
                foreach ($_POST['no_klas'] as $key => $value) {
                    if ($value != "" ) {
                        $andValue .= " AND SUBSTRING(cat.DeweyNo,1,1) =  '".addslashes($value)."' ";
                    }
                }

                $sql = "SELECT
                        ".$periode_no_klass.",
                        master_kelas_besar.namakelas AS kelas,
                        COUNT(cat.Title) AS CountJudul,
                        COUNT(collections.Catalog_id) AS Jumlah
                        FROM catalogs cat 
                        LEFT JOIN collections ON collections.Catalog_id = cat.ID
                        LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(cat.DeweyNo,1,1) 
                        WHERE DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";
                $sql .= $sqlPeriode;
                $sql.= $andValue;
                if ($_POST['periode'] == "harian"){ 
                      $sql.= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";    
                } elseif ($_POST['periode'] == "bulanan") {
                      $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%M-%Y') ";
                } else{
                       $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y') ";
                }
            }

            // print_r($a);
            // die;


            if (implode($_POST['kriterias']) == 'subjek') {
                $sql = "SELECT catalogs.Subject AS Kataloger, 
                        COUNT(catalogs.Subject) AS Jumlah,
                        ".$periode_subjek."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

            if (implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT catalogs.Title AS Kataloger, 
                        COUNT(catalogs.Title) AS Jumlah,
                        ".$periode_judul."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan;  
       // $content['isi_berdasarkan'] = $isi_kriteria;
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
            'content' => $this->renderPartial('pdf-view-katalog-perkriteria-frekuensi', $content),
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

public function actionExportExcelKatalogPerkriteriaFrekuensi()
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
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%d-%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 ='periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT ".$periode_kataloger.",
                    users.username AS Kataloger,
                    COUNT(Title) AS Jumlah 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate),users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                }      
            }

            if (isset($_POST['location'])) {
            foreach ($_POST['location'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Location_id = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT locations.Name AS Kataloger,
                    COUNT(collections.ID) AS Jumlah,
                    ".$periode_location."
                    FROM collections 
                    JOIN catalogs ON collections.Catalog_id=catalogs.ID 
                    JOIN locations ON collections.Location_id=locations.ID 
                    WHERE collections.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.CreateDate,'%d-%m-%Y'), DATE_FORMAT(collections.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                }   
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT ".$periode_bahan_pustaka.",
                        DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        LEFT JOIN worksheets ON worksheets.ID = catalogs.Worksheet_id
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } 
                }

             if (isset($_POST['no_klas'])) {
                foreach ($_POST['no_klas'] as $key => $value) {
                    if ($value != "" ) {
                        $andValue .= " AND SUBSTRING(cat.DeweyNo,1,1) =  '".addslashes($value)."' ";
                    }
                }

                $sql = "SELECT
                        ".$periode_no_klass.",
                        master_kelas_besar.namakelas AS kelas,
                        COUNT(cat.Title) AS CountJudul,
                        COUNT(collections.Catalog_id) AS Jumlah
                        FROM catalogs cat 
                        LEFT JOIN collections ON collections.Catalog_id = cat.ID
                        LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(cat.DeweyNo,1,1) 
                        WHERE DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";
                $sql .= $sqlPeriode;
                $sql.= $andValue;
                if ($_POST['periode'] == "harian"){ 
                      $sql.= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";    
                } elseif ($_POST['periode'] == "bulanan") {
                      $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%M-%Y') ";
                } else{
                       $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y') ";
                }
            }

            // print_r($a);
            // die;


            if (implode($_POST['kriterias']) == 'subjek') {
                $sql = "SELECT catalogs.Subject AS Kataloger, 
                        COUNT(catalogs.Subject) AS Jumlah,
                        ".$periode_subjek."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

            if (implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT catalogs.Title AS Kataloger, 
                        COUNT(catalogs.Title) AS Jumlah,
                        ".$periode_judul."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
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
                <th colspan="4">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="4">Katalog Perkriteria '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="4">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            ';
if (implode($_POST["kriterias"]) == "bahan_pustaka"){
    echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Bahan Pustaka</th>
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
                    <td>'.$data['BahanPustaka'].'</td>
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
}elseif (implode($_POST["kriterias"]) == "kataloger"){
echo '<table border="1" align="center">';
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
} elseif ($_POST['kriterias'] == 'no_klas'){
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Kelas Besar</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['CountEksemplar'].'</td>
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
} elseif (($_POST['kriterias'] == 'subjek') || ($_POST['kriterias'] == 'judul') || ($_POST['kriterias'] == 'location')) {
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>'.$Berdasarkan.'</th>
                <th>Frekuensi</th>
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

}

public function actionExportExcelOdtKatalogPerkriteriaFrekuensi()
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
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%d-%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 ='periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT ".$periode_kataloger.",
                    users.username AS Kataloger,
                    COUNT(Title) AS Jumlah 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate),users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                }      
            }

            if (isset($_POST['location'])) {
            foreach ($_POST['location'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Location_id = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT locations.Name AS Kataloger,
                    COUNT(collections.ID) AS Jumlah,
                    ".$periode_location."
                    FROM collections 
                    JOIN catalogs ON collections.Catalog_id=catalogs.ID 
                    JOIN locations ON collections.Location_id=locations.ID 
                    WHERE collections.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.CreateDate,'%d-%m-%Y'), DATE_FORMAT(collections.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                }   
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS Kataloger, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT ".$periode_bahan_pustaka.",
                        DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        LEFT JOIN worksheets ON worksheets.ID = catalogs.Worksheet_id
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } 
                }

             if (isset($_POST['no_klas'])) {
                foreach ($_POST['no_klas'] as $key => $value) {
                    if ($value != "" ) {
                        $andValue .= " AND SUBSTRING(cat.DeweyNo,1,1) =  '".addslashes($value)."' ";
                    }
                }

                $sql = "SELECT
                        ".$periode_no_klass.",
                        master_kelas_besar.namakelas AS kelas,
                        COUNT(cat.Title) AS CountJudul,
                        COUNT(collections.Catalog_id) AS Jumlah
                        FROM catalogs cat 
                        LEFT JOIN collections ON collections.Catalog_id = cat.ID
                        LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(cat.DeweyNo,1,1) 
                        WHERE DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";
                $sql .= $sqlPeriode;
                $sql.= $andValue;
                if ($_POST['periode'] == "harian"){ 
                      $sql.= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";    
                } elseif ($_POST['periode'] == "bulanan") {
                      $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%M-%Y') ";
                } else{
                       $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y') ";
                }
            }

            // print_r($a);
            // die;


            if (implode($_POST['kriterias']) == 'subjek') {
                $sql = "SELECT catalogs.Subject AS Kataloger, 
                        COUNT(catalogs.Subject) AS Jumlah,
                        ".$periode_subjek."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

            if (implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT catalogs.Title AS Kataloger, 
                        COUNT(catalogs.Title) AS Jumlah,
                        ".$periode_judul."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = $inValue;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $headers = Yii::getAlias('@webroot','/teeeesst');


    // Open Office Calc Area

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'CountJudul'=>$model['CountJudul'], 'Kataloger'=>$model['Kataloger'], 'Jumlah'=>$model['Jumlah'], 'kelas'=>$model['kelas'] );
        $JumlahCountJudul = $JumlahCountJudul + $model['CountJudul'];
        $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlahCountJudul'=>$JumlahCountJudul,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    // $template = Yii::getAlias('@uploaded_files').'/templates/laporan/baca_ditempat/laporan-baca_ditempat-sering-baca.ods'; 

    if (implode($_POST['kriterias']) == 'no_klas') {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-perkriteria-kelasDCC.ods'; 
    }else{
        $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-perkriteria.ods'; 
    }

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-katalog-perkriteria-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKatalogPerkriteriaFrekuensi()
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
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%d-%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 ='periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT ".$periode_kataloger.",
                    users.username AS Kataloger,
                    COUNT(Title) AS Jumlah 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate),users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                }      
            }

            if (isset($_POST['location'])) {
            foreach ($_POST['location'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Location_id = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT locations.Name AS Kataloger,
                    COUNT(collections.ID) AS Jumlah,
                    ".$periode_location."
                    FROM collections 
                    JOIN catalogs ON collections.Catalog_id=catalogs.ID 
                    JOIN locations ON collections.Location_id=locations.ID 
                    WHERE collections.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.CreateDate,'%d-%m-%Y'), DATE_FORMAT(collections.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                }   
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT ".$periode_bahan_pustaka.",
                        DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        LEFT JOIN worksheets ON worksheets.ID = catalogs.Worksheet_id
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } 
                }

             if (isset($_POST['no_klas'])) {
                foreach ($_POST['no_klas'] as $key => $value) {
                    if ($value != "" ) {
                        $andValue .= " AND SUBSTRING(cat.DeweyNo,1,1) =  '".addslashes($value)."' ";
                    }
                }

                $sql = "SELECT
                        ".$periode_no_klass.",
                        master_kelas_besar.namakelas AS kelas,
                        COUNT(cat.Title) AS CountJudul,
                        COUNT(collections.Catalog_id) AS Jumlah
                        FROM catalogs cat 
                        LEFT JOIN collections ON collections.Catalog_id = cat.ID
                        LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(cat.DeweyNo,1,1) 
                        WHERE DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";
                $sql .= $sqlPeriode;
                $sql.= $andValue;
                if ($_POST['periode'] == "harian"){ 
                      $sql.= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";    
                } elseif ($_POST['periode'] == "bulanan") {
                      $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%M-%Y') ";
                } else{
                       $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y') ";
                }
            }

            // print_r($a);
            // die;


            if (implode($_POST['kriterias']) == 'subjek') {
                $sql = "SELECT catalogs.Subject AS Kataloger, 
                        COUNT(catalogs.Subject) AS Jumlah,
                        ".$periode_subjek."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

            if (implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT catalogs.Title AS Kataloger, 
                        COUNT(catalogs.Title) AS Jumlah,
                        ".$periode_judul."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
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
                <th colspan="4">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="4">Katalog Perkriteria '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="4">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            ';
if (implode($_POST["kriterias"]) == "bahan_pustaka"){
    echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Bahan Pustaka</th>
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
                    <td>'.$data['BahanPustaka'].'</td>
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
}elseif (implode($_POST["kriterias"]) == "kataloger"){
echo '<table border="1" align="center">';
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
} elseif ($_POST['kriterias'] == 'no_klas'){
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Kelas Besasr</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $Jumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['CountEksemplar'].'</td>
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
} else {
echo '<table border="1" align="center">';
    echo '
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>'.$Berdasarkan.'</th>
                <th>Frekuensi</th>
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

}
public function actionExportPdfKatalogPerkriteriaFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%d-%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%d-%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%M-%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%M-%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_kataloger = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_location = 'DATE_FORMAT(collections.CreateDate,"%Y") Periode';
                $periode_bahan_pustaka = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_subjek = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_judul = 'DATE_FORMAT(catalogs.CreateDate,"%Y") Periode';
                $periode_no_klass = 'DATE_FORMAT(cat.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 ='periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                    $andValue .= ' AND users.ID = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT ".$periode_kataloger.",
                    users.username AS Kataloger,
                    COUNT(Title) AS Jumlah 
                    FROM catalogs 
                    INNER JOIN users ON catalogs.CreateBy = users.ID 
                    WHERE catalogs.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate),users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), users.username ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC,catalogs.CreateBy";
                }      
            }

            if (isset($_POST['location'])) {
            foreach ($_POST['location'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collections.Location_id = "'.addslashes($value).'" ';
                }
            }
            $sql = "SELECT locations.Name AS Kataloger,
                    COUNT(collections.ID) AS Jumlah,
                    ".$periode_location."
                    FROM collections 
                    JOIN catalogs ON collections.Catalog_id=catalogs.ID 
                    JOIN locations ON collections.Location_id=locations.ID 
                    WHERE collections.CreateDate ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collections.CreateDate,'%d-%m-%Y'), DATE_FORMAT(collections.CreateDate,'%Y-%m-%d'),catalogs.CreateBy ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collections.CreateDate),locations.Name ORDER BY DATE_FORMAT(collections.CreateDate,'%Y-%m-%d') DESC";
                }   
            }

            if (implode($_POST['kriterias']) == 'bahan_pustaka') {
                $sql = "SELECT a.Periode AS Periode,
                        a.Periode2 AS Tahun2, 
                        w.name AS BahanPustaka, 
                        a.jumlah AS Jumlah 
                        FROM 
                        (
                        SELECT ".$periode_bahan_pustaka.",
                        DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') Periode2,
                        worksheet_id,
                        COUNT(worksheet_id) jumlah 
                        FROM catalogs 
                        LEFT JOIN worksheets ON worksheets.ID = catalogs.Worksheet_id
                        WHERE catalogs.CreateDate ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'), DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d'), worksheet_id 
                    ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC, DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y'),worksheet_id) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), worksheets.Name ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC) a 
                    INNER JOIN worksheets w ON a. worksheet_id = w.id";
                } 
                }

             if (isset($_POST['no_klas'])) {
                foreach ($_POST['no_klas'] as $key => $value) {
                    if ($value != "" ) {
                        $andValue .= " AND SUBSTRING(cat.DeweyNo,1,1) =  '".addslashes($value)."' ";
                    }
                }

                $sql = "SELECT
                        ".$periode_no_klass.",
                        master_kelas_besar.namakelas AS kelas,
                        COUNT(cat.Title) AS CountJudul,
                        COUNT(collections.Catalog_id) AS Jumlah
                        FROM catalogs cat 
                        LEFT JOIN collections ON collections.Catalog_id = cat.ID
                        LEFT JOIN master_kelas_besar ON SUBSTRING(master_kelas_besar.kdKelas,1,1) = SUBSTRING(cat.DeweyNo,1,1) 
                        WHERE DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";
                $sql .= $sqlPeriode;
                $sql.= $andValue;
                if ($_POST['periode'] == "harian"){ 
                      $sql.= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y-%m-%d') ";    
                } elseif ($_POST['periode'] == "bulanan") {
                      $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%M-%Y') ";
                } else{
                       $sql .= "GROUP BY DATE_FORMAT(cat.CreateDate,'%Y') ";
                }
            }

            // print_r($a);
            // die;


            if (implode($_POST['kriterias']) == 'subjek') {
                $sql = "SELECT catalogs.Subject AS Kataloger, 
                        COUNT(catalogs.Subject) AS Jumlah,
                        ".$periode_subjek."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Subject ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

            if (implode($_POST['kriterias']) == 'judul') {
                $sql = "SELECT catalogs.Title AS Kataloger, 
                        COUNT(catalogs.Title) AS Jumlah,
                        ".$periode_judul."
                        FROM catalogs 
                        WHERE DATE(catalogs.CreateDate) ";      
                $sql .= $sqlPeriode;
                if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(catalogs.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                    } else {
                    $sql .= " GROUP BY YEAR(catalogs.CreateDate), catalogs.Title ORDER BY DATE_FORMAT(catalogs.CreateDate,'%Y-%m-%d') DESC";
                } 
                }

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value);
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan;  
       // $content['isi_berdasarkan'] = $isi_kriteria;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-katalog-perkriteria-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');
    }

public function actionRenderKinerjaUserFrekuensi() 
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                    users.UserName AS Kataloger,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    INNER JOIN users ON modelhistory.user_id = users.ID 
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['a'] = $a; 
        $content['dan'] = $dan;
        $content['DetailFilter'] = $DetailFilter;
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" />'];
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
            'content' => $this->renderPartial('pdf-view-katalog-kinerja-user-frekuensi', $content),
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

public function actionExportExcelKinerjaUserFrekuensi()
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                    users.UserName AS Kataloger,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    INNER JOIN users ON modelhistory.user_id = users.ID 
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;
    
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';} 

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
                <th colspan="4">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="4">Kinerja User Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="4">'.$a.' '.$DetailFilter['kataloger'].' '.$dan.' '.$DetailFilter['kriteria'].'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Kataloger</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $TotalJumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
                        $TotalJumlah = $TotalJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalJumlah.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtKinerjaUserFrekuensi()
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                    users.UserName AS Kataloger,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    INNER JOIN users ON modelhistory.user_id = users.ID 
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}


    $DetailFilterKriteria = $DetailFilter['kriteria'];
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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/katalog/laporan-katalog-kinerja-user.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-katalog-kinerja-user-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserFrekuensi()
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

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria di buat) ';
                break;

            case '1':
                $DetailFilter['kriteria'] = ' (Kriteria di mutakhirkan) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria di hapus) ';
                break;
            
            default:
                $DetailFilter['kriteria'] = null;
                break;
            }


           $sql = "SELECT ".$periode_format.",
                    users.UserName AS Kataloger,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    INNER JOIN users ON modelhistory.user_id = users.ID 
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $periode2 = $periode2;
    $format_hari = $periode;
    // $Berdasarkan = array();
    //     foreach ($_POST['kriterias'] as $key => $value) {
    //         $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
    //     }
    //     $Berdasarkan = implode(' dan ', $Berdasarkan);

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
               <p align="center"> <b>Laporan Frekuensi '.$format_hari.' </b></p>
               <p align="center"> <b>Kinerja User Pengembalian '.$periode2.' </b></p>
               <p align="center"> <b>'.$a.' '.$DetailFilter['kataloger'].' '.$dan.' '.$DetailFilter['kriteria'].'</b></p>
            ';
    echo '</table>';

    if ($type == 'odt') {
    echo '<table border="0" align="center" width="700"> ';
    }else{echo '<table border="1" align="center" width="700"> ';}
        echo '
            <tr style="margin-right: 50px; margin-left: 50px;">
                <th>No.</th>
                <th>Periode</th>
                <th>Kataloger</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $TotalJumlah = 0;
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
                        $TotalJumlah = $TotalJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalJumlah.'
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
                    $isi_kriteria = Users::findOne(['ID' => $value]); 
                    $isi_kriteria = ", Kataloger ".$isi_kriteria->username /*.$isi_kriteria->Fullname .$isi_kriteria->ID*/; 
                    }else{
                        $isi_kriteria = '';
                    }
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                if ($value != "" ) {
                    $andValue .= " AND modelhistory.type = '".$value."' ";
                    }
                }
            } 


           $sql = "SELECT ".$periode_format.",
                    users.UserName AS Kataloger,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    INNER JOIN users ON modelhistory.user_id = users.ID 
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'catalogs'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['isi_berdasarkan'] = $isi_kriteria;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" />'];
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
        $content = $this->renderPartial('pdf-view-katalog-kinerja-user-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function getRealNameKriteria($kriterias)
    {
        if ($kriterias == 'kataloger') 
        {
            $name = 'Kataloger';
        } 
        elseif ($kriterias == 'kriteria') 
        {
            $name = 'Kriteria';
        }
        elseif ($kriterias ==    'PublishYear') 
        {
            $name = 'Tahun Terbit';
        }
        elseif ($kriterias == 'bahan_pustaka') 
        {
            $name = 'Bahan Pustaka';
        }
        elseif ($kriterias == 'location') 
        {
            $name = 'Lokasi';
        }
        elseif ($kriterias == 'judul') 
        {
            $name = 'Judul';
        }
        elseif ($kriterias == 'location_library') 
        {
            $name = 'Lokasi Perpustakaan';
        }
        elseif ($kriterias == 'locations') 
        {
            $name = 'Lokasi';
        }
        elseif ($kriterias == 'subjek') 
        {
            $name = 'Subjek';
        }
        elseif ($kriterias == 'no_klas') 
        {
            $name = 'Kelas DDC';
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
        elseif ($kriterias == 'collectionrules') 
        {
            $name = 'Jenis Akses';
        }
        elseif ($kriterias == 'worksheets') 
        {
            $name = 'Jenis Bahan';
        }
        else 
        {
            $name = ' ';
        }
        
        return $name;

    }
}
