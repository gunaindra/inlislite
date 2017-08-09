<?php

namespace backend\modules\laporan\controllers;


use Yii;
use yii\helpers\Url;
//Widget
use kartik\widgets\Select2;
use kartik\mpdf\Pdf;
use kartik\date\DatePicker;

//Helpers
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

//Models
// use common\models\Catalogs;
// use common\models\Locations;
// use common\models\Collectionsources;

// perpanjangan
use common\models\Members;
use common\models\MemberPerpanjangan;
use common\models\Users;

// anggota
use common\models\JenisKelamin;
use common\models\Departments;
use common\models\Propinsi;
use common\models\LocationLibrary;
use common\models\VLapKriteriaAnggota;
// use common\models\VLapKriteriaAnggota2;
use common\models\Collectioncategorys;
use common\models\MasterJenisIdentitas;
use common\models\MasterRangeUmur;
use common\models\Kabupaten;

class AnggotaController extends \yii\web\Controller
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
    public function actionPerpendaftaran()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('perpendaftaran',[
            'model' => $model,
            ]);
    }

    public function actionPerpanjangan()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('perpanjangan',[
            'model' => $model,
            ]);
    }

    public function actionSumbangan()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('sumbangan',[
            'model' => $model,
            ]);
    }

    public function actionBebasPustaka()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('bebas-pustaka',[
            'model' => $model,
            ]);
    }
    public function actionKinerjaUser()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('kinerja-user',[
            'model' => $model,
            ]);
    }

    public function actionLoadFilterKriteria($kriteria)
    {
        if ($kriteria !== 'range_umur' && $kriteria !== 'jenis_kelamin' && $kriteria !== 'propinsi' && $kriteria !== 'propinsi2' && $kriteria !== 'lokasi_pinjam' && $kriteria !== 'kategori_koleksi' && $kriteria !== 'jenis_identitas' && $kriteria !=='kabupaten' && $kriteria !=='kabupaten2' && $kriteria !=='data_entry' && $kriteria !== 'lokasi-pinjam' && $kriteria !== 'nama_institusi'
            && $kriteria !== 'unit_kerja' && $kriteria !== ''
            && $kriteria !== 'no_anggota' && $kriteria !== 'petugas_perpanjangan' && $kriteria !== 'kataloger' && $kriteria !== 'kriteria'
            ) 
        {
            $sql = 'SELECT * FROM v_lap_kriteria_anggota WHERE kriteria = "'.$kriteria.'"';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'id_dtl_anggota','dtl_anggota');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
            );
        } 
        else if ($kriteria == 'jenis_kelamin')
        {
            $options =  ArrayHelper::map(JenisKelamin::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Name'];
                });
            array_unshift( $options,"---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'unit_kerja')
        {
            $options =  ArrayHelper::map(Departments::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Name'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'propinsi')
        {
            $options =  ArrayHelper::map(Propinsi::find()->orderBy('NamaPropinsi')->asArray()->all(),'NamaPropinsi',
                function($model) {
                    return $model['NamaPropinsi'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'propinsi2')
        {
            $options =  ArrayHelper::map(Propinsi::find()->orderBy('NamaPropinsi')->asArray()->all(),'NamaPropinsi',
                function($model) {
                    return $model['NamaPropinsi'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'lokasi_pinjam')
        {
            $options =  ArrayHelper::map(LocationLibrary::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Name'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'kategori_koleksi')
        {
            $options =  ArrayHelper::map(Collectioncategorys::find()->orderBy('ID')->asArray()->all(),'Name',
                function($model) {
                    return $model['Name'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'jenis_identitas')
        {
            $options =  ArrayHelper::map(MasterJenisIdentitas::find()->orderBy('id')->asArray()->all(),'id',
                function($model) {
                    return $model['Nama'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'kabupaten')
        {
            $options =  ArrayHelper::map(Kabupaten::find()->orderBy('ID')->asArray()->all(),'NamaKab',
                function($model) {
                    return $model['NamaKab'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'kabupaten2')
        {

            $sql = 'SELECT * FROM kabupaten';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','NamaKab');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'nama_institusi')
        {
            $sql = 'SELECT * FROM members';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','InstitutionName');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        // else if ($kriteria == 'nama_institusi')
        // {
        //     $options =  ArrayHelper::map(Members::find()->orderBy('ID')->asArray()->all(),'InstitutionName',
        //         function($model) {
        //             return $model['InstitutionName'];
        //         });
        //     array_unshift( $options, "---Semua---");

        //     $contentOptions = Html::dropDownList( $kriteria.'[]',
        //         'selected option',  
        //         $options, 
        //         ['class' => 'select2 col-sm-6',]
        //         );
        // }
        else if ($kriteria == 'range_umur')
        {
            $options =  ArrayHelper::map(MasterRangeUmur::find()->orderBy('id')->asArray()->all(),'id','Keterangan');
            $options = array_filter($options);

            array_unshift( $options, "---Semua Range---");

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

        // <anggota-perpanjangan>
        else if ($kriteria == 'petugas_perpanjangan')
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
        else if ($kriteria == 'no_anggota')
        {

            
            $sql = 'SELECT * FROM members';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['MemberNo'].' - '.$model['Fullname'];
                });
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );

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
        else
        {
            $contentOptions = null;
        }
        return $contentOptions;
        
    }

   
    //   [actionLoadSelecterKriteria description]
    //   @param  [type] $i [description]
    //   @return [type]    [description]
     
    public function actionLoadSelecterKriteria($i)
    {
        return $this->renderPartial('select-kriteria',['i'=>$i]);
    }
     public function actionLoadSelecterPerpanjangan($i)
    {
        return $this->renderPartial('select-perpanjangan',['i'=>$i]);
    }
     public function actionLoadSelecterSumbangan($i)
    {
        return $this->renderPartial('select-sumbangan',['i'=>$i]);
    }
    public function actionLoadSelecterBebasPustaka($i)
    {
        return $this->renderPartial('select-bebas-pustaka',['i'=>$i]);
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
        // var_dump($_POST);
        // echo "</pre>";

        // print_r(count(array_filter($_POST['kriterias'])));
        // print_r(isset($_POST['kota_terbit']));
        // echo 'Okeee'.$_POST['periode'];
        if ($tampilkan == 'perpendaftaran-frekuensi')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-perpendaftaran-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );
        }
        elseif ($tampilkan == 'perpendaftaran-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-perpendaftaran-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }
        elseif ($tampilkan == 'perpanjangan-frekuensi')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-perpanjangan-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            ); 
        }
        elseif ($tampilkan == 'perpanjangan-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-perpanjangan-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>" 
            ); 
        }
        elseif ($tampilkan == 'angg-sumbangan-frekuensi')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-angg-sumbangan-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>" 
            ); 
        }
        elseif ($tampilkan == 'sumbangan-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-sumbangan-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>" 
            ); 
        }
        elseif ($tampilkan == 'bebas-pustaka')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-bebas-pustaka').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>" 
            ); 
        }
        elseif ($tampilkan == 'bebas-pustaka-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-bebas-pustaka-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>" 
            ); 
        }
        if ($tampilkan == 'kinerja-user-frekuensi')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'kinerja-user-data')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pdf-data-kinerja-user').'">';
            echo "<iframe>";
        }
    }

public function actionRenderPdfPerpendaftaranData() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ProvinceNow  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.CityNow  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND (YEAR(CURDATE())-YEAR(members.DateOfBirth))  BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                }
            }
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }

        $sql = "SELECT ".$periode_format.",
                members.FullName AS Anggota,
                members.MemberNo AS MemberNo,
                CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL, 
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                IF(IsLunas,'Lunas','Belum') AS IsLunas, 
                jenis_kelamin.Name AS jenis_kelamin, 
                master_jenis_identitas.Nama AS jenis_identitas,
                members.IdentityNo AS no_identitas,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon, 
                members.Email AS email, 
                jenis_anggota.jenisanggota AS jenis_anggota, 
                master_pekerjaan.Pekerjaan AS pekerjaan, 
                master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, 
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, 
                status_anggota.Nama AS status_anggota, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS masa_akhir,
                jenis_anggota.BiayaPendaftaran AS biaya_pendaftaran, 
                location_library.Name AS loc_id, 
                collectioncategorys.Name AS categori_pinjam 
                FROM members
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id 
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id 
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID 
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id 
                LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_id = members.ID 
                LEFT JOIN collectioncategorys ON collectioncategorys.ID = memberloanauthorizecategory.CategoryLoan_id 
                WHERE
                DATE(members.CreateDate) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' GROUP BY DATE_FORMAT(members.CreateDate,"%d-%m-%Y"),members.ID ORDER BY members.RegisterDate ASC';

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
             'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-perpendaftaran-tampilkan-data', $content),
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

public function actionExportExcelPerpendaftaranData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ProvinceNow  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.CityNow  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND (YEAR(CURDATE())-YEAR(members.DateOfBirth))  BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                }
            }
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }

        $sql = "SELECT ".$periode_format.",
                members.FullName AS Anggota,
                members.MemberNo AS MemberNo,
                CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL, 
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                IF(IsLunas,'Lunas','Belum') AS IsLunas, 
                jenis_kelamin.Name AS jenis_kelamin, 
                master_jenis_identitas.Nama AS jenis_identitas,
                members.IdentityNo AS no_identitas,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon, 
                members.Email AS email, 
                jenis_anggota.jenisanggota AS jenis_anggota, 
                master_pekerjaan.Pekerjaan AS pekerjaan, 
                master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, 
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, 
                status_anggota.Nama AS status_anggota, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS masa_akhir,
                jenis_anggota.BiayaPendaftaran AS biaya_pendaftaran, 
                location_library.Name AS loc_id, 
                collectioncategorys.Name AS categori_pinjam 
                FROM members
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id 
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id 
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID 
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id 
                LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_id = members.ID 
                LEFT JOIN collectioncategorys ON collectioncategorys.ID = memberloanauthorizecategory.CategoryLoan_id 
                WHERE
                DATE(members.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY DATE_FORMAT(members.CreateDate,"%d-%m-%Y"),members.ID ORDER BY members.RegisterDate ASC';

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
                <th colspan="23">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="23">Pemanfaatan OPAC '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="23">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Jenis Identitas</th>
                <th>Nomer Identitas</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Provinsi</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Status Keanggotaan</th>
                <th>Tanggal Akhir Berlaku</th>
                <th>Biaya</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['jenis_identitas'].'</td>
                    <td>'.$data['no_identitas'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['status_anggota'].'</td>
                    <td>'.$data['masa_akhir'].'</td>
                    <td>'.$data['biaya_pendaftaran'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtPerpendaftaranData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ProvinceNow  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.CityNow  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND (YEAR(CURDATE())-YEAR(members.DateOfBirth))  BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                }
            }
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }

        $sql = "SELECT ".$periode_format.",
                members.FullName AS Anggota,
                members.MemberNo AS MemberNo,
                CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL, 
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                IF(IsLunas,'Lunas','Belum') AS IsLunas, 
                jenis_kelamin.Name AS jenis_kelamin, 
                master_jenis_identitas.Nama AS jenis_identitas,
                members.IdentityNo AS no_identitas,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon, 
                members.Email AS email, 
                jenis_anggota.jenisanggota AS jenis_anggota, 
                master_pekerjaan.Pekerjaan AS pekerjaan, 
                master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, 
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, 
                status_anggota.Nama AS status_anggota, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS masa_akhir,
                jenis_anggota.BiayaPendaftaran AS biaya_pendaftaran, 
                location_library.Name AS loc_id, 
                collectioncategorys.Name AS categori_pinjam 
                FROM members
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id 
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id 
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID 
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id 
                LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_id = members.ID 
                LEFT JOIN collectioncategorys ON collectioncategorys.ID = memberloanauthorizecategory.CategoryLoan_id 
                WHERE
                DATE(members.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY DATE_FORMAT(members.CreateDate,"%d-%m-%Y"),members.ID ORDER BY members.RegisterDate ASC';

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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'MemberNo'=>$model['MemberNo'], 'Anggota'=>$model['Anggota'], 'jenis_kelamin'=>$model['jenis_kelamin'], 'TTL'=>$model['TTL'], 'umur'=>$model['umur'], 'jenis_identitas'=>$model['jenis_identitas']
                        , 'no_identitas'=>$model['no_identitas'], 'alamat'=>$model['alamat'], 'kab_kota'=>$model['kab_kota'], 'provinsi'=>$model['provinsi'], 'telepon'=>$model['telepon'], 'email'=>$model['email'], 'jenis_anggota'=>$model['jenis_anggota'], 'pekerjaan'=>$model['pekerjaan']
                        , 'pendidikan'=>$model['pendidikan'], 'fakultas'=>$model['fakultas'], 'jurusan'=>$model['jurusan'], 'kelas'=>$model['kelas'], 'status_anggota'=>$model['status_anggota'], 'masa_akhir'=>$model['masa_akhir'], 'biaya_pendaftaran'=>$model['biaya_pendaftaran'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpendaftaran-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggoya-perpendaftaran-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordPerpendaftaranData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ProvinceNow  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.CityNow  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND (YEAR(CURDATE())-YEAR(members.DateOfBirth))  BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                }
            }
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }

        $sql = "SELECT ".$periode_format.",
                members.FullName AS Anggota,
                members.MemberNo AS MemberNo,
                CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL, 
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                IF(IsLunas,'Lunas','Belum') AS IsLunas, 
                jenis_kelamin.Name AS jenis_kelamin, 
                master_jenis_identitas.Nama AS jenis_identitas,
                members.IdentityNo AS no_identitas,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon, 
                members.Email AS email, 
                jenis_anggota.jenisanggota AS jenis_anggota, 
                master_pekerjaan.Pekerjaan AS pekerjaan, 
                master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, 
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, 
                status_anggota.Nama AS status_anggota, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS masa_akhir,
                jenis_anggota.BiayaPendaftaran AS biaya_pendaftaran, 
                location_library.Name AS loc_id, 
                collectioncategorys.Name AS categori_pinjam 
                FROM members
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id 
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id 
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID 
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id 
                LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_id = members.ID 
                LEFT JOIN collectioncategorys ON collectioncategorys.ID = memberloanauthorizecategory.CategoryLoan_id 
                WHERE
                DATE(members.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY DATE_FORMAT(members.CreateDate,"%d-%m-%Y"),members.ID ORDER BY members.RegisterDate ASC';

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
                <th colspan="23">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="23">Pemanfaatan OPAC '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="23">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left:10px; margin-right:10px;">
                <th>No.</th>
                <th>Periode</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Jenis Identitas</th>
                <th>Nomer Identitas</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Provinsi</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Status Keanggotaan</th>
                <th>Tanggal Akhir Berlaku</th>
                <th>Biaya</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['jenis_identitas'].'</td>
                    <td>'.$data['no_identitas'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['status_anggota'].'</td>
                    <td>'.$data['masa_akhir'].'</td>
                    <td>'.$data['biaya_pendaftaran'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfPerpendaftaranData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        } 

        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ProvinceNow  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.CityNow  = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND (YEAR(CURDATE())-YEAR(members.DateOfBirth))  BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                }
            }
        }
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) >= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        } 
        if (isset($_POST['todata_entry'])) {
            foreach ($_POST['todata_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND  DATE(member_perpanjangan.CreateDate) <= "'.date("Y-m-d", strtotime( $value ) ).'" ';
                }
            }
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        } 
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }

        $sql = "SELECT ".$periode_format.",
                members.FullName AS Anggota,
                members.MemberNo AS MemberNo,
                CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL, 
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                IF(IsLunas,'Lunas','Belum') AS IsLunas, 
                jenis_kelamin.Name AS jenis_kelamin, 
                master_jenis_identitas.Nama AS jenis_identitas,
                members.IdentityNo AS no_identitas,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon, 
                members.Email AS email, 
                jenis_anggota.jenisanggota AS jenis_anggota, 
                master_pekerjaan.Pekerjaan AS pekerjaan, 
                master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, 
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, 
                status_anggota.Nama AS status_anggota, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS masa_akhir,
                jenis_anggota.BiayaPendaftaran AS biaya_pendaftaran, 
                location_library.Name AS loc_id, 
                collectioncategorys.Name AS categori_pinjam 
                FROM members
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id 
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id 
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID 
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id 
                LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_id = members.ID 
                LEFT JOIN collectioncategorys ON collectioncategorys.ID = memberloanauthorizecategory.CategoryLoan_id 
                WHERE
                DATE(members.CreateDate) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' GROUP BY DATE_FORMAT(members.CreateDate,"%d-%m-%Y"),members.ID ORDER BY members.RegisterDate ASC';

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
        $content = $this->renderPartial('pdf-view-perpendaftaran-tampilkan-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderPdfPerpanjanganData() 
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

       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%M-%Y') AS Periode, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS akhir_berlaku, 
                members.FullName AS Anggota,Biaya,MemberNo,CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth, '%d-%m-%Y')) AS TTL, 
                jenis_kelamin.Name AS jenis_kelamin, users.Fullname AS Petugas, (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur, 
                master_jenis_identitas.Nama AS jenis_identitas, members.IdentityNo AS no_identitas, members.Address AS alamat, members.City AS kab_kota,
                members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, jenis_anggota.jenisanggota AS jenis_anggota,
                master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, location_library.Name AS lokasi_pinjam,status_anggota.Nama AS status_anggota
                FROM member_perpanjangan 
                LEFT JOIN users ON users.ID = member_perpanjangan.CreateBy
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id WHERE DATE(member_perpanjangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content['kop'] = isset($_POST['kop']);

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
            'marginTop' => $set,
            'marginLeft' =>0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-perpanjangan-data', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelPerperpanjanganData()
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

       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%M-%Y') AS Periode, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS akhir_berlaku, 
                members.FullName AS Anggota,Biaya,MemberNo,CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth, '%d-%m-%Y')) AS TTL, 
                jenis_kelamin.Name AS jenis_kelamin, users.Fullname AS Petugas, (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur, 
                master_jenis_identitas.Nama AS jenis_identitas, members.IdentityNo AS no_identitas, members.Address AS alamat, members.City AS kab_kota,
                members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, jenis_anggota.jenisanggota AS jenis_anggota,
                master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, location_library.Name AS lokasi_pinjam,status_anggota.Nama AS status_anggota
                FROM member_perpanjangan 
                LEFT JOIN users ON users.ID = member_perpanjangan.CreateBy
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id WHERE DATE(member_perpanjangan.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
                <th colspan="23">Laporan Detail Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="23">Perpanjangan Anggota '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="23">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Jenis Identitas</th>
                <th>Nomer Identitas</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Provinsi</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Status Keanggotaan</th>
                <th>Tanggal Akhir Berlaku</th>
                <th>Biaya</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['jenis_identitas'].'</td>
                    <td>'.$data['no_identitas'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['status_anggota'].'</td>
                    <td>'.$data['masa_akhir'].'</td>
                    <td>'.$data['biaya_pendaftaran'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtPerperpanjanganData()
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

       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%M-%Y') AS Periode, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS akhir_berlaku, 
                members.FullName AS Anggota,Biaya,MemberNo,CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth, '%d-%m-%Y')) AS TTL, 
                jenis_kelamin.Name AS jenis_kelamin, users.Fullname AS Petugas, (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur, 
                master_jenis_identitas.Nama AS jenis_identitas, members.IdentityNo AS no_identitas, members.Address AS alamat, members.City AS kab_kota,
                members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, jenis_anggota.jenisanggota AS jenis_anggota,
                master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, location_library.Name AS lokasi_pinjam,status_anggota.Nama AS status_anggota
                FROM member_perpanjangan 
                LEFT JOIN users ON users.ID = member_perpanjangan.CreateBy
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id WHERE DATE(member_perpanjangan.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'MemberNo'=>$model['MemberNo'], 'Anggota'=>$model['Anggota'], 'jenis_kelamin'=>$model['jenis_kelamin'], 'TTL'=>$model['TTL'], 'umur'=>$model['umur'], 'jenis_identitas'=>$model['jenis_identitas']
                        , 'no_identitas'=>$model['no_identitas'], 'alamat'=>$model['alamat'], 'kab_kota'=>$model['kab_kota'], 'provinsi'=>$model['provinsi'], 'telepon'=>$model['telepon'], 'email'=>$model['email'], 'jenis_anggota'=>$model['jenis_anggota'], 'pekerjaan'=>$model['pekerjaan']
                        , 'pendidikan'=>$model['pendidikan'], 'fakultas'=>$model['fakultas'], 'jurusan'=>$model['jurusan'], 'kelas'=>$model['kelas'], 'status_anggota'=>$model['status_anggota'], 'akhir_berlaku'=>$model['akhir_berlaku'], 'Biaya'=>$model['Biaya'], 'lokasi_pinjam'=>$model['lokasi_pinjam'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpanjangan-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-perpanjangan-anggota-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordPerperpanjanganData()
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

       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%M-%Y') AS Periode, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS akhir_berlaku, 
                members.FullName AS Anggota,Biaya,MemberNo,CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth, '%d-%m-%Y')) AS TTL, 
                jenis_kelamin.Name AS jenis_kelamin, users.Fullname AS Petugas, (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur, 
                master_jenis_identitas.Nama AS jenis_identitas, members.IdentityNo AS no_identitas, members.Address AS alamat, members.City AS kab_kota,
                members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, jenis_anggota.jenisanggota AS jenis_anggota,
                master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, location_library.Name AS lokasi_pinjam,status_anggota.Nama AS status_anggota
                FROM member_perpanjangan 
                LEFT JOIN users ON users.ID = member_perpanjangan.CreateBy
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id WHERE DATE(member_perpanjangan.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
                <th colspan="23">Laporan Detail Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="23">Perpanjangan Anggota '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="23">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Jenis Identitas</th>
                <th>Nomer Identitas</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Provinsi</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Status Keanggotaan</th>
                <th>Tanggal Akhir Berlaku</th>
                <th>Biaya Perpanjangan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['jenis_identitas'].'</td>
                    <td>'.$data['no_identitas'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                    <td>'.$data['status_anggota'].'</td>
                    <td>'.$data['masa_akhir'].'</td>
                    <td>'.$data['biaya_pendaftaran'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfPerperpanjanganData()
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

       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%M-%Y') AS Periode, 
                DATE_FORMAT(members.EndDate,'%d-%M-%Y') AS akhir_berlaku, 
                members.FullName AS Anggota,Biaya,MemberNo,CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth, '%d-%m-%Y')) AS TTL, 
                jenis_kelamin.Name AS jenis_kelamin, users.Fullname AS Petugas, (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur, 
                master_jenis_identitas.Nama AS jenis_identitas, members.IdentityNo AS no_identitas, members.Address AS alamat, members.City AS kab_kota,
                members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, jenis_anggota.jenisanggota AS jenis_anggota,
                master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas, location_library.Name AS lokasi_pinjam,status_anggota.Nama AS status_anggota
                FROM member_perpanjangan 
                LEFT JOIN users ON users.ID = member_perpanjangan.CreateBy
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_id = members.ID
                LEFT JOIN location_library ON location_library.ID = memberloanauthorizelocation.LocationLoan_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id WHERE DATE(member_perpanjangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
        // }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] = isset($_POST['kop']);

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
        $content = $this->renderPartial('pdf-view-perpanjangan-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderPdfSumbanganData() 
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
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
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(sumbangan.CreateDate,'%d-%M-%Y') AS Periode,
                sumbangan.jumlah AS sumbangan,
                members.MemberNo AS MemberNo,
                members.Fullname AS Anggota,
                jenis_kelamin.Name AS jenis_kelamin,
                CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon,
                members.Email AS email,
                master_pekerjaan.Pekerjaan AS pekerjaan,
                master_pendidikan.Nama AS pendidikan,
                master_fakultas.Nama AS fakultas,
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas
                FROM
                sumbangan
                LEFT JOIN members ON sumbangan.Member_id = members.ID
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' ORDER BY Periode ASC';

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
        $content['kop'] = isset($_POST['kop']);

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
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-sumbangan-tampilkan-data', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelAnggSumbanganData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
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
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(sumbangan.CreateDate,'%d-%M-%Y') AS Periode,
                sumbangan.jumlah AS sumbangan,
                members.MemberNo AS MemberNo,
                members.Fullname AS Anggota,
                jenis_kelamin.Name AS jenis_kelamin,
                CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon,
                members.Email AS email,
                master_pekerjaan.Pekerjaan AS pekerjaan,
                master_pendidikan.Nama AS pendidikan,
                master_fakultas.Nama AS fakultas,
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas
                FROM
                sumbangan
                LEFT JOIN members ON sumbangan.Member_id = members.ID
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' ORDER BY Periode ASC';

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
                <th colspan="18">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="18">Sumbangan Anggota '.$periode2.'</th>
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
                <th>Tanggal Sumbangan</th>
                <th>Jumlah Sumbangan</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten Kota</th>
                <th>Provinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['sumbangan'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtAnggSumbanganData()

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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
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
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(sumbangan.CreateDate,'%d-%M-%Y') AS Periode,
                sumbangan.jumlah AS sumbangan,
                members.MemberNo AS MemberNo,
                members.Fullname AS Anggota,
                jenis_kelamin.Name AS jenis_kelamin,
                CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon,
                members.Email AS email,
                master_pekerjaan.Pekerjaan AS pekerjaan,
                master_pendidikan.Nama AS pendidikan,
                master_fakultas.Nama AS fakultas,
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas
                FROM
                sumbangan
                LEFT JOIN members ON sumbangan.Member_id = members.ID
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' ORDER BY Periode ASC';

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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'],'sumbangan'=> $model['sumbangan'], 'MemberNo'=>$model['MemberNo'], 'Anggota'=>$model['Anggota'], 'jenis_kelamin'=>$model['jenis_kelamin'], 'TTL'=>$model['TTL'], 'umur'=>$model['umur']
                        , 'alamat'=>$model['alamat'], 'kab_kota'=>$model['kab_kota'], 'provinsi'=>$model['provinsi'], 'telepon'=>$model['telepon'], 'email'=>$model['email'], 'pekerjaan'=>$model['pekerjaan']
                        , 'pendidikan'=>$model['pendidikan'], 'fakultas'=>$model['fakultas'], 'jurusan'=>$model['jurusan'], 'kelas'=>$model['kelas'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-sumbangan-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-sumbangan-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordAnggSumbanganData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
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
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(sumbangan.CreateDate,'%d-%M-%Y') AS Periode,
                sumbangan.jumlah AS sumbangan,
                members.MemberNo AS MemberNo,
                members.Fullname AS Anggota,
                jenis_kelamin.Name AS jenis_kelamin,
                CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon,
                members.Email AS email,
                master_pekerjaan.Pekerjaan AS pekerjaan,
                master_pendidikan.Nama AS pendidikan,
                master_fakultas.Nama AS fakultas,
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas
                FROM
                sumbangan
                LEFT JOIN members ON sumbangan.Member_id = members.ID
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' ORDER BY Periode ASC';

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
                <th colspan="18">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="18">Sumbangan Anggota '.$periode2.'</th>
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
                <th>Tanggal Sumbangan</th>
                <th>Jumlah Sumbangan</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten Kota</th>
                <th>Provinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['sumbangan'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfAnggSumbanganData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
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
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(sumbangan.CreateDate,'%d-%M-%Y') AS Periode,
                sumbangan.jumlah AS sumbangan,
                members.MemberNo AS MemberNo,
                members.Fullname AS Anggota,
                jenis_kelamin.Name AS jenis_kelamin,
                CONCAT(members.PlaceOfBirth,', ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,
                (YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, 
                members.City AS kab_kota, 
                members.Province AS provinsi, 
                members.NoHp AS telepon,
                members.Email AS email,
                master_pekerjaan.Pekerjaan AS pekerjaan,
                master_pendidikan.Nama AS pendidikan,
                master_fakultas.Nama AS fakultas,
                master_jurusan.Nama AS jurusan,
                kelas_siswa.namakelassiswa AS kelas
                FROM
                sumbangan
                LEFT JOIN members ON sumbangan.Member_id = members.ID
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' ORDER BY Periode ASC';
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
        $content_kop['kop'] = isset($_POST['kop']);

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
        $content = $this->renderPartial('pdf-view-sumbangan-tampilkan-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderPdfBebasPustakaData() 
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];               
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2= 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(members.TanggalBebasPustaka,'%d-%M-%Y') AS Periode, 
                members.MemberNo AS MemberNo, members.Fullname AS Anggota, 
                jenis_kelamin.Name AS jenis_kelamin,CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,(YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, members.City AS kab_kota, members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,kelas_siswa.namakelassiswa AS kelas
                FROM members 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN users ON users.ID = members.CreateBy WHERE DATE(members.TanggalBebasPustaka) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';
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
        $content['kop'] = isset($_POST['kop']);

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
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-bebas-pustaka-data', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelBebasPustakaData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];               
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2= 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(members.TanggalBebasPustaka,'%d-%M-%Y') AS Periode, 
                members.MemberNo AS MemberNo, members.Fullname AS Anggota, 
                jenis_kelamin.Name AS jenis_kelamin,CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,(YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, members.City AS kab_kota, members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,kelas_siswa.namakelassiswa AS kelas
                FROM members 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN users ON users.ID = members.CreateBy WHERE DATE(members.TanggalBebasPustaka) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
                <th colspan="17">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="17">Anggota Bebas Pustaka '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="17">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Bebas Pustaka</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten Kota</th>
                <th>Provinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtBebasPustakaData()

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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];               
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2= 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(members.TanggalBebasPustaka,'%d-%M-%Y') AS Periode, 
                members.MemberNo AS MemberNo, members.Fullname AS Anggota, 
                jenis_kelamin.Name AS jenis_kelamin,CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,(YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, members.City AS kab_kota, members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,kelas_siswa.namakelassiswa AS kelas
                FROM members 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN users ON users.ID = members.CreateBy WHERE DATE(members.TanggalBebasPustaka) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'MemberNo'=>$model['MemberNo'], 'Anggota'=>$model['Anggota'], 'jenis_kelamin'=>$model['jenis_kelamin'], 'TTL'=>$model['TTL'], 'umur'=>$model['umur']
                        , 'alamat'=>$model['alamat'], 'kab_kota'=>$model['kab_kota'], 'provinsi'=>$model['provinsi'], 'telepon'=>$model['telepon'], 'email'=>$model['email'], 'pekerjaan'=>$model['pekerjaan']
                        , 'pendidikan'=>$model['pendidikan'], 'fakultas'=>$model['fakultas'], 'jurusan'=>$model['jurusan'], 'kelas'=>$model['kelas'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-bebas-pustaka-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-bebas-pustaka-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordBebasPustakaData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];               
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2= 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(members.TanggalBebasPustaka,'%d-%M-%Y') AS Periode, 
                members.MemberNo AS MemberNo, members.Fullname AS Anggota, 
                jenis_kelamin.Name AS jenis_kelamin,CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,(YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, members.City AS kab_kota, members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,kelas_siswa.namakelassiswa AS kelas
                FROM members 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN users ON users.ID = members.CreateBy WHERE DATE(members.TanggalBebasPustaka) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';

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
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="17">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="17">Anggota Bebas Pustaka '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="17">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Bebas Pustaka</th>
                <th>Nomer Anggota</th>
                <th>Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat & Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten Kota</th>
                <th>Provinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Fakultas</th>
                <th>Jurusan</th>
                <th>Kelas</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['MemberNo'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['jenis_kelamin'].'</td>
                    <td>'.$data['TTL'].'</td>
                    <td>'.$data['umur'].'</td>
                    <td>'.$data['alamat'].'</td>
                    <td>'.$data['kab_kota'].'</td>
                    <td>'.$data['provinsi'].'</td>
                    <td>'.$data['telepon'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['pendidikan'].'</td>
                    <td>'.$data['fakultas'].'</td>
                    <td>'.$data['jurusan'].'</td>
                    <td>'.$data['kelas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfBebasPustakaData()
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
                $periode2= 'periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2= 'periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];               
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2= 'periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
   
       if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
            }
        }  
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        }
        $sql = "SELECT DATE_FORMAT(members.TanggalBebasPustaka,'%d-%M-%Y') AS Periode, 
                members.MemberNo AS MemberNo, members.Fullname AS Anggota, 
                jenis_kelamin.Name AS jenis_kelamin,CONCAT(members.PlaceOfBirth,' & ', DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TTL,(YEAR(CURDATE())-YEAR(members.DateOfBirth)) AS umur,
                members.Address AS alamat, members.City AS kab_kota, members.Province AS provinsi, members.NoHp AS telepon, members.Email AS email, master_pekerjaan.Pekerjaan AS pekerjaan, master_pendidikan.Nama AS pendidikan, 
                master_fakultas.Nama AS fakultas, master_jurusan.Nama AS jurusan,kelas_siswa.namakelassiswa AS kelas
                FROM members 
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN users ON users.ID = members.CreateBy WHERE DATE(members.TanggalBebasPustaka) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;

        $sql .= ' GROUP BY Periode ORDER BY Periode ASC';
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
        $content_kop['kop'] = isset($_POST['kop']);

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
        $content = $this->renderPartial('pdf-view-bebas-pustaka-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

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
                 WHEN modelhistory.type = '0' THEN 'Mengentri' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
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
        $sql .= " AND modelhistory.table = 'members'";
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
            'content' => $this->renderPartial('pdf-view-kinerja-user-data', $content),
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
                 WHEN modelhistory.type = '0' THEN 'Mengentri' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
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
        $sql .= " AND modelhistory.table = 'members'";
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
                <th colspan="5">Kinerja User Anggota '.$periode2.'</th>
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
        $sql .= " AND modelhistory.table = 'members'";
        $sql .= $andValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-kinerja-user-data.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-kinerja-user-data.ods');
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
                 WHEN modelhistory.type = '0' THEN 'Mengentri' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
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
        $sql .= " AND modelhistory.table = 'members'";
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
               <p align="center"> <b>Kinerja User Anggota '.$periode2.' </b></p>
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
                 WHEN modelhistory.type = '0' THEN 'Mengentri' 
                 WHEN modelhistory.type = '1' THEN 'Mengedit' 
                 ELSE 'Menghapus' 
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
        $sql .= " AND modelhistory.table = 'members'";
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
        $content = $this->renderPartial('pdf-view-kinerja-user-data', $content);
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
public function actionRenderPerpendaftaranFrekuensi() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $and = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
        

        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
        $andQuery .= ", status_anggota.Nama AS subjek"; 
            }
        } 
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
        $andQuery .= ", master_range_umur.Keterangan AS subjek"; 
            }
        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", jenis_kelamin.Name AS subjek"; 
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
        $andQuery .= ", jenis_anggota.jenisanggota AS subjek"; 
        }
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pekerjaan.Pekerjaan AS subjek"; 
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", location_library.Name AS subjek"; 
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
                INNER JOIN locations ON collections.Location_Id = locations.ID";
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", collectioncategorys.Name AS subjek";
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID"; 
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jenis_identitas.Nama AS subjek";
        }
        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.InstitutionName AS subjek";
        }
        
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(members.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
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
        }
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", users.username AS subjek";
        }

        $sql = "SELECT ".$periode_format.", 
                members.MemberNo, 
                COUNT(members.ID) AS Jumlah 
                ".$andQuery."
                FROM members
                INNER JOIN master_range_umur ON umur(members.DateOfBirth) BETWEEN master_range_umur.umur1 AND master_range_umur.umur2
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = members.CreateBy
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id
                ".$and."
                WHERE DATE(members.CreateDate) ";
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0" ) {
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set = 55;
        } else {
            $header =  [''];
            $set = 10;
        }


        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'marginTop' => $set,
            'marginLeft' =>0,
            'marginRight' =>0,
            'content' => $this->renderPartial('pdf-view-perpendaftaran', $content),
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

public function actionExportExcelPerpendaftaranFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $and = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
        

        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
        $andQuery .= ", status_anggota.Nama AS subjek"; 
            }
        } 
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
        $andQuery .= ", master_range_umur.Keterangan AS subjek"; 
            }
        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", jenis_kelamin.Name AS subjek"; 
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
        $andQuery .= ", jenis_anggota.jenisanggota AS subjek"; 
        }
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pekerjaan.Pekerjaan AS subjek"; 
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", location_library.Name AS subjek"; 
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
                INNER JOIN locations ON collections.Location_Id = locations.ID";
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", collectioncategorys.Name AS subjek";
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID"; 
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jenis_identitas.Nama AS subjek";
        }
        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.InstitutionName AS subjek";
        }
        
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(members.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
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
        }
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", users.username AS subjek";
        }

        $sql = "SELECT ".$periode_format.", 
                members.MemberNo, 
                COUNT(members.ID) AS Jumlah 
                ".$andQuery."
                FROM members
                INNER JOIN master_range_umur ON umur(members.DateOfBirth) BETWEEN master_range_umur.umur1 AND master_range_umur.umur2
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = members.CreateBy
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id
                ".$and."
                WHERE DATE(members.CreateDate) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Anggota Per Pendaftaraan '.$periode2.'</th>
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
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
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
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportExcelOdtPerpendaftaranFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $and = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
        

        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
        $andQuery .= ", status_anggota.Nama AS subjek"; 
            }
        } 
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
        $andQuery .= ", master_range_umur.Keterangan AS subjek"; 
            }
        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", jenis_kelamin.Name AS subjek"; 
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
        $andQuery .= ", jenis_anggota.jenisanggota AS subjek"; 
        }
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pekerjaan.Pekerjaan AS subjek"; 
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", location_library.Name AS subjek"; 
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
                INNER JOIN locations ON collections.Location_Id = locations.ID";
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", collectioncategorys.Name AS subjek";
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID"; 
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jenis_identitas.Nama AS subjek";
        }
        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.InstitutionName AS subjek";
        }
        
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(members.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
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
        }
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", users.username AS subjek";
        }

        $sql = "SELECT ".$periode_format.", 
                members.MemberNo, 
                COUNT(members.ID) AS Jumlah 
                ".$andQuery."
                FROM members
                INNER JOIN master_range_umur ON umur(members.DateOfBirth) BETWEEN master_range_umur.umur1 AND master_range_umur.umur2
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = members.CreateBy
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id
                ".$and."
                WHERE DATE(members.CreateDate) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'subjek'=>$model['subjek'], 'Jumlah'=>$model['Jumlah'] );
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpendaftaran-frekuensi.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpendaftaran-frekuensi_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-perpendaftaran-frekuensi.ods');
    // !Open Office Calc Area


}


public function actionExportWordPerpendaftaranFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $and = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
        

        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
        $andQuery .= ", status_anggota.Nama AS subjek"; 
            }
        } 
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
        $andQuery .= ", master_range_umur.Keterangan AS subjek"; 
            }
        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", jenis_kelamin.Name AS subjek"; 
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
        $andQuery .= ", jenis_anggota.jenisanggota AS subjek"; 
        }
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pekerjaan.Pekerjaan AS subjek"; 
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", location_library.Name AS subjek"; 
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
                INNER JOIN locations ON collections.Location_Id = locations.ID";
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", collectioncategorys.Name AS subjek";
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID"; 
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jenis_identitas.Nama AS subjek";
        }
        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.InstitutionName AS subjek";
        }
        
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(members.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
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
        }
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", users.username AS subjek";
        }

        $sql = "SELECT ".$periode_format.", 
                members.MemberNo, 
                COUNT(members.ID) AS Jumlah 
                ".$andQuery."
                FROM members
                INNER JOIN master_range_umur ON umur(members.DateOfBirth) BETWEEN master_range_umur.umur1 AND master_range_umur.umur2
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = members.CreateBy
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id
                ".$and."
                WHERE DATE(members.CreateDate) ";  

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Anggota Per Pendaftaraan '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 50px; margin-left: 50px;">
                <th>No.</th>
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
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
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportPdfPerpendaftaranFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $and = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode_format = 'DATE_FORMAT(members.RegisterDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
        

        if (isset($_POST['Status_Anggota'])) {
            foreach ($_POST['Status_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND status_anggota.Nama = "'.addslashes($value).'" ';
                }
        $andQuery .= ", status_anggota.Nama AS subjek"; 
            }
        } 
        if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
        $andQuery .= ", master_range_umur.Keterangan AS subjek"; 
            }
        if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", jenis_kelamin.Name AS subjek"; 
        } 
        if (isset($_POST['Jenis_Anggota'])) {
            foreach ($_POST['Jenis_Anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
        $andQuery .= ", jenis_anggota.jenisanggota AS subjek"; 
        }
        if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pekerjaan.Pekerjaan AS subjek"; 
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }
        if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND location_library.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", location_library.Name AS subjek"; 
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
                INNER JOIN locations ON collections.Location_Id = locations.ID";
        } 
        if (isset($_POST['kategori_koleksi'])) {
            foreach ($_POST['kategori_koleksi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND collectioncategorys.Name  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", collectioncategorys.Name AS subjek";
        $and .= "INNER JOIN collectionloanitems ON collectionloanitems.Member_id = members.ID 
                INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID"; 
        } 
        if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jenis_identitas.id  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jenis_identitas.Nama AS subjek";
        }
        if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Province  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", propinsi.NamaPropinsi AS subjek";
        $and .= "INNER JOIN propinsi on propinsi.NamaPropinsi = members.Province ";
        } 
        if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.City  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.City AS subjek";
        }
        if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.InstitutionName  = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", members.InstitutionName AS subjek";
        }
        
        if (isset($_POST['data_entry'])) {
            foreach ($_POST['data_entry'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " OR DATE(members.CreateDate) BETWEEN '".date("Y-m-d", strtotime( $value ) )."' ";
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
        }
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", users.username AS subjek";
        }

        $sql = "SELECT ".$periode_format.", 
                members.MemberNo, 
                COUNT(members.ID) AS Jumlah 
                ".$andQuery."
                FROM members
                INNER JOIN master_range_umur ON umur(members.DateOfBirth) BETWEEN master_range_umur.umur1 AND master_range_umur.umur2
                LEFT JOIN member_perpanjangan ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = members.CreateBy
                LEFT JOIN jenis_kelamin ON jenis_kelamin.ID = members.Sex_id 
                LEFT JOIN master_jenis_identitas ON master_jenis_identitas.id = members.IdentityType_id 
                LEFT JOIN jenis_anggota ON jenis_anggota.id = members.JenisAnggota_id 
                LEFT JOIN master_pekerjaan ON master_pekerjaan.id = members.Job_id 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id 
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id 
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id 
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN status_anggota ON status_anggota.id = members.StatusAnggota_id
                ".$and."
                WHERE DATE(members.CreateDate) ";
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.CreateDate,'%d-%m-%Y') ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.CreateDate), subjek ORDER BY DATE_FORMAT(members.CreateDate,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0" ) {
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
        $content = $this->renderPartial('pdf-view-perpendaftaran', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');
        
    }

public function actionRenderPdfPerpanjanganFrekuensi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
        $andQuery .= ", users.username AS subjek"; 
            }
        }   
        $sql = "SELECT ".$periode_format.",
                COUNT(member_perpanjangan.ID) AS Jumlah
                ".$andQuery." 
                FROM member_perpanjangan
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = member_perpanjangan.CreateBy WHERE DATE(member_perpanjangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
            'content' => $this->renderPartial('pdf-view-perpanjangan', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelPerperpanjanganFrekuensi()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
        $andQuery .= ", users.username AS subjek"; 
            }
        }   
        $sql = "SELECT ".$periode_format.",
                COUNT(member_perpanjangan.ID) AS Jumlah
                ".$andQuery." 
                FROM member_perpanjangan
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = member_perpanjangan.CreateBy WHERE DATE(member_perpanjangan.CreateDate) ";        

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Pemanfaatan OPAC '.$periode2.'</th>
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
                <th>Periode Perpanjangan</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
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
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportExcelOdtPerperpanjanganFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
        $andQuery .= ", users.username AS subjek"; 
            }
        }   
        $sql = "SELECT ".$periode_format.",
                COUNT(member_perpanjangan.ID) AS Jumlah
                ".$andQuery." 
                FROM member_perpanjangan
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = member_perpanjangan.CreateBy WHERE DATE(member_perpanjangan.CreateDate) ";        

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'subjek'=>$model['subjek'], 'Jumlah'=>$model['Jumlah'] );
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpanjangan-frekuensi.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-perpanjangan-frekuensi_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-OPAC-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordPerperpanjanganFrekuensi()
{
    // $model = Opaclogs::find()->All();

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
        $andQuery .= ", users.username AS subjek"; 
            }
        }   
        $sql = "SELECT ".$periode_format.",
                COUNT(member_perpanjangan.ID) AS Jumlah
                ".$andQuery." 
                FROM member_perpanjangan
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = member_perpanjangan.CreateBy WHERE DATE(member_perpanjangan.CreateDate) ";        

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Pemanfaatan OPAC '.$periode2.'</th>
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
                <th>Periode Perpanjangan</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
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
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportPdfPerperpanjanganFrekuensi()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(member_perpanjangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }  
        if (isset($_POST['petugas_perpanjangan'])) {
            foreach ($_POST['petugas_perpanjangan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND users.username = "'.addslashes($value).'" ';
                }
        $andQuery .= ", users.username AS subjek"; 
            }
        }   
        $sql = "SELECT ".$periode_format.",
                COUNT(member_perpanjangan.ID) AS Jumlah
                ".$andQuery." 
                FROM member_perpanjangan
                LEFT JOIN members ON member_perpanjangan.Member_id = members.ID 
                LEFT JOIN users on users.ID = member_perpanjangan.CreateBy WHERE DATE(member_perpanjangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(member_perpanjangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(member_perpanjangan.CreateDate), subjek ORDER BY DATE_FORMAT(member_perpanjangan.CreateDate,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        // if (count($_POST['kriterias']) == 1 && implode($_POST[implode($_POST['kriterias'])]) !== "0") {
         
        //     $Berdasarkan .= ' ' .implode($_POST[implode($_POST['kriterias'])]);
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
        $content = $this->renderPartial('pdf-view-perpanjangan', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderPdfAnggSumbanganFrekuensi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
  
        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(sumbangan.ID) AS Jumlah, 
                sumbangan.Jumlah AS sumbangan
                ".$andQuery."
                FROM sumbangan 
                LEFT JOIN members ON sumbangan.Member_id = members.ID 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.Code = members.UnitKerja_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(sumbangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content['kop'] = isset($_POST['kop']);

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
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-sumbangan', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelAnggSumbanganFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
  
        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(sumbangan.ID) AS Jumlah, 
                sumbangan.Jumlah AS sumbangan
                ".$andQuery."
                FROM sumbangan 
                LEFT JOIN members ON sumbangan.Member_id = members.ID 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.Code = members.UnitKerja_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(sumbangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Sumbangan Anggota '.$periode2.'</th>
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
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Anggota</th>
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
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportExcelOdtAnggSumbanganFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
  
        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(sumbangan.ID) AS Jumlah, 
                sumbangan.Jumlah AS sumbangan
                ".$andQuery."
                FROM sumbangan 
                LEFT JOIN members ON sumbangan.Member_id = members.ID 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.Code = members.UnitKerja_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(sumbangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= '' .$this->getRealNameKriteria($value).'';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'subjek'=>$model['subjek'], 'Jumlah'=>$model['Jumlah'], 'sumbangan'=>$model['sumbangan'] );
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-sumbangan-frekuensi.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-sumbangan-frekuensi_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sumbangan-anggota-frekuensi.ods');
    // !Open Office Calc Area


}
public function actionExportWordAnggSumbanganFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
  
        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(sumbangan.ID) AS Jumlah, 
                sumbangan.Jumlah AS sumbangan
                ".$andQuery."
                FROM sumbangan 
                LEFT JOIN members ON sumbangan.Member_id = members.ID 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.Code = members.UnitKerja_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(sumbangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Sumbangan Anggota '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 20px; margin-right: 20px;">
                <th>No.</th>
                <th>Periode</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Anggota</th>
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
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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

public function actionExportPdfAnggSumbanganFrekuensi()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(sumbangan.CreateDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }
  
        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(sumbangan.ID) AS Jumlah, 
                sumbangan.Jumlah AS sumbangan
                ".$andQuery."
                FROM sumbangan 
                LEFT JOIN members ON sumbangan.Member_id = members.ID 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN master_fakultas ON master_fakultas.id = members.Fakultas_id
                LEFT JOIN master_jurusan ON master_jurusan.id = members.Jurusan_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.Code = members.UnitKerja_id
                WHERE DATE(sumbangan.CreateDate) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(sumbangan.CreateDate,'%d-%m-%Y'), DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(sumbangan.CreateDate), subjek ORDER BY DATE_FORMAT(sumbangan.CreateDate,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $Berdasarkan = '';
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] = isset($_POST['kop']);

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
        $content = $this->renderPartial('pdf-view-sumbangan', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderPdfBebasPustaka() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(members.TanggalBebasPustaka) AS Jumlah
                ".$andQuery."
                FROM members 
                LEFT JOIN users ON users.ID = members.CreateBy 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.ID = users.Department_id
                WHERE DATE(members.TanggalBebasPustaka) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.TanggalBebasPustaka,'%d-%m-%Y'), DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                }

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
        $content['kop'] = isset($_POST['kop']);

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
            'content' => $this->renderPartial('pdf-view-bebas-pustaka', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelBebasPustakaFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(members.TanggalBebasPustaka) AS Jumlah
                ".$andQuery."
                FROM members 
                LEFT JOIN users ON users.ID = members.CreateBy 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.ID = users.Department_id
                WHERE DATE(members.TanggalBebasPustaka) "; 

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.TanggalBebasPustaka,'%d-%m-%Y'), DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Anggota Bebas Pustaka '.$periode2.'</th>
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
                <th>Periode Bebas Pustaka</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Anggota</th>
            </tr>
            ';
        $no = 1;
        $JumlahTerminalKomputer = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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
                            '.$JumlahTerminalKomputer.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtBebasPustakaFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(members.TanggalBebasPustaka) AS Jumlah
                ".$andQuery."
                FROM members 
                LEFT JOIN users ON users.ID = members.CreateBy 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.ID = users.Department_id
                WHERE DATE(members.TanggalBebasPustaka) "; 

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.TanggalBebasPustaka,'%d-%m-%Y'), DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'subjek'=>$model['subjek'], 'Jumlah'=>$model['Jumlah'] );
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
if (sizeof($_POST['kriterias']) == 1) {
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-bebas-pustaka-frekuensi.ods'; 
}else{
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-bebas-pustaka-frekuensi_no_subjek.ods'; 
}

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-bebas-pustaka-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordBebasPustakaFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(members.TanggalBebasPustaka) AS Jumlah
                ".$andQuery."
                FROM members 
                LEFT JOIN users ON users.ID = members.CreateBy 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.ID = users.Department_id
                WHERE DATE(members.TanggalBebasPustaka) "; 

        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.TanggalBebasPustaka,'%d-%m-%Y'), DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
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
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Anggota Bebas Pustaka '.$periode2.'</th>
            </tr>
            <tr>
                <th ';if (sizeof($_POST['kriterias']) !=1){echo 'colspan="3"';} else {echo 'colspan="4"';}echo '>Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 20px; margin-right: 20px;">
                <th>No.</th>
                <th>Periode Bebas Pustaka</th>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<th>'.$Berdasarkan.'</th>'; }
    echo'
                <th>Jumlah Anggota</th>
            </tr>
            ';
        $no = 1;
        $JumlahTerminalKomputer = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
    ';
    if (sizeof($_POST["kriterias"]) !=1) {
    }else
    { echo '<td>'.$data['subjek'].'</td>'; }
    echo'
                    <td>'.$data['Jumlah'].'</td>
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
                            '.$JumlahTerminalKomputer.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfBebasPustakaFrekuensi()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $andQuery = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= ' Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(members.TanggalBebasPustaka,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2= 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }


        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.addslashes($value).'" ';
                }
        $andQuery .= ", CONCAT(members.MemberNo, ' - ',members.Fullname) AS subjek"; 
            }
        }
        if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_pendidikan.Nama AS subjek"; 
        }
        if (isset($_POST['Fakultas'])) {
            foreach ($_POST['Fakultas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_fakultas.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_fakultas.Nama AS subjek"; 
        }
        if (isset($_POST['Jurusan'])) {
            foreach ($_POST['Jurusan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND master_jurusan.Nama = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", master_jurusan.Nama AS subjek"; 
        }
    
        if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND departments.ID = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        if (isset($_POST['Kelas'])) {
            foreach ($_POST['Kelas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND kelas_siswa.namakelassiswa = "'.addslashes($value).'" ';
                }
            }
        $andQuery .= ", kelas_siswa.namakelassiswa AS subjek"; 
        }

        $sql = "SELECT ".$periode_format.",
                COUNT(members.TanggalBebasPustaka) AS Jumlah
                ".$andQuery."
                FROM members 
                LEFT JOIN users ON users.ID = members.CreateBy 
                LEFT JOIN master_pendidikan ON master_pendidikan.id = members.EducationLevel_id
                LEFT JOIN kelas_siswa ON kelas_siswa.id = members.Kelas_id
                LEFT JOIN departments ON departments.ID = users.Department_id
                WHERE DATE(members.TanggalBebasPustaka) ";      
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(members.TanggalBebasPustaka,'%d-%m-%Y'), DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(members.TanggalBebasPustaka), subjek ORDER BY DATE_FORMAT(members.TanggalBebasPustaka,'%Y-%m-%d') DESC";
                }

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
        $content_kop['kop'] = isset($_POST['kop']);

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
        $content = $this->renderPartial('pdf-view-bebas-pustaka', $content);
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
                    UserName AS Kataloger,
                    modelhistory.type AS Kriteria,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    LEFT JOIN users ON modelhistory.user_id = users.ID
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'members' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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
    
    // print_r($a);
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
        // $content['isi_berdasarkan'] = $isi_kriteria;
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
            'content' => $this->renderPartial('pdf-view-kinerja-user', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=>$header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
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
                    UserName AS Kataloger,
                    modelhistory.type AS Kriteria,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    LEFT JOIN users ON modelhistory.user_id = users.ID
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'members' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Kataloger</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $totalJumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
                        $totalJumlah = $totalJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$totalJumlah.'
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
                    UserName AS Kataloger,
                    modelhistory.type AS Kriteria,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    LEFT JOIN users ON modelhistory.user_id = users.ID
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'members' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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

    $DetailFilterAction = $DetailFilter['action'];
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
        'DetailFilterAction'=>$DetailFilterAction,
        'DetailFilterKataloger'=>$DetailFilterKataloger,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/anggota/laporan-anggota-kinerja-user.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-anggota-kinerja-user-frekuensi.ods');
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
                    UserName AS Kataloger,
                    modelhistory.type AS Kriteria,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    LEFT JOIN users ON modelhistory.user_id = users.ID
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'members' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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
    echo '<table border="0" align="center" width="700"> 
               <p align="center"> <b>Laporan Frekuensi '.$format_hari.' </b></p>
               <p align="center"> <b>Kinerja User Pengembalian '.$periode2.' </b></p>
               <p align="center"> <b>'.$a.' '.$DetailFilter['action'].' '.$dan.' '.$DetailFilter['kataloger'].'</b></p>
            ';
    if ($type == 'odt') {
    echo '<table border="0" align="center" width="700"> ';
    }else{echo '<table border="1" align="center" width="700"> ';}
        echo '
                <tr>
                    <th>No.</th>
                    <th>Periode</th>
                    <th>Kataloger</th>
                    <th>jumlah</th>
                </tr>
            '; 
        $no = 1;
        $totalJumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Kataloger'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
                        $totalJumlah = $totalJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="3" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$totalJumlah.'
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
                    UserName AS Kataloger,
                    modelhistory.type AS Kriteria,
                    COUNT(modelhistory.ID) AS Jumlah 
                    FROM modelhistory 
                    LEFT JOIN users ON modelhistory.user_id = users.ID
                    WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'members' ";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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
    
    // print_r($a);
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
        $content = $this->renderPartial('pdf-view-kinerja-user', $content);
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
            $name = 'No Anggota';
        } 
        elseif ($kriterias == 'petugas_perpanjangan') 
        {
            $name = 'Petugas Perpanjangan';
        }
        elseif ($kriterias == 'Pekerjaan') 
        {
            $name = 'Pekerjaan';
        } 
        elseif ($kriterias == 'Pendidikan') 
        {
            $name = 'Pendidikan';
        }
        elseif ($kriterias == 'Status_Anggota') 
        {
            $name = 'Status Anggota';
        }
        elseif ($kriterias == 'unit_kerja') 
        {
            $name = 'Unit Kerja';
        }
        elseif ($kriterias == 'Jenis_Anggota') 
        {
            $name = 'Jenis Anggota';
        }
        elseif ($kriterias == 'nama_institusi') 
        {
            $name = 'Nama Institusi';
        }
        elseif ($kriterias == 'jenis_identitas') 
        {
            $name = 'Jenis Identitas';
        }
        elseif ($kriterias == 'kategori_koleksi') 
        {
            $name = 'Kategori Koleksi';
        }
        elseif ($kriterias == 'propinsi') 
        {
            $name = 'Propinsi';
        }
        elseif ($kriterias == 'jenis_kelamin') 
        {
            $name = 'Jenis Kelamin';
        }
        elseif ($kriterias == 'Kelas') 
        {
            $name = 'Kelas';
        }
        elseif ($kriterias == 'kabupaten') 
        {
            $name = 'Kabupaten / Kota';
        }
        elseif ($kriterias == 'Fakultas') 
        {
            $name = 'Fakultas';
        }
        elseif ($kriterias == 'Jurusan') 
        {
            $name = 'Jurusan';
        }
        elseif ($kriterias == 'data_entry') 
        {
            $name = 'Data Entri';
        }
        elseif ($kriterias == 'departments') 
        {
            $name = 'Unit Kerja';
        }
        elseif ($kriterias == 'range_umur') 
        {
            $name = 'Kelompok Umur';
        }
        else 
        {
            $name = ' ';
        }
        
        return $name;

    }
}
