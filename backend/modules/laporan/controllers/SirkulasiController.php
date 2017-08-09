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
use common\models\TujuanKunjungan;
use common\models\LocationLibrary;
use common\models\Locations;
use common\models\Members;
use common\models\MemberPerpanjangan;
use common\models\Users;
use common\models\JenisKelamin;
use common\models\Departments;
use common\models\Propinsi;
use common\models\VLapKriteriaAnggota;
use common\models\Collectioncategorys;
use common\models\Collectionsources;
use common\models\Collectionmedias;
use common\models\MasterJenisIdentitas;
use common\models\MasterRangeUmur;
use common\models\Masterkelasbesar;
use common\models\Kabupaten;
use common\models\Partners;
use common\models\JenisAnggota;
use common\models\Jenisdenda;
use common\models\Jenispelanggaran;
use common\models\Catalogs;

class SirkulasiController extends \yii\web\Controller
{
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLaporanPeminjaman()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('laporan-peminjaman',[
            'model' => $model,
            ]);
    }

    public function actionPerpanjanganPeminjaman()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('perpanjangan-peminjaman',[
            'model' => $model,
            ]);
    }

    public function actionSangsiPelanggaranPeminjaman()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('sangsi-pelanggaran-peminjaman',[
            'model' => $model,
            ]);
    }

    public function actionKoleksiSeringDipinjam()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('koleksi-sering-dipinjam',[
            'model' => $model,
            ]);
    }


    public function actionAnggotaSeringMeminjam()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('laporan-anggota-sering-meminjam',[
            'model' => $model,
            ]);
    }


    public function actionKinerjaUserPeminjaman()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('kinerja-user-peminjaman',[
            'model' => $model,
            ]);
    }
    public function actionKinerjaUserPengembalian()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('kinerja-user-pengembalian',[
            'model' => $model,
            ]);
    }
    public function actionPengembalianTerlambat()
    {

        $model = array();

        unset($_SESSION['Array_POST_Filter']);

        return $this->render('pengembalian-terlambat',[
            'model' => $model,
            ]);
    }
    

    public function actionLoadFilterKriteriaDipinjam($kriteria)
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

        else if ($kriteria == 'Subject')
        {
            $sql = 'SELECT * FROM catalogs';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Subject');
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

        else if ($kriteria == 'locations')
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
            //var_dump($options2);
        }

        else if ($kriteria == 'collectionsources')
        {
            $options =  ArrayHelper::map(Collectionsources::find()->orderBy('ID')->asArray()->all(),'ID',
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
            //var_dump($options2);
        }

        else if ($kriteria == 'partners')
        {
            $options =  ArrayHelper::map(Partners::find()->orderBy('ID')->asArray()->all(),'ID',
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
            //var_dump($options2);
        }

        else if ($kriteria == 'currency')
        {
            $sql = 'SELECT * FROM currency';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'Currency',
                function($model) {
                    return $model['Currency'].' - '.$model['Description'];
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
        else
        {
            $contentOptions = null;
        }
        return $contentOptions;
        
    }


    public function actionLoadFilterKriteria($kriteria)
    {
        if ($kriteria !== 'range_umur' && $kriteria !== 'jenis_kelamin' && $kriteria !== 'propinsi' && $kriteria !== 'Petugas_perpanjangan' 
            && $kriteria !== 'propinsi2' && $kriteria !== 'lokasi_pinjam' && $kriteria !== 'kategori_koleksi' 
            && $kriteria !== 'jenis_identitas' && $kriteria !=='kabupaten' && $kriteria !=='kabupaten2' 
            && $kriteria !=='data_entry' && $kriteria !== 'nama_institusi' && $kriteria !== 'Partners' && $kriteria !== 'jenis_sumber'
            && $kriteria !=='bentuk_fisik' && $kriteria !=='' && $kriteria !=='subjek' && $kriteria !=='peminjam_terbanyak' 
            && $kriteria !=='denda' && $kriteria !=='pelanggaran' && $kriteria !=='Kelas_dcc' && $kriteria !=='kataloger'
            && $kriteria !=='kriteria' && $kriteria !=='unit_kerja' && $kriteria !=='anggota' && $kriteria !=='penginput_data'
            && $kriteria !=='tanggal_akhir_berlaku' && $kriteria !=='no_anggota' && $kriteria !=='tujuan' && $kriteria !=='tujuan2'
            ) 
        {   
            $options = ArrayHelper::map(VLapKriteriaAnggota::find()->where(['kriteria'=>$kriteria])->all(),'id_dtl_anggota','dtl_anggota'); 
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
            );
        } 
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
        else if ($kriteria == 'jenis_kelamin')
        {
            $options =  ArrayHelper::map(JenisKelamin::find()->orderBy('ID')->asArray()->all(),'ID',
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

        else if ($kriteria == 'kategori_koleksi')
        {
            $options =  ArrayHelper::map(Collectioncategorys::find()->orderBy('ID')->asArray()->all(),'ID',
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
            //var_dump($options2);
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
        else if ($kriteria == 'jenis_sumber')
        {
            $options =  ArrayHelper::map(Collectionsources::find()->orderBy('ID')->asArray()->all(),'ID', 'Name');
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'Partners')
        {
            $options =  ArrayHelper::map(Partners::find()->orderBy('ID')->asArray()->all(),'ID',
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
        else if ($kriteria == 'bentuk_fisik')
        {
            $options =  ArrayHelper::map(Collectionmedias::find()->orderBy('ID')->asArray()->all(),'ID', 'Name');
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }
        else if ($kriteria == 'denda')
        {
            $options =  ArrayHelper::map(Jenisdenda::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Name'];
                });
            
            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'Kelas_dcc')
        {
            $options =  ArrayHelper::map(Masterkelasbesar::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['namakelas'];
                });
            array_unshift( $options, "---Semua---");

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'pelanggaran')
        {
            $options =  ArrayHelper::map(Jenispelanggaran::find()->orderBy('ID')->asArray()->all(),'ID',
                function($model) {
                    return $model['Keterangan'];
                });

            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'anggota')
        {
            $sql = 'SELECT * FROM members';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','Fullname');
            asort($options);
            $options = array_filter($options);
            $options2 = \yii\helpers\ArrayHelper::merge(["0"=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
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

        else if ($kriteria == 'kriteria')
        {

            $options = ['0' => 'Cantuman bibliografi (katalog) Dibuat','2' => 'Cantuman bibliografi (katalog) Dihapus'];
           
            $options2 = \yii\helpers\ArrayHelper::merge([""=>"---Semua---"],$options);
            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options2, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'kataloger')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','username');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'penginput_data')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID','username');
            $options[0] = " ---Semua---";
            asort($options);
            $options = array_filter($options);

            $contentOptions = Html::dropDownList( $kriteria.'[]',
                'selected option',  
                $options, 
                ['class' => 'select2 col-sm-6',]
                );
        }

        else if ($kriteria == 'tujuan')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['username'].' - '.$model['Fullname'];
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

        else if ($kriteria == 'Petugas_perpanjangan')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['username'].' - '.$model['Fullname'];
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

        else if ($kriteria == 'tujuan2')
        {
            $sql = 'SELECT * FROM users';
            $data = Yii::$app->db->createCommand($sql)->queryAll(); 
            $options = ArrayHelper::map($data,'ID',
                function($model) {
                    return $model['username'].' - '.$model['Fullname'];
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
        else if ($kriteria == 'tanggal_akhir_berlaku')
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
     
    public function actionLoadSelecterLaporanPeminjaman($i)
    {
        return $this->renderPartial('select-laporan-peminjaman',['i'=>$i]);
    }
    public function actionLoadSelecterLaporanDipinjam($i)
    {
        return $this->renderPartial('select-laporan-dipinjam',['i'=>$i]);
    }
    public function actionLoadSelecterPerpanjanganPeminjaman($i)
    {
        return $this->renderPartial('select-perpanjangan-peminjaman',['i'=>$i]);
    }
    public function actionLoadSelecterSangsiPelanggaranPeminjaman($i)
    {
        return $this->renderPartial('select-sangsi-pelanggaran-peminjaman',['i'=>$i]);
    }
    public function actionLoadSelecterAnggotaSeringMeminjam($i)
    {
        return $this->renderPartial('select-anggota-sering-meminjam',['i'=>$i]);
    }

    public function actionLoadSelecterPeminjamanKriteria($i)
    {
        return $this->renderPartial('select-peminjaman-kriteria',['i'=>$i]);
    }
    public function actionLoadSelecterKriteriaAnggota($i)
    {
        return $this->renderPartial('select-kriteria-anggota',['i'=>$i]);
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
        if ($tampilkan == 'laporan-peminjaman-frekuensi')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-laporan-peminjaman-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }elseif ($tampilkan == 'laporan-peminjaman-data')
        {
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-laporan-peminjaman-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }
        elseif ($tampilkan == 'perpanjangan-peminjaman-frekuensi')
        {         
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-perpanjangan-peminjaman-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );    
        }
        elseif ($tampilkan == 'perpanjangan-peminjaman-data')
        {
             echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-perpanjangan-peminjaman-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );  
        }
        elseif ($tampilkan == 'sangsi-pelanggaran-peminjaman-frekuensi')
        {         
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-sangsi-pelanggaran-peminjaman-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );    
        }
        elseif ($tampilkan == 'sangsi-pelanggaran-peminjaman-data')
        {         
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-sangsi-pelanggaran-peminjaman-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );    
        }
        if ($tampilkan == 'koleksi-sering-dipinjam-frekuensi')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-koleksi-sering-dipinjam-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'koleksi-sering-dipinjam-data')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-koleksi-sering-dipinjam-data').'">';
            echo "<iframe>";
        }
        elseif ($tampilkan == 'anggota-sering-meminjam-frekuensi')
        {         
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-anggota-sering-meminjam-frekuensi').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );    
        }
        elseif ($tampilkan == 'anggota-sering-meminjam-data')
        {         
            echo (count(array_filter($_POST['kriterias'])) != 0 ? 
                '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-anggota-sering-meminjam-data').'">'."<iframe>"
                :"<script>swal('Pilih kriteria terlebih dahulu');</script>"
            );    
        }

        if ($tampilkan == 'kinerja-user-peminjaman-frekuensi')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-peminjaman-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'kinerja-user-peminjaman-data')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-peminjaman-data').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'kinerja-user-pengembalian-frekuensi')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-pengembalian-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'kinerja-user-pengembalian-data')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-kinerja-user-pengembalian-data').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'pengembalian-terlambat-frekuensi')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pengembalian-terlambat-frekuensi').'">';
            echo "<iframe>";
        }
        if ($tampilkan == 'pengembalian-terlambat-data')
        {            
            echo '<script>$("#export").show();</script><iframe class="col-sm-12" style="height: 500px; padding: 0;" src="'.Url::to('render-pengembalian-terlambat-data').'">';
            echo "<iframe>";
        }
    }

public function actionRenderLaporanPeminjamanData() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $join = '';
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
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.$value.'" ';
                    }
                }
            }

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            } 

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

    //===============================================================================================
            
            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '%".$Plocation->Publisher."%' ";
            //         }
            //     }
            // }
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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN locations on locations.LocationLibrary = location_library.ID
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }



                
           $sql = "SELECT 
                    collectionloanitems.LoanDate AS TglPinjam,
                    collectionloanitems.DueDate AS TglJatuhTempo,
                    collectionloanitems.ActualReturn AS TglDikembalikan,
                    CASE
                     WHEN collectionloanitems.ActualReturn IS NULL THEN DATEDIFF(CURDATE(),collectionloanitems.DueDate)
                     ELSE '0'
                    END AS JumlahHariTelat,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.CreateBy = users.ID) AS PetugasPeminjaman,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.UpdateBy = users.ID) AS PetugasPengembalian 
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1)
                    ".$join."

                    WHERE DATE(collectionloanitems.LoanDate) ";
                    // LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    // LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID 
                    // LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    // LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    // LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID 
                    // LEFT JOIN master_fakultas ON members.Fakultas_id = master_fakultas.ID 
                    // LEFT JOIN master_jurusan ON members.Jurusan_id = master_jurusan.ID 
                    // LEFT JOIN kelas_siswa ON members.Kelas_id = kelas_siswa.ID 
                    // LEFT JOIN status_anggota ON members.StatusAnggota_id = status_anggota.ID
                    // LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_ID = members.ID 
                    // LEFT JOIN collectioncategorys ON memberloanauthorizecategory.CategoryLoan_id = collectioncategorys.ID 
                    // LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                    // LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate, members.FullName ';

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
        // print_r($sql);
        // die;

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
            'content' => $this->renderPartial('pdf-view-laporan-peminjaman-data', $content),
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

public function actionExportExcelLaporanPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $join = '';
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
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.$value.'" ';
                    }
                }
            }

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            } 

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

    //===============================================================================================
            
            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '%".$Plocation->Publisher."%' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN locations on locations.LocationLibrary = location_library.ID
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }



                
           $sql = "SELECT 
                    collectionloanitems.LoanDate AS TglPinjam,
                    collectionloanitems.DueDate AS TglJatuhTempo,
                    collectionloanitems.ActualReturn AS TglDikembalikan,
                    CASE
                     WHEN collectionloanitems.ActualReturn IS NULL THEN DATEDIFF(CURDATE(),collectionloanitems.DueDate)
                     ELSE '0'
                    END AS JumlahHariTelat,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.CreateBy = users.ID) AS PetugasPeminjaman,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.UpdateBy = users.ID) AS PetugasPengembalian 
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1)
                    ".$join."

                    WHERE DATE(collectionloanitems.LoanDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate, members.FullName';

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
                <th colspan="11">Sirkulasi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="11">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Jumlah Hari Telat</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Nama Petugas</th>
                <th>Nama Petugas Pengambilan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['TglJatuhTempo'].'</td>
                    <td>'.$data['TglDikembalikan'].'</td>
                    <td>'.$data['JumlahHariTelat'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['PetugasPeminjaman'].'</td>
                    <td>'.$data['PetugasPengembalian'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtLaporanPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $join = '';
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
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.$value.'" ';
                    }
                }
            }

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            } 

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

    //===============================================================================================
            
            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '%".$Plocation->Publisher."%' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN locations on locations.LocationLibrary = location_library.ID
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

                
           $sql = "SELECT 
                    collectionloanitems.LoanDate AS TglPinjam,
                    collectionloanitems.DueDate AS TglJatuhTempo,
                    collectionloanitems.ActualReturn AS TglDikembalikan,
                    CASE
                     WHEN collectionloanitems.ActualReturn IS NULL THEN DATEDIFF(CURDATE(),collectionloanitems.DueDate)
                     ELSE '0'
                    END AS JumlahHariTelat,
                    collections.NoInduk AS no_induk,
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
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.CreateBy = users.ID) AS PetugasPeminjaman,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.UpdateBy = users.ID) AS PetugasPengembalian 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1)
                    ".$join."

                    WHERE DATE(collectionloanitems.LoanDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate, members.FullName';

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
        $data[] = array('no'=> $no++,'TglPinjam'=> $model['TglPinjam'], 'TglJatuhTempo'=>$model['TglJatuhTempo'], 'TglDikembalikan'=>$model['TglDikembalikan'], 'JumlahHariTelat'=>$model['JumlahHariTelat'], 'no_induk'=>$model['no_induk']
                        , 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3'], 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'NoAnggota'=>$model['NoAnggota']
                        , 'NamaAnggota'=>$model['NamaAnggota'], 'PetugasPeminjaman'=>$model['PetugasPeminjaman'], 'PetugasPengembalian'=>$model['PetugasPengembalian']);
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-laporan-peminjaman-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-prminjaman-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordLaporanPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $join = '';
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
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.$value.'" ';
                    }
                }
            }

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            } 

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

    //===============================================================================================
            
            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '%".$Plocation->Publisher."%' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN locations on locations.LocationLibrary = location_library.ID
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }



                
           $sql = "SELECT 
                    collectionloanitems.LoanDate AS TglPinjam,
                    collectionloanitems.DueDate AS TglJatuhTempo,
                    collectionloanitems.ActualReturn AS TglDikembalikan,
                    CASE
                     WHEN collectionloanitems.ActualReturn IS NULL THEN DATEDIFF(CURDATE(),collectionloanitems.DueDate)
                     ELSE '0'
                    END AS JumlahHariTelat,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.CreateBy = users.ID) AS PetugasPeminjaman,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.UpdateBy = users.ID) AS PetugasPengembalian 
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1)
                    ".$join."

                    WHERE DATE(collectionloanitems.LoanDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate, members.FullName';

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
                <th colspan="11">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="11">Sirkulasi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="11">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Jumlah Hari Telat</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Nama Petugas</th>
                <th>Nama Petugas Pengambilan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['TglJatuhTempo'].'</td>
                    <td>'.$data['TglDikembalikan'].'</td>
                    <td>'.$data['JumlahHariTelat'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['PetugasPeminjaman'].'</td>
                    <td>'.$data['PetugasPengembalian'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfLaporanPeminjamanData()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $join = '';
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
            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.ID = "'.$value.'" ';
                    }
                }
            }

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id  = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            } 

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

    //===============================================================================================
            
            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '%".$Plocation->Publisher."%' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            $join .= ' LEFT JOIN locations on locations.LocationLibrary = location_library.ID
                       LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID ';
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }



                
           $sql = "SELECT 
                    collectionloanitems.LoanDate AS TglPinjam,
                    collectionloanitems.DueDate AS TglJatuhTempo,
                    collectionloanitems.ActualReturn AS TglDikembalikan,
                    CASE
                     WHEN collectionloanitems.ActualReturn IS NULL THEN DATEDIFF(CURDATE(),collectionloanitems.DueDate)
                     ELSE '0'
                    END AS JumlahHariTelat,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.CreateBy = users.ID) AS PetugasPeminjaman,
                    (SELECT users.FullName FROM users WHERE collectionloanitems.UpdateBy = users.ID) AS PetugasPengembalian 
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1)
                    ".$join."

                    WHERE DATE(collectionloanitems.LoanDate) ";
                    // LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    // LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID 
                    // LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    // LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    // LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID 
                    // LEFT JOIN master_fakultas ON members.Fakultas_id = master_fakultas.ID 
                    // LEFT JOIN master_jurusan ON members.Jurusan_id = master_jurusan.ID 
                    // LEFT JOIN kelas_siswa ON members.Kelas_id = kelas_siswa.ID 
                    // LEFT JOIN status_anggota ON members.StatusAnggota_id = status_anggota.ID
                    // LEFT JOIN memberloanauthorizecategory ON memberloanauthorizecategory.Member_ID = members.ID 
                    // LEFT JOIN collectioncategorys ON memberloanauthorizecategory.CategoryLoan_id = collectioncategorys.ID 
                    // LEFT JOIN memberloanauthorizelocation ON memberloanauthorizelocation.Member_ID = members.ID 
                    // LEFT JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate, members.FullName';

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
        // print_r($sql);
        // die;

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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-laporan-peminjaman-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }


public function actionRenderPerpanjanganPeminjamanData() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
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
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['tujuan'])) {
        foreach ($_POST['tujuan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanextends.DateExtend,'%d-%M-%Y') AS TanggalPerpanjangan,
                DATE_FORMAT(collectionloanextends.DueDateExtend,'%d-%M-%Y') AS TanggalJatuhTempo,
                DATE_FORMAT(collectionloanextends.CreateDate,'%d-%M-%Y') AS TanggalDikembalikan,
                collections.NoInduk AS no_induk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                members.MemberNo AS NoAnggota,
                members.FullName AS NamaAnggota,
                (SELECT FullName FROM users WHERE users.ID = collectionloanextends.CreateBy) AS Petugas 
                FROM collectionloanextends 
                INNER JOIN members ON collectionloanextends.Member_id = members.ID 
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanextends.DateExtend ';
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
            'content' => $this->renderPartial('pdf-view-perpanjangan-peminjaman-data', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px; ">Page {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();

    }

public function actionExportExcelPerpanjanganPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
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
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['tujuan'])) {
        foreach ($_POST['tujuan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanextends.DateExtend,'%d-%M-%Y') AS TanggalPerpanjangan,
                DATE_FORMAT(collectionloanextends.DueDateExtend,'%d-%M-%Y') AS TanggalJatuhTempo,
                DATE_FORMAT(collectionloanextends.CreateDate,'%d-%M-%Y') AS TanggalDikembalikan,
                collections.NoInduk AS no_induk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                members.MemberNo AS NoAnggota,
                members.FullName AS NamaAnggota,
                (SELECT FullName FROM users WHERE users.ID = collectionloanextends.CreateBy) AS Petugas 
                FROM collectionloanextends 
                INNER JOIN members ON collectionloanextends.Member_id = members.ID 
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanextends.DateExtend ';

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
                <th colspan="9">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="9">Transaksi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="9">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Perpanjangan</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama anggota</th>
                <th>Petugas Perpanjangan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPerpanjangan'].'</td>
                    <td>'.$data['TanggalJatuhTempo'].'</td>
                    <td>'.$data['TanggalDikembalikan'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['Petugas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtPerpanjanganPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
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
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['tujuan'])) {
        foreach ($_POST['tujuan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanextends.DateExtend,'%d-%M-%Y') AS TanggalPerpanjangan,
                DATE_FORMAT(collectionloanextends.DueDateExtend,'%d-%M-%Y') AS TanggalJatuhTempo,
                DATE_FORMAT(collectionloanextends.CreateDate,'%d-%M-%Y') AS TanggalDikembalikan,
                collections.NoInduk AS no_induk, 
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
                members.MemberNo AS NoAnggota,
                members.FullName AS NamaAnggota,
                (SELECT FullName FROM users WHERE users.ID = collectionloanextends.CreateBy) AS Petugas 
                FROM collectionloanextends 
                INNER JOIN members ON collectionloanextends.Member_id = members.ID 
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanextends.DateExtend ';

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
        $data[] = array('no'=> $no++,'TanggalPerpanjangan'=> $model['TanggalPerpanjangan'], 'TanggalJatuhTempo'=>$model['TanggalJatuhTempo'], 'TanggalDikembalikan'=>$model['TanggalDikembalikan'], 'no_induk'=>$model['no_induk'], 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3']
                         , 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'NoAnggota'=>$model['NoAnggota'], 'NamaAnggota'=>$model['NamaAnggota'], 'Petugas'=>$model['Petugas'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-laporan-peminjaman-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-perpanjangan-peminjaman-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordPerpanjanganPeminjamanData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
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
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['tujuan'])) {
        foreach ($_POST['tujuan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanextends.DateExtend,'%d-%M-%Y') AS TanggalPerpanjangan,
                DATE_FORMAT(collectionloanextends.DueDateExtend,'%d-%M-%Y') AS TanggalJatuhTempo,
                DATE_FORMAT(collectionloanextends.CreateDate,'%d-%M-%Y') AS TanggalDikembalikan,
                collections.NoInduk AS no_induk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                members.MemberNo AS NoAnggota,
                members.FullName AS NamaAnggota,
                (SELECT FullName FROM users WHERE users.ID = collectionloanextends.CreateBy) AS Petugas 
                FROM collectionloanextends 
                INNER JOIN members ON collectionloanextends.Member_id = members.ID 
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanextends.DateExtend ';

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
                <th colspan="9">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="9">Transaksi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="9">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Perpanjangan</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama anggota</th>
                <th>Petugas Perpanjangan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TanggalPerpanjangan'].'</td>
                    <td>'.$data['TanggalJatuhTempo'].'</td>
                    <td>'.$data['TanggalDikembalikan'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['Petugas'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfPerpanjanganPeminjamanData()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
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
                $periode = 'Bulanan'.', periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan'.', periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['tujuan'])) {
        foreach ($_POST['tujuan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanextends.DateExtend,'%d-%M-%Y') AS TanggalPerpanjangan,
                DATE_FORMAT(collectionloanextends.DueDateExtend,'%d-%M-%Y') AS TanggalJatuhTempo,
                DATE_FORMAT(collectionloanextends.CreateDate,'%d-%M-%Y') AS TanggalDikembalikan,
                collections.NoInduk AS no_induk, 
                CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                members.MemberNo AS NoAnggota,
                members.FullName AS NamaAnggota,
                (SELECT FullName FROM users WHERE users.ID = collectionloanextends.CreateBy) AS Petugas 
                FROM collectionloanextends 
                INNER JOIN members ON collectionloanextends.Member_id = members.ID 
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID 
                INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;

        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanextends.DateExtend ';
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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-perpanjangan-peminjaman-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }


public function actionRenderSangsiPelanggaranPeminjamanData() 
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

            $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglPinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d-%M-%Y') AS TglJatuhTempo,
                    DATE_FORMAT(collectionloanitems.UpdateDate,'%d-%M-%Y') AS TglDikembalikan,
                    CAST((CASE WHEN ActualReturn IS NOT NULL THEN (CASE WHEN @BedaHari > 0 THEN @BedaHari ELSE 0 END) ELSE (CASE WHEN @BedaHari2 > 0 THEN @BedaHari2 ELSE 0 END) END) AS CHAR(50)) AS JumlahHariTelat,
                    jenis_pelanggaran.JenisPelanggaran as jenis_pelanggaran,
                    pelanggaran.JumlahDenda AS DendaUang,
                    pelanggaran.JumlahSuspend AS Skorsing,
                    collections.NoInduk AS no_induk, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    users.username AS PetugasPeminjaman, 
                    users.username AS PetugasPengembalian  
                    FROM pelanggaran 
                    LEFT JOIN jenis_pelanggaran ON pelanggaran.JenisPelanggaran_id = pelanggaran.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= ' ORDER BY collectionloanitems.LoanDate';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        $Berdasarkan = '';
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan .= $this->getRealNameKriteria($value).' ';
        }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content['kop'] = isset($_POST['kop']);

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
            'marginLeft' =>0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-sangsi-pelanggaran-peminjaman-data', $content),
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

public function actionExportExcelSangsiPelanggaranPeminjamanData()
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

            $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglPinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d-%M-%Y') AS TglJatuhTempo,
                    DATE_FORMAT(collectionloanitems.UpdateDate,'%d-%M-%Y') AS TglDikembalikan,
                    CAST((CASE WHEN ActualReturn IS NOT NULL THEN (CASE WHEN @BedaHari > 0 THEN @BedaHari ELSE 0 END) ELSE (CASE WHEN @BedaHari2 > 0 THEN @BedaHari2 ELSE 0 END) END) AS CHAR(50)) AS JumlahHariTelat,
                    jenis_pelanggaran.JenisPelanggaran as jenis_pelanggaran,
                    pelanggaran.JumlahDenda AS DendaUang,
                    pelanggaran.JumlahSuspend AS Skorsing,
                    collections.NoInduk AS no_induk, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    users.username AS PetugasPeminjaman, 
                    users.username AS PetugasPengembalian  
                    FROM pelanggaran 
                    LEFT JOIN jenis_pelanggaran ON pelanggaran.JenisPelanggaran_id = pelanggaran.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate';

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
                <th colspan="14">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="14">Sangsi Pelanggaran Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="14">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Jumlah Hari Telat</th>
                <th>Jenis Pelanggaran</th>
                <th>Denda Uang</th>
                <th>Skorsing</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Data Bibliografis</th>
                <th>Nomer Induk</th>
                <th>Petugas Peminjaman</th>
                <th>Petugas Pengembalian</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['TglJatuhTempo'].'</td>
                    <td>'.$data['TglDikembalikan'].'</td>
                    <td>'.$data['JumlahHariTelat'].'</td>
                    <td>'.$data['jenis_pelanggaran'].'</td>
                    <td>'.$data['DendaUang'].'</td>
                    <td>'.$data['Skorsing'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['PetugasPeminjaman'].'</td>
                    <td>'.$data['PetugasPengembalian'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtSangsiPelanggaranPeminjamanData()
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

            $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglPinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d-%M-%Y') AS TglJatuhTempo,
                    DATE_FORMAT(collectionloanitems.UpdateDate,'%d-%M-%Y') AS TglDikembalikan,
                    CAST((CASE WHEN ActualReturn IS NOT NULL THEN (CASE WHEN @BedaHari > 0 THEN @BedaHari ELSE 0 END) ELSE (CASE WHEN @BedaHari2 > 0 THEN @BedaHari2 ELSE 0 END) END) AS CHAR(50)) AS JumlahHariTelat,
                    jenis_pelanggaran.JenisPelanggaran as jenis_pelanggaran,
                    pelanggaran.JumlahDenda AS DendaUang,
                    pelanggaran.JumlahSuspend AS Skorsing,
                    collections.NoInduk AS no_induk, 
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
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    users.username AS PetugasPeminjaman, 
                    users.username AS PetugasPengembalian  
                    FROM pelanggaran 
                    LEFT JOIN jenis_pelanggaran ON pelanggaran.JenisPelanggaran_id = pelanggaran.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate';

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
        $data[] = array('no'=> $no++,'TglPinjam'=> $model['TglPinjam'], 'TglJatuhTempo'=>$model['TglJatuhTempo'], 'TglDikembalikan'=>$model['TglDikembalikan'], 'JumlahHariTelat'=>$model['JumlahHariTelat'], 'jenis_pelanggaran'=>$model['jenis_pelanggaran'], 'DendaUang'=>$model['DendaUang'], 'Skorsing'=>$model['Skorsing'], 'no_induk'=>$model['no_induk'], 'data'=>$model['data']
                         , 'data2'=>$model['data2'], 'data3'=>$model['data3'], 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'NoAnggota'=>$model['NoAnggota'], 'NamaAnggota'=>$model['NamaAnggota'], 'PetugasPeminjaman'=>$model['PetugasPeminjaman'], 'PetugasPengembalian'=>$model['PetugasPengembalian'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-pelanggaran-peminjaman-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-pelanggaran-peminjaman-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordSangsiPelanggaranPeminjamanData()
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

            $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglPinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d-%M-%Y') AS TglJatuhTempo,
                    DATE_FORMAT(collectionloanitems.UpdateDate,'%d-%M-%Y') AS TglDikembalikan,
                    CAST((CASE WHEN ActualReturn IS NOT NULL THEN (CASE WHEN @BedaHari > 0 THEN @BedaHari ELSE 0 END) ELSE (CASE WHEN @BedaHari2 > 0 THEN @BedaHari2 ELSE 0 END) END) AS CHAR(50)) AS JumlahHariTelat,
                    jenis_pelanggaran.JenisPelanggaran as jenis_pelanggaran,
                    pelanggaran.JumlahDenda AS DendaUang,
                    pelanggaran.JumlahSuspend AS Skorsing,
                    collections.NoInduk AS no_induk, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    users.username AS PetugasPeminjaman, 
                    users.username AS PetugasPengembalian  
                    FROM pelanggaran 
                    LEFT JOIN jenis_pelanggaran ON pelanggaran.JenisPelanggaran_id = pelanggaran.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY collectionloanitems.LoanDate';

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
    // header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="14">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="14">Sangsi Pelanggaran Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="14">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Dikembalikan</th>
                <th>Jumlah Hari Telat</th>
                <th>Jenis Pelanggaran</th>
                <th>Denda Uang</th>
                <th>Skorsing</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Data Bibliografis</th>
                <th>Nomer Induk</th>
                <th>Petugas Peminjaman</th>
                <th>Petugas Pengembalian</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['TglJatuhTempo'].'</td>
                    <td>'.$data['TglDikembalikan'].'</td>
                    <td>'.$data['JumlahHariTelat'].'</td>
                    <td>'.$data['jenis_pelanggaran'].'</td>
                    <td>'.$data['DendaUang'].'</td>
                    <td>'.$data['Skorsing'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['PetugasPeminjaman'].'</td>
                    <td>'.$data['PetugasPengembalian'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfSangsiPelanggaranPeminjamanData()
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

            $sql = "SELECT @MemberID := members.id,DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglPinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d-%M-%Y') AS TglJatuhTempo,
                    DATE_FORMAT(collectionloanitems.UpdateDate,'%d-%M-%Y') AS TglDikembalikan,
                    CAST((CASE WHEN ActualReturn IS NOT NULL THEN (CASE WHEN @BedaHari > 0 THEN @BedaHari ELSE 0 END) ELSE (CASE WHEN @BedaHari2 > 0 THEN @BedaHari2 ELSE 0 END) END) AS CHAR(50)) AS JumlahHariTelat,
                    jenis_pelanggaran.JenisPelanggaran as jenis_pelanggaran,
                    pelanggaran.JumlahDenda AS DendaUang,
                    pelanggaran.JumlahSuspend AS Skorsing,
                    collections.NoInduk AS no_induk, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_ID <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    users.username AS PetugasPeminjaman, 
                    users.username AS PetugasPengembalian  
                    FROM pelanggaran 
                    LEFT JOIN jenis_pelanggaran ON pelanggaran.JenisPelanggaran_id = pelanggaran.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             $sql .= ' ORDER BY collectionloanitems.LoanDate';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        $Berdasarkan = '';
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan .= $this->getRealNameKriteria($value).' ';
        }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] = isset($_POST['kop']);

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-sangsi-pelanggaran-peminjaman-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderKoleksiSeringDipinjamData()
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
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglBaca, 
                    NoInduk AS NoInduk, 
                    CONCAT('',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib, 
                    members.MemberNo AS NoAnggota,
                    members.FullName AS Nama 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= " AND catalogs.id IN ( SELECT * FROM (SELECT collections.Catalog_id FROM collectionloanitems INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE DATE(collectionloanitems.LoanDate) ";
             $sql .= $sqlPeriode;
             $sql .= " GROUP BY collections.Catalog_id ORDER BY COUNT(*) DESC LIMIT ";
             $sql .= $inValue;
             $sql .= ") AS t) ORDER BY collectionloanitems.LoanDate LIMIT ";
             $sql .= $inValue;

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['inValue'] =  $inValue;  
        // $content['isi_berdasarkan'] = $isi_kriteria;
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
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-koleksi-sering-dipinjam-data', $content),
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

public function actionExportExcelKoleksiSeringDipinjamData()
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
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglBaca, 
                    NoInduk AS NoInduk, 
                    CONCAT('',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib, 
                    members.MemberNo AS NoAnggota,
                    members.FullName AS Nama 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= " AND catalogs.id IN ( SELECT * FROM (SELECT collections.Catalog_id FROM collectionloanitems INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE DATE(collectionloanitems.LoanDate) ";
             $sql .= $sqlPeriode;
             $sql .= " GROUP BY collections.Catalog_id ORDER BY COUNT(*) DESC LIMIT ";
             $sql .= $inValue;
             $sql .= ") AS t) ORDER BY collectionloanitems.LoanDate LIMIT ";
             $sql .= $inValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;

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
                <th colspan="6">Sering di Baca '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan Ranking '.$inValue.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Tanggal Baca</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Tamu / Anggota</th>
                <th>Nama</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglBaca'].'</td>
                    <td>'.$data['NoInduk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['Nama'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtKoleksiSeringDipinjamData()
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
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglBaca, 
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
                    members.MemberNo AS NoAnggota,
                    members.FullName AS Nama 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= " AND catalogs.id IN ( SELECT * FROM (SELECT collections.Catalog_id FROM collectionloanitems INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE DATE(collectionloanitems.LoanDate) ";
             $sql .= $sqlPeriode;
             $sql .= " GROUP BY collections.Catalog_id ORDER BY COUNT(*) DESC LIMIT ";
             $sql .= $inValue;
             $sql .= ") AS t) ORDER BY collectionloanitems.LoanDate LIMIT ";
             $sql .= $inValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan = $inValue;

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'TglBaca'=> $model['TglBaca'], 'NoInduk'=>$model['NoInduk'], 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3'], 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'NoAnggota'=>$model['NoAnggota'], 'Nama'=>$model['Nama'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-koleksi-sering-dipinjam-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-koleksi-sering-dipinjam-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKoleksiSeringDipinjamData()
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
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglBaca, 
                    NoInduk AS NoInduk, 
                    CONCAT('',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib, 
                    members.MemberNo AS NoAnggota,
                    members.FullName AS Nama 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= " AND catalogs.id IN ( SELECT * FROM (SELECT collections.Catalog_id FROM collectionloanitems INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE DATE(collectionloanitems.LoanDate) ";
             $sql .= $sqlPeriode;
             $sql .= " GROUP BY collections.Catalog_id ORDER BY COUNT(*) DESC LIMIT ";
             $sql .= $inValue;
             $sql .= ") AS t) ORDER BY collectionloanitems.LoanDate LIMIT ";
             $sql .= $inValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode;

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
                <th colspan="6">Sering di Baca '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan Ranking '.$inValue.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 10px; margin-left: 10px;">
                <th>No.</th>
                <th>Tanggal Baca</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Tamu / Anggota</th>
                <th>Nama</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglBaca'].'</td>
                    <td>'.$data['NoInduk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['Nama'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfKoleksiSeringDipinjamData()
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
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                // $dateObj = DateTime::createFromFormat('!m', $_POST['fromBulan']);
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT DATE_FORMAT(collectionloanitems.LoanDate,'%d-%M-%Y') AS TglBaca, 
                    NoInduk AS NoInduk, 
                    CONCAT('',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib, 
                    members.MemberNo AS NoAnggota,
                    members.FullName AS Nama 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= " AND catalogs.id IN ( SELECT * FROM (SELECT collections.Catalog_id FROM collectionloanitems INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE DATE(collectionloanitems.LoanDate) ";
             $sql .= $sqlPeriode;
             $sql .= " GROUP BY collections.Catalog_id ORDER BY COUNT(*) DESC LIMIT ";
             $sql .= $inValue;
             $sql .= ") AS t) ORDER BY collectionloanitems.LoanDate LIMIT ";
             $sql .= $inValue;

        
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['inValue'] =  $inValue;  
        // $content['isi_berdasarkan'] = $isi_kriteria;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            ]);

        $pdf = $pdf->api; // fetches mpdf api
        $content = $this->renderPartial('pdf-view-koleksi-sering-dipinjam-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderAnggotaSeringMeminjamData() 
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];
            $sql = "SELECT
                    collectionloanitems.LoanDate AS TglPinjam,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    jenis_kelamin.Name AS Gender,
                    CONCAT(members.PlaceOfBirth,', ',DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TempatTanggalLahir,
                    Umur(DateOfBirth) AS Umur,
                    members.Address AS Alamat,
                    members.City AS Kabupaten,
                    members.Province AS Propinsi,
                    members.Phone AS Telp,
                    members.Email AS email,
                    jenis_anggota.jenisanggota AS jenis_anggota,
                    master_pekerjaan.Pekerjaan AS pekerjaan,
                    master_pendidikan.Nama AS Pendidikan
                    FROM
                    collectionloanitems
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY members.FullName LIMIT ';
        $sql .= $inValue;

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
            'content' => $this->renderPartial('pdf-view-anggota-sering-meminjam-data', $content),
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

public function actionExportExcelAnggotaSeringMeminjamData()
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];
            $sql = "SELECT
                    collectionloanitems.LoanDate AS TglPinjam,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    jenis_kelamin.Name AS Gender,
                    CONCAT(members.PlaceOfBirth,', ',DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TempatTanggalLahir,
                    Umur(DateOfBirth) AS Umur,
                    members.Address AS Alamat,
                    members.City AS Kabupaten,
                    members.Province AS Propinsi,
                    members.Phone AS Telp,
                    members.Email AS email,
                    jenis_anggota.jenisanggota AS jenis_anggota,
                    master_pekerjaan.Pekerjaan AS pekerjaan,
                    master_pendidikan.Nama AS Pendidikan
                    FROM
                    collectionloanitems
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY members.FullName LIMIT ';
        $sql .= $inValue;

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
                <th colspan="6">Pemanfaatan OPAC '.$periode2.'</th>
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
                <th>Tanggal Pinjam</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Propinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['Gender'].'</td>
                    <td>'.$data['TempatTanggalLahir'].'</td>
                    <td>'.$data['Umur'].'</td>
                    <td>'.$data['Alamat'].'</td>
                    <td>'.$data['Kabupaten'].'</td>
                    <td>'.$data['Propinsi'].'</td>
                    <td>'.$data['Telp'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['Pendidikan'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtAnggotaSeringMeminjamData()
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
            $inValue = $_POST['rank'];
            $sql = "SELECT
                    collectionloanitems.LoanDate AS TglPinjam,
                    collections.NoInduk AS no_induk,
                    CONCAT(catalogs.Title,'') AS data, 
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
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    jenis_kelamin.Name AS Gender,
                    CONCAT(members.PlaceOfBirth,', ',DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TempatTanggalLahir,
                    Umur(DateOfBirth) AS Umur,
                    members.Address AS Alamat,
                    members.City AS Kabupaten,
                    members.Province AS Propinsi,
                    members.Phone AS Telp,
                    members.Email AS email,
                    jenis_anggota.jenisanggota AS jenis_anggota,
                    master_pekerjaan.Pekerjaan AS pekerjaan,
                    master_pendidikan.Nama AS Pendidikan
                    FROM
                    collectionloanitems
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY members.FullName LIMIT ';
        $sql .= $inValue;

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
        $data[] = array('no'=> $no++,'TglPinjam'=> $model['TglPinjam'], 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3'], 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'], 'no_induk'=>$model['no_induk'], 'NoAnggota'=>$model['NoAnggota'], 'NamaAnggota'=>$model['NamaAnggota'], 'Gender'=>$model['Gender']
                        , 'TempatTanggalLahir'=>$model['TempatTanggalLahir'], 'Umur'=>$model['Umur'], 'Alamat'=>$model['Alamat'], 'Kabupaten'=>$model['Kabupaten'], 'Propinsi'=>$model['Propinsi'], 'Telp'=>$model['Telp'], 'email'=>$model['email'], 'jenis_anggota'=>$model['jenis_anggota'], 'pekerjaan'=>$model['pekerjaan'], 'Pendidikan'=>$model['Pendidikan'] );
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

    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-anggota-sering-meminjam-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-anggota-sering-meminjam-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordAnggotaSeringMeminjamData()
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];
            $sql = "SELECT
                    collectionloanitems.LoanDate AS TglPinjam,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    jenis_kelamin.Name AS Gender,
                    CONCAT(members.PlaceOfBirth,', ',DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TempatTanggalLahir,
                    Umur(DateOfBirth) AS Umur,
                    members.Address AS Alamat,
                    members.City AS Kabupaten,
                    members.Province AS Propinsi,
                    members.Phone AS Telp,
                    members.Email AS email,
                    jenis_anggota.jenisanggota AS jenis_anggota,
                    master_pekerjaan.Pekerjaan AS pekerjaan,
                    master_pendidikan.Nama AS Pendidikan
                    FROM
                    collectionloanitems
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY members.FullName LIMIT ';
        $sql .= $inValue;

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
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th colspan="6">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Pemanfaatan OPAC '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 20px; margin-right: 20px;">
                <th>No.</th>
                <th>Tanggal Pinjam</th>
                <th>Nomer Induk</th>
                <th>Data Bibliografis</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Jenis Kelamin</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Propinsi</th>
                <th>Telpon</th>
                <th>Email</th>
                <th>Jenis Anggota</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['TglPinjam'].'</td>
                    <td>'.$data['no_induk'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['Gender'].'</td>
                    <td>'.$data['TempatTanggalLahir'].'</td>
                    <td>'.$data['Umur'].'</td>
                    <td>'.$data['Alamat'].'</td>
                    <td>'.$data['Kabupaten'].'</td>
                    <td>'.$data['Propinsi'].'</td>
                    <td>'.$data['Telp'].'</td>
                    <td>'.$data['email'].'</td>
                    <td>'.$data['jenis_anggota'].'</td>
                    <td>'.$data['pekerjaan'].'</td>
                    <td>'.$data['Pendidikan'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfAnggotaSeringMeminjamData()
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];
            $sql = "SELECT
                    collectionloanitems.LoanDate AS TglPinjam,
                    collections.NoInduk AS no_induk,
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib,
                    members.MemberNo AS NoAnggota,
                    members.FullName AS NamaAnggota,
                    jenis_kelamin.Name AS Gender,
                    CONCAT(members.PlaceOfBirth,', ',DATE_FORMAT(members.DateOfBirth,'%d-%m-%Y')) AS TempatTanggalLahir,
                    Umur(DateOfBirth) AS Umur,
                    members.Address AS Alamat,
                    members.City AS Kabupaten,
                    members.Province AS Propinsi,
                    members.Phone AS Telp,
                    members.Email AS email,
                    jenis_anggota.jenisanggota AS jenis_anggota,
                    master_pekerjaan.Pekerjaan AS pekerjaan,
                    master_pendidikan.Nama AS Pendidikan
                    FROM
                    collectionloanitems
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID 
                    INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID 
                    LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' ORDER BY members.FullName LIMIT ';
        $sql .= $inValue;

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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-anggota-sering-meminjam-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }

public function actionRenderKinerjaUserPeminjamanData() 
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
            'content' => $this->renderPartial('pdf-view-kinerja-user-peminjaman-data', $content),
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

public function actionExportExcelKinerjaUserPeminjamanData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
                <th colspan="5">Kinerja User Peminjaman '.$periode2.'</th>
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

public function actionExportExcelOdtKinerjaUserPeminjamanData()
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-kinerja-user-peminjaman-data.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-kinerja-user-peminjaman-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserPeminjamanData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
               <p align="center"> <b>Kinerja User Peminjaman '.$periode2.' </b></p>
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

public function actionExportPdfKinerjaUserPeminjamanData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
        $content = $this->renderPartial('pdf-view-kinerja-user-peminjaman-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderKinerjaUserPengembalianData() 
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
            'content' => $this->renderPartial('pdf-view-kinerja-user-pengembalian-data', $content),
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

public function actionExportExcelKinerjaUserPengembalianData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
                <th colspan="5">Kinerja User Pengembalian '.$periode2.'</th>
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

public function actionExportExcelOdtKinerjaUserPengembalianData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
                 END AS nama_kriteria, 
                (SELECT 
                CASE 
                 WHEN modelhistory.type = '2' THEN CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': Catalogs')
                 ELSE CONCAT(CASE WHEN modelhistory.type = '0' THEN 'menambahkan' WHEN modelhistory.type = '1' THEN 'mengedit' ELSE 'menghapus' END, ': ', 'Katalog'  )
                END
                ) AS actions,
                catalogs.Title AS title
                FROM modelhistory 
                LEFT JOIN users ON modelhistory.user_id = users.ID 
                LEFT JOIN catalogs ON catalogs.ID = modelhistory.field_id 
                WHERE DATE(modelhistory.date) ";
        
        $sql .= $sqlPeriode;
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-kinerja-user-pengembalian-data.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-kinerja-user-pengembalian-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserPengembalianData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
               <p align="center"> <b>Kinerja User Pengembalian '.$periode2.' </b></p>
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

public function actionExportPdfKinerjaUserPengembalianData()
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
                modelhistory.field_id AS f_id, 
                modelhistory.type AS kriteria, 
                CASE 
                 WHEN modelhistory.type = '0' THEN 'dibuat' 
                 WHEN modelhistory.type = '1' THEN 'diedit' 
                 ELSE 'di hapus' 
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
        $content = $this->renderPartial('pdf-view-kinerja-user-pengembalian-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderPengembalianTerlambatData() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    members.FullName AS Anggota, 
                    collections.NomorBarcode AS no_barcode, 
                    DATE_FORMAT(collectionloanitems.LoanDate,'%d/%m/%Y %h:%i %p') AS tgl_pinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d/%m/%Y %h:%i %p') AS tgl_tempo,
                    DATE_FORMAT(collectionloanitems.ActualReturn,'%d/%m/%Y %h:%i %p') AS tgl_pengembalian,
                    LateDays AS terlambat
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0 ORDER BY collectionloanitems.CreateDate';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
// print_r($sql);
// die;

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['test'] = $test;
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
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-pengembalian-terlambat-data', $content),
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

public function actionExportExcelPengembalianTerlambatData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    members.FullName AS Anggota, 
                    collections.NomorBarcode AS no_barcode, 
                    DATE_FORMAT(collectionloanitems.LoanDate,'%d/%m/%Y %h:%i %p') AS tgl_pinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d/%m/%Y %h:%i %p') AS tgl_tempo,
                    DATE_FORMAT(collectionloanitems.ActualReturn,'%d/%m/%Y %h:%i %p') AS tgl_pengembalian,
                    LateDays AS terlambat
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0 ORDER BY collectionloanitems.CreateDate';

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    

    $filename = 'Laporan_Periodik_Data.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center"> 
            <tr>
                <th colspan="8">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="8">Pengembalian Terlambat '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="8">Berdasarkan Anggota '.$test.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Anggota</th>
                <th>Nomer Barcode</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Hari Terlambat</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['no_barcode'].'</td>
                    <td>'.$data['tgl_pinjam'].'</td>
                    <td>'.$data['tgl_tempo'].'</td>
                    <td>'.$data['tgl_pengembalian'].'</td>
                    <td>'.$data['terlambat'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportExcelOdtPengembalianTerlambatData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    members.FullName AS Anggota, 
                    collections.NomorBarcode AS no_barcode, 
                    DATE_FORMAT(collectionloanitems.LoanDate,'%d/%m/%Y %h:%i %p') AS tgl_pinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d/%m/%Y %h:%i %p') AS tgl_tempo,
                    DATE_FORMAT(collectionloanitems.ActualReturn,'%d/%m/%Y %h:%i %p') AS tgl_pengembalian,
                    LateDays AS terlambat
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0 ORDER BY collectionloanitems.CreateDate';


    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Anggota'=>$model['Anggota'], 'no_barcode'=>$model['no_barcode'], 'tgl_pinjam'=>$model['tgl_pinjam'], 'tgl_tempo'=>$model['tgl_tempo'], 'tgl_pengembalian'=>$model['tgl_pengembalian'], 'terlambat'=>$model['terlambat'] );
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'test' => $test,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-pengembalian-terlambat-data.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-pengembalian-terlambat-data.ods');
    // !Open Office Calc Area


}

public function actionExportWordPengembalianTerlambatData()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    members.FullName AS Anggota, 
                    collections.NomorBarcode AS no_barcode, 
                    DATE_FORMAT(collectionloanitems.LoanDate,'%d/%m/%Y %h:%i %p') AS tgl_pinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d/%m/%Y %h:%i %p') AS tgl_tempo,
                    DATE_FORMAT(collectionloanitems.ActualReturn,'%d/%m/%Y %h:%i %p') AS tgl_pengembalian,
                    LateDays AS terlambat
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0 ORDER BY collectionloanitems.CreateDate';

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Data.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th colspan="8">Laporan Data '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="8">Pengembalian Terlambat '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="8">Berdasarkan Anggota '.$test.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Anggota</th>
                <th>Nomer Barcode</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Hari Terlambat</th>
            </tr>
            ';
        $no = 1;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Anggota'].'</td>
                    <td>'.$data['no_barcode'].'</td>
                    <td>'.$data['tgl_pinjam'].'</td>
                    <td>'.$data['tgl_tempo'].'</td>
                    <td>'.$data['tgl_pengembalian'].'</td>
                    <td>'.$data['terlambat'].'</td>
                </tr>
            ';
        $no++;
        endforeach;
        
    echo '</table>';

}

public function actionExportPdfPengembalianTerlambatData() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    members.FullName AS Anggota, 
                    collections.NomorBarcode AS no_barcode, 
                    DATE_FORMAT(collectionloanitems.LoanDate,'%d/%m/%Y %h:%i %p') AS tgl_pinjam,
                    DATE_FORMAT(collectionloanitems.DueDate,'%d/%m/%Y %h:%i %p') AS tgl_tempo,
                    DATE_FORMAT(collectionloanitems.ActualReturn,'%d/%m/%Y %h:%i %p') AS tgl_pengembalian,
                    LateDays AS terlambat
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0 ORDER BY collectionloanitems.CreateDate';
        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
// print_r($sql);
// die;

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['test'] = $test;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 233; width: 100%;" >'];
            $set = 60;
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
        $content = $this->renderPartial('pdf-view-pengembalian-terlambat-data', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Data.pdf', 'D');

    }


// /////////////////////////////////batas view_data dgn view_vrekuensi//////////////////////////////////// //     
public function actionRenderLaporanPeminjamanFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }
    // ======================================== kriteria koleksi dipinjam =========================================



            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '".$Plocation->Publisher."' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN currency ON collections.Currency = currency.Currency ';
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $subjek .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

            
            $sql = "SELECT ".$periode_format.", 
                    members.FullName AS NamaAnggota,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    COUNT(DISTINCT collectionloanitems.ID) AS JumlahPeminjam,
                    COUNT(DISTINCT collections.ID) AS JumlahEksemplar
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON members.ID = collectionloanitems.member_id
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy
                    INNER JOIN memberloanauthorizelocation ON collectionloanitems.member_id = memberloanauthorizelocation.Member_id
                    INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                    INNER JOIN locations ON collections.Location_Id = locations.ID ";
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) ";       
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'),members.ID ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(sizeof(array_filter($_POST['kriterias'])) > 1 ) 
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);} 
        else
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode($Berdasarkan);}

        // print_r($Berdasarkan);
        // die;

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
            'content' => $this->renderPartial('pdf-view-laporan-peminjaman-frekuensi', $content),
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

public function actionExportExcelLaporanPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }
    // ======================================== kriteria koleksi dipinjam =========================================



            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '".$Plocation->Publisher."' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN currency ON collections.Currency = currency.Currency ';
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $subjek .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

            
            $sql = "SELECT ".$periode_format.", 
                    members.FullName AS NamaAnggota,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    COUNT(DISTINCT collectionloanitems.ID) AS JumlahPeminjam,
                    COUNT(DISTINCT collections.ID) AS JumlahEksemplar
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON members.ID = collectionloanitems.member_id
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy
                    INNER JOIN memberloanauthorizelocation ON collectionloanitems.member_id = memberloanauthorizelocation.Member_id
                    INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                    INNER JOIN locations ON collections.Location_Id = locations.ID ";
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) ";       
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'),members.ID ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    if(sizeof(array_filter($_POST['kriterias'])) > 1 ) 
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);} 
        else
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode($Berdasarkan);}

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
                <th colspan="5">Sirkulasi Peminjaman '.$periode2.'</th>
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
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
                <th>Jumlah Peminjam</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        $JumlahPeminjam = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                    <td>'.$data['JumlahPeminjam'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $JumlahPeminjam = $JumlahPeminjam + $data['JumlahPeminjam'];
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
                        <td style="font-weight: bold;">
                            '.$JumlahPeminjam.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtLaporanPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }
    // ======================================== kriteria koleksi dipinjam =========================================



            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '".$Plocation->Publisher."' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN currency ON collections.Currency = currency.Currency ';
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $subjek .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

            
            $sql = "SELECT ".$periode_format.", 
                    members.FullName AS NamaAnggota,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    COUNT(DISTINCT collectionloanitems.ID) AS JumlahPeminjam,
                    COUNT(DISTINCT collections.ID) AS JumlahEksemplar
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON members.ID = collectionloanitems.member_id
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy
                    INNER JOIN memberloanauthorizelocation ON collectionloanitems.member_id = memberloanauthorizelocation.Member_id
                    INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                    INNER JOIN locations ON collections.Location_Id = locations.ID ";
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) ";       
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'),members.ID ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
   if(sizeof(array_filter($_POST['kriterias'])) > 1 ) 
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);} 
        else
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode($Berdasarkan);}

    $headers = Yii::getAlias('@webroot','/teeeesst');


    // Open Office Calc Area
    $menu = 'Pemanfaatan Opac';

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'JumlahJudul'=>$model['JumlahJudul'], 'JumlahEksemplar'=>$model['JumlahEksemplar'], 'JumlahPeminjam'=>$model['JumlahPeminjam'] );
            $JumlahJudul = $JumlahJudul + $model['JumlahJudul'];
            $JumlahEksemplar = $JumlahEksemplar + $model['JumlahEksemplar'];
            $JumlahPeminjam = $JumlahPeminjam + $model['JumlahPeminjam'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlahJudul'=>$JumlahJudul,
        'TotalJumlahEksemplar'=>$JumlahEksemplar,
        'TotalJumlahPeminjam'=>$JumlahPeminjam,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-laporan-peminjaman-frekuensi.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-OPAC-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordLaporanPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }
    // ======================================== kriteria koleksi dipinjam =========================================



            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '".$Plocation->Publisher."' ";
            //         }
            //     }
            // }

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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN currency ON collections.Currency = currency.Currency ';
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $subjek .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

            
            $sql = "SELECT ".$periode_format.", 
                    members.FullName AS NamaAnggota,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    COUNT(DISTINCT collectionloanitems.ID) AS JumlahPeminjam,
                    COUNT(DISTINCT collections.ID) AS JumlahEksemplar
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON members.ID = collectionloanitems.member_id
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy
                    INNER JOIN memberloanauthorizelocation ON collectionloanitems.member_id = memberloanauthorizelocation.Member_id
                    INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                    INNER JOIN locations ON collections.Location_Id = locations.ID ";
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) ";       
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'),members.ID ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    if(sizeof(array_filter($_POST['kriterias'])) > 1 ) 
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);} 
        else
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode($Berdasarkan);}

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
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Sirkulasi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="5">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 10px; margin-right: 10px;">
                <th>No.</th>
                <th>Periode</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
                <th>Jumlah Peminjam</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        $JumlahPeminjam = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                    <td>'.$data['JumlahPeminjam'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $JumlahPeminjam = $JumlahPeminjam + $data['JumlahPeminjam'];
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
                        <td style="font-weight: bold;">
                            '.$JumlahPeminjam.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfLaporanPeminjamanFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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

            if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND members.CreateBy = '".addslashes($value)."' ";
                    }
                }
            }

            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }
    // ======================================== kriteria koleksi dipinjam =========================================



            if (isset($_POST['PublishLocation'])) {
            foreach ($_POST['PublishLocation'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND PublishLocation LIKE "%'.addslashes($value).'%" ';
                    }
                }
            } 

            // if (isset($_POST['Publisher'])) {
            // foreach ($_POST['Publisher'] as $key => $value) {
            //     if ($value != "0" ) {
            //          $Plocation = Catalogs::findOne(['ID' => $value]);
            //         $andValue .= " AND catalogs.Publisher LIKE '".$Plocation->Publisher."' ";
            //         }
            //     }
            // }


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
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.PublishYear LIKE '".$Plocation->PublishYear."' ";
                    }
                }
            }

            if (isset($_POST['location_library'])) {
            foreach ($_POST['location_library'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['locations'])) {
            foreach ($_POST['locations'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND locations.ID = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['collectionsources'])) {
            foreach ($_POST['collectionsources'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Source_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['partners'])) {
            foreach ($_POST['partners'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Partner_Id = "'.addslashes($value).'" ';
                    }
                }
            } 

            if (isset($_POST['currency'])) {
            foreach ($_POST['currency'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Currency = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN currency ON collections.Currency = currency.Currency ';
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
                }
            }

            if (isset($_POST['collectioncategorys'])) {
            foreach ($_POST['collectioncategorys'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Category_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectioncategorys ON collections.Category_Id = collectioncategorys.ID ';
            }

            if (isset($_POST['collectionrules'])) {
            foreach ($_POST['collectionrules'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Rule_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionrules ON collections.Rule_Id = collectionrules.ID ';
            }   

            if (isset($_POST['worksheets'])) {
            foreach ($_POST['worksheets'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND catalogs.Worksheet_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN worksheets ON catalogs.Worksheet_Id = worksheets.ID ';
            }

            if (isset($_POST['collectionmedias'])) {
            foreach ($_POST['collectionmedias'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND collections.Media_Id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= ' INNER JOIN collectionmedias ON collections.Media_Id = collectionmedias.ID ';
            }

            if (isset($_POST['Subject'])) {
            foreach ($_POST['Subject'] as $key => $value) {
                if ($value != "0" ) {
                    $Plocation = Catalogs::findOne(['ID' => $value]);
                    $andValue .= " AND catalogs.Subject LIKE '".$Plocation->Subject."' ";
                    }
                }
            }   

            if (isset($_POST['no_klas'])) {
            foreach ($_POST['no_klas'] as $key => $value) {
                if ($value != null ) {
                    $andValue .= " AND SUBSTR(catalogs.DeweyNo,1,1) BETWEEN '".addslashes($value)."' ";
                    }
                }
            $subjek .= 'INNER JOIN master_kelas_besar ON SUBSTR(catalogs.DeweyNo,1,1) = SUBSTR(master_kelas_besar.kdKelas,1,1) ';
            } 
            if (isset($_POST['tono_klas'])) {
                foreach ($_POST['tono_klas'] as $key => $value) {
                    if ($value != "0" ) {
                    $andValue .= " AND '".addslashes($value)."' ";
                    }
                }
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
        }

            
            $sql = "SELECT ".$periode_format.", 
                    members.FullName AS NamaAnggota,
                    COUNT(DISTINCT catalogs.ID) AS JumlahJudul,
                    COUNT(DISTINCT collectionloanitems.ID) AS JumlahPeminjam,
                    COUNT(DISTINCT collections.ID) AS JumlahEksemplar
                    FROM 
                    collectionloanitems
                    INNER JOIN collections ON collections.ID = collectionloanitems.Collection_id
                    INNER JOIN catalogs ON catalogs.ID = collections.Catalog_id
                    INNER JOIN members ON members.ID = collectionloanitems.member_id
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy
                    INNER JOIN memberloanauthorizelocation ON collectionloanitems.member_id = memberloanauthorizelocation.Member_id
                    INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                    INNER JOIN locations ON collections.Location_Id = locations.ID ";
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) ";       
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'),members.ID ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate) ORDER BY DATE_FORMAT(collectionloanitems.LoanDate,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(sizeof(array_filter($_POST['kriterias'])) > 1 ) 
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode(' dan ', $Berdasarkan);} 
        else
        {$Berdasarkan = array();
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan[] .= $this->getRealNameKriteria($value).' ';
        }
        $Berdasarkan = implode($Berdasarkan);}

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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-laporan-peminjaman-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderPerpanjanganPeminjamanFrekuensi() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%Y") Periode';
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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['Petugas_perpanjangan'])) {
        foreach ($_POST['Petugas_perpanjangan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT ".$periode_format.", 
                COUNT(*) AS JumlahEksemplar, 
                '' AS Kriteria, 
                COUNT(DISTINCT collections.Catalog_ID) AS JumlahJudul 
                FROM collectionloanextends  
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID  
                INNER JOIN members ON collectionloanextends.Member_Id = members.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanextends.DateExtend,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
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
            'content' => $this->renderPartial('pdf-view-perpanjangan-peminjaman-frekuensi', $content),
            'options' => [
            'title' => 'Laporan Data',
            'subject' => 'Perpustakaan Nasional Republik Indonesia'],
            'methods' => [ 
                'SetHeader'=> $header,
                'SetFooter'=>['<div class="footer" style="margin-right:60px;">Halaman {PAGENO}</div>'],
            ],
            ]);
        return $pdf->render();
        
    }

public function actionExportExcelPerpanjanganPeminjamanFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%Y") Periode';
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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['Petugas_perpanjangan'])) {
        foreach ($_POST['Petugas_perpanjangan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT ".$periode_format.", 
                COUNT(*) AS JumlahEksemplar, 
                '' AS Kriteria, 
                COUNT(DISTINCT collections.Catalog_ID) AS JumlahJudul 
                FROM collectionloanextends  
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID  
                INNER JOIN members ON collectionloanextends.Member_Id = members.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanextends.DateExtend,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
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
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Transaksi Peminjaman '.$periode2.'</th>
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
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
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

public function actionExportExcelOdtPerpanjanganPeminjamanFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%Y") Periode';
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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['Petugas_perpanjangan'])) {
        foreach ($_POST['Petugas_perpanjangan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT ".$periode_format.", 
                COUNT(*) AS JumlahEksemplar, 
                '' AS Kriteria, 
                COUNT(DISTINCT collections.Catalog_ID) AS JumlahJudul 
                FROM collectionloanextends  
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID  
                INNER JOIN members ON collectionloanextends.Member_Id = members.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanextends.DateExtend,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'JumlahEksemplar'=>$model['JumlahEksemplar'], 'JumlahJudul'=>$model['JumlahJudul'] );
            $JumlahEksemplar = $JumlahEksemplar + $model['JumlahEksemplar'];
            $JumlahJudul = $JumlahJudul + $model['JumlahJudul'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlahEksemplar'=>$JumlahEksemplar,
        'TotalJumlahJudul'=>$JumlahJudul,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-perpanjangan-peminjaman-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-perpanjangan-peminjaman-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordPerpanjanganPeminjamanFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%Y") Periode';
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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['Petugas_perpanjangan'])) {
        foreach ($_POST['Petugas_perpanjangan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT ".$periode_format.", 
                COUNT(*) AS JumlahEksemplar, 
                '' AS Kriteria, 
                COUNT(DISTINCT collections.Catalog_ID) AS JumlahJudul 
                FROM collectionloanextends  
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID  
                INNER JOIN members ON collectionloanextends.Member_Id = members.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanextends.DateExtend,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
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
                <th colspan="4">Transaksi Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="4">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 20px; margin-right: 20px; ">
                <th>No.</th>
                <th>Periode</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
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

public function actionExportPdfPerpanjanganPeminjamanFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanextends.DateExtend,"%Y") Periode';
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
                $andValue .= " AND collectionloanextends.Member_Id  =  '".$value."' ";
                }
            }
        }

        if (isset($_POST['Petugas_perpanjangan'])) {
        foreach ($_POST['Petugas_perpanjangan'] as $key => $value) {
            if ($value != "0" ) {
                $andValue .= " AND collectionloanextends.CreateBy  =  '".$value."' ";
                }
            }
        }  

        $sql = "SELECT ".$periode_format.", 
                COUNT(*) AS JumlahEksemplar, 
                '' AS Kriteria, 
                COUNT(DISTINCT collections.Catalog_ID) AS JumlahJudul 
                FROM collectionloanextends  
                INNER JOIN collections ON collectionloanextends.Collection_id = collections.ID  
                INNER JOIN members ON collectionloanextends.Member_Id = members.ID 
                WHERE DATE(collectionloanextends.DateExtend) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanextends.DateExtend,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanextends.DateExtend) ORDER BY DATE_FORMAT(collectionloanextends.DateExtend,'%Y-%m-%d') DESC";
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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-perpanjangan-peminjaman-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');
        
    }


public function actionRenderSangsiPelanggaranPeminjamanFrekuensi() 
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%Y") Periode';
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS JumlahEksemplar, 
                    '' AS Kriteria, 
                    COUNT(DISTINCT Collections.Catalog_ID) AS JumlahJudul, 
                    SUM(pelanggaran.JumlahDenda) AS total_uang, 
                    SUM(pelanggaran.JumlahSuspend) AS total_skorsing 
                    FROM pelanggaran  
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
            $sql .= $sqlPeriode;
            $sql .= $andValue;
            if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(pelanggaran.CreateDate,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
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
            'content' => $this->renderPartial('pdf-view-sangsi-pelanggaran-peminjaman-frekuensi', $content),
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

public function actionExportExcelSangsiPelanggaranPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%Y") Periode';
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

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

                $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS JumlahEksemplar, 
                    '' AS Kriteria, 
                    COUNT(DISTINCT Collections.Catalog_ID) AS JumlahJudul, 
                    SUM(pelanggaran.JumlahDenda) AS total_uang, 
                    SUM(pelanggaran.JumlahSuspend) AS total_skorsing 
                    FROM pelanggaran  
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";

            $sql .= $sqlPeriode;
            $sql .= $andValue;
            if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(pelanggaran.CreateDate,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
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
                <th colspan="6">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Sangsi Pelanggaran Peminjaman '.$periode2.'</th>
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
                <th>Periode Peminjaman</th>
                <th>Jumlah Judul</th>
                <th>jumlah Eksemplar</th>
                <th>Total Uang</th>
                <th>Total Skorsing</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        $TotalUang = 0;
        $TotalSkorsing = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                    <td>'.$data['total_uang'].'</td>
                    <td>'.$data['total_skorsing'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $TotalUang = $TotalUang + $data['total_uang'];
                        $TotalSkorsing = $TotalSkorsing + $data['total_skorsing'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJudul.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahEksemplar.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalUang.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalSkorsing.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtSangsiPelanggaranPeminjamanFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%Y") Periode';
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

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

                $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS JumlahEksemplar, 
                    '' AS Kriteria, 
                    COUNT(DISTINCT Collections.Catalog_ID) AS JumlahJudul, 
                    SUM(pelanggaran.JumlahDenda) AS total_uang, 
                    SUM(pelanggaran.JumlahSuspend) AS total_skorsing 
                    FROM pelanggaran  
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";

            $sql .= $sqlPeriode;
            $sql .= $andValue;
            if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(pelanggaran.CreateDate,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
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
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'JumlahJudul'=>$model['JumlahJudul'], 'JumlahEksemplar'=>$model['JumlahEksemplar'], 'total_uang'=>$model['total_uang'], 'total_skorsing'=>$model['total_skorsing'] );
            $JumlahJudul = $JumlahJudul + $model['JumlahJudul'];
            $JumlahEksemplar = $JumlahEksemplar + $model['JumlahEksemplar'];
            $total_uang = $total_uang + $model['total_uang'];
            $total_skorsing = $total_skorsing + $model['total_skorsing'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlahJudul'=>$JumlahJudul,
        'TotalJumlahEksemplar'=>$JumlahEksemplar,
        'Totaltotal_uang'=>$total_uang,
        'Totaltotal_skorsing'=>$total_skorsing,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-pelanggaran-peminjaman-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-pelanggaran-peminjaman-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordSangsiPelanggaranPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%Y") Periode';
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

        if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }

                $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS JumlahEksemplar, 
                    '' AS Kriteria, 
                    COUNT(DISTINCT Collections.Catalog_ID) AS JumlahJudul, 
                    SUM(pelanggaran.JumlahDenda) AS total_uang, 
                    SUM(pelanggaran.JumlahSuspend) AS total_skorsing 
                    FROM pelanggaran  
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";

            $sql .= $sqlPeriode;
            $sql .= $andValue;
            if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(pelanggaran.CreateDate,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
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
                <th colspan="6">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="6">Sangsi Pelanggaran Peminjaman '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="6">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 10px; margin-right: 10px;">
                <th>No.</th>
                <th>Periode Peminjaman</th>
                <th>Jumlah Judul</th>
                <th>jumlah Eksemplar</th>
                <th>Total Uang</th>
                <th>Total Skorsing</th>
            </tr>
            ';
        $no = 1;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        $TotalUang = 0;
        $TotalSkorsing = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                    <td>'.$data['total_uang'].'</td>
                    <td>'.$data['total_skorsing'].'</td>
                </tr>
            ';
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $TotalUang = $TotalUang + $data['total_uang'];
                        $TotalSkorsing = $TotalSkorsing + $data['total_skorsing'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJudul.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahEksemplar.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalUang.'
                        </td>
                        <td style="font-weight: bold;">
                            '.$TotalSkorsing.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfSangsiPelanggaranPeminjamanFrekuensi()
    {
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
      //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(pelanggaran.CreateDate,"%Y") Periode';
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
                    $andValue .= ' AND pelanggaran.Member_Id = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan'])) {
            foreach ($_POST['tujuan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
        if (isset($_POST['tujuan2'])) {
            foreach ($_POST['tujuan2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND pelanggaran.CreateBy = "'.addslashes($value).'" ';
                }
            }
        }
            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS JumlahEksemplar, 
                    '' AS Kriteria, 
                    COUNT(DISTINCT Collections.Catalog_ID) AS JumlahJudul, 
                    SUM(pelanggaran.JumlahDenda) AS total_uang, 
                    SUM(pelanggaran.JumlahSuspend) AS total_skorsing 
                    FROM pelanggaran  
                    INNER JOIN members ON pelanggaran.Member_id = members.ID 
                    LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID 
                    INNER JOIN collections ON pelanggaran.Collection_id = collections.ID 
                    INNER JOIN collectionloanitems ON pelanggaran.CollectionLoanItem_id = collectionloanitems.ID 
                    INNER JOIN users ON pelanggaran.CreateBy = users.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
            $sql .= $sqlPeriode;
            $sql .= $andValue;
            if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(pelanggaran.CreateDate,'%d-%m-%Y'), collections.Catalog_ID ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(pelanggaran.CreateDate) ORDER BY DATE_FORMAT(pelanggaran.CreateDate,'%Y-%m-%d') DESC";
                }


        $data = Yii::$app->db->createCommand($sql)->queryAll(); 
        
        $Berdasarkan = '';
        foreach ($_POST['kriterias'] as $key => $value) {
            $Berdasarkan .= $this->getRealNameKriteria($value).' ';
        }

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['Berdasarkan'] =  $Berdasarkan; 
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-sangsi-pelanggaran-peminjaman-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


public function actionRenderKoleksiSeringDipinjamFrekuensi() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS Frekuensi,  
                    COUNT(DISTINCT collectionloanitems.Member_id) AS Jumlah, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib 
                    FROM collectionloanitems  
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY collections.Catalog_id, DataBib ORDER BY Frekuensi DESC LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                }

             $sql .= $inValue; 

             // print_r($sql); 
             // die; 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['inValue'] =  $inValue;  
        //$content['isi_berdasarkan'] = $isi_kriteria;
        $content['kop'] =  isset($_POST['kop']); 

        if ($content['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set =55;
        } else {
            $header =  [''];
            $set = 10;
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            // 'orientation' => Pdf::ORIENT_LANDSCAPE,
            'marginTop' => $set,
            'marginLeft' => 0,
            'marginRight' => 0,
            'content' => $this->renderPartial('pdf-view-koleksi-sering-dipinjam-frekuensi', $content),
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

public function actionExportExcelKoleksiSeringDipinjamFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS Frekuensi,  
                    COUNT(DISTINCT collectionloanitems.Member_id) AS Jumlah, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib 
                    FROM collectionloanitems  
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY collections.Catalog_id, DataBib ORDER BY Frekuensi DESC LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                }

             $sql .= $inValue;

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
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Koleksi Sering Dipinjam '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="5">Berdasarkan Ranking '.$inValue.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr>
                <th>No.</th>
                <th>Periode</th>
                <th>Frekuensi</th>
                <th>Data Bibliografis</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $JumlahFrekuensi = 0;
        $JumlahJumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Frekuensi'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
                        $JumlahFrekuensi = $JumlahFrekuensi + $data['Frekuensi'];
                        $JumlahJumlah = $JumlahJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahFrekuensi.'
                        </td>
                        <td style="font-weight: bold;">
                            
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJumlah.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtKoleksiSeringDipinjamFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS Frekuensi,  
                    COUNT(DISTINCT collectionloanitems.Member_id) AS Jumlah, 
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
                    catalogs.DeweyNo AS data7
                    FROM collectionloanitems  
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY collections.Catalog_id ORDER BY Frekuensi DESC LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                }

             $sql .= $inValue;

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;
    $Berdasarkan =$inValue;

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Frekuensi'=>$model['Frekuensi'], 'Jumlah'=>$model['Jumlah'], 'data'=>$model['data'], 'data2'=>$model['data2'], 'data3'=>$model['data3']
                         , 'data4'=>$model['data4'], 'data5'=>$model['data5'], 'data6'=>$model['data6'], 'data7'=>$model['data7'] );
            $Frekuensi = $Frekuensi + $model['Frekuensi'];
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalFrekuensi'=>$Frekuensi,
        'TotalJumlah'=>$Jumlah,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-koleksi-sering-dipinjam-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-koleksi-sering-dipinjam-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKoleksiSeringDipinjamFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS Frekuensi,  
                    COUNT(DISTINCT collectionloanitems.Member_id) AS Jumlah, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib 
                    FROM collectionloanitems  
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY collections.Catalog_id, DataBib ORDER BY Frekuensi DESC LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                }

             $sql .= $inValue;

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
            <tr>
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Koleksi Sering Dipinjam '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="5">Berdasarkan Ranking '.$inValue.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 20px; margin-right: 20px;">
                <th>No.</th>
                <th>Periode</th>
                <th>Frekuensi</th>
                <th>Data Bibliografis</th>
                <th>Jumlah</th>
            </tr>
            ';
        $no = 1;
        $JumlahFrekuensi = 0;
        $JumlahJumlah = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Periode'].'</td>
                    <td>'.$data['Frekuensi'].'</td>
                    <td>'.$data['DataBib'].'</td>
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
                        $JumlahFrekuensi = $JumlahFrekuensi + $data['Frekuensi'];
                        $JumlahJumlah = $JumlahJumlah + $data['Jumlah'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahFrekuensi.'
                        </td>
                        <td style="font-weight: bold;">
                            
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahJumlah.'
                        </td>
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfKoleksiSeringDipinjamFrekuensi()    
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2 = 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2 = 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
                $periode = 'Tahunan';
                $periode2 = 'Periode '.$_POST['fromTahunan'].' s/d '.$_POST['toTahunan'];

                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,1,1,$_POST['fromTahunan']))."' AND '".date("Y-m-d", mktime(0,0,0,12,31,$_POST['toTahunan']))."' ";
            }
            else 
            {
                $periode = null;
            }
        }

        // var_dump($_POST['kataloger']);
        // die;

            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.",
                    COUNT(*) AS Frekuensi,  
                    COUNT(DISTINCT collectionloanitems.Member_id) AS Jumlah, 
                    CONCAT('<b>',catalogs.Title,'</b>','<br/>',(CASE WHEN catalogs.Worksheet_id <> 4 AND catalogs.Edition IS NOT NULL AND NOT LENGTH(catalogs.Edition) = 0 THEN CONCAT('<br/>',catalogs.Edition) ELSE (CASE WHEN EDISISERIAL IS NOT NULL THEN CONCAT('<br/>',EDISISERIAL) ELSE '' END) END),'<br/>',catalogs.PublishLocation,' ',catalogs.Publisher,' ',catalogs.PublishYear,'<br/>',catalogs.Subject,'<br/>',catalogs.DeweyNo) AS DataBib 
                    FROM collectionloanitems  
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    WHERE DATE(collectionloanitems.LoanDate) ";      
             $sql .= $sqlPeriode;
             $sql .= $andValue;
             if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY collections.Catalog_id, DataBib ORDER BY Frekuensi DESC LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), collections.Catalog_id ORDER BY Frekuensi DESC, Periode LIMIT ";
                }

             $sql .= $inValue; 

             // print_r($sql); 
             // die; 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['inValue'] =  $inValue;  
        //$content['isi_berdasarkan'] = $isi_kriteria;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
            /*$header =  ['<img src="<?= Yii::getAlias('@uploaded_files/aplikasi/kop.png');?>" >'];*/
            // $header =  ['<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >'];
            $set =55;
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
        $content = $this->renderPartial('pdf-view-koleksi-sering-dipinjam-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderAnggotaSeringMeminjamFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.", 
                    COUNT(*) AS Frekuensi, 
                    COUNT(DISTINCT collections.Catalog_id) AS JumlahJudul, 
                    COUNT(DISTINCT collectionloanitems.Collection_id) AS JumlahEksemplar,
                    members.MemberNo AS NoAnggota, 
                    members.FullName AS NamaAnggota 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'), members.FullName ORDER BY members.FullName LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                }

        $sql .= $inValue;

        // print_r($sql); 
        //      die;

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
            'content' => $this->renderPartial('pdf-view-anggota-sering-meminjam-frekuensi', $content),
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

public function actionExportExcelAnggotaSeringMeminjamFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.", 
                    COUNT(*) AS Frekuensi, 
                    COUNT(DISTINCT collections.Catalog_id) AS JumlahJudul, 
                    COUNT(DISTINCT collectionloanitems.Collection_id) AS JumlahEksemplar,
                    members.MemberNo AS NoAnggota, 
                    members.FullName AS NamaAnggota 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'), members.FullName ORDER BY members.FullName LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                }

        $sql .= $inValue;

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
                <th colspan="5">Anggota Sering Meminjam '.$periode2.'</th>
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
                <th>Frekuensi</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahFrekuensi = 0;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Frekuensi'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                </tr>
            ';
                        $JumlahFrekuensi = $JumlahFrekuensi + $data['Frekuensi'];
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="1" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahFrekuensi.'
                        </td>
                        <td style="font-weight: bold;">
                            
                        </td>
                        <td style="font-weight: bold;">
                            
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

public function actionExportExcelOdtAnggotaSeringMeminjamFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.", 
                    COUNT(*) AS Frekuensi, 
                    COUNT(DISTINCT collections.Catalog_id) AS JumlahJudul, 
                    COUNT(DISTINCT collectionloanitems.Collection_id) AS JumlahEksemplar,
                    members.MemberNo AS NoAnggota, 
                    members.FullName AS NamaAnggota 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'), members.FullName ORDER BY members.FullName LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                }

        $sql .= $inValue;

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
        $data[] = array('no'=> $no++,'Frekuensi'=> $model['Frekuensi'], 'NoAnggota'=>$model['NoAnggota'], 'NamaAnggota'=>$model['NamaAnggota'], 'JumlahJudul'=>$model['JumlahJudul'], 'JumlahEksemplar'=>$model['JumlahEksemplar'] );
            $Frekuensi = $Frekuensi + $model['Frekuensi'];
            $JumlahJudul = $JumlahJudul + $model['JumlahJudul'];
            $JumlahEksemplar = $JumlahEksemplar + $model['JumlahEksemplar'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'Berdasarkan'=>$Berdasarkan, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalFrekuensi'=>$Frekuensi,
        'TotalJumlahJudul'=>$JumlahJudul,
        'TotalJumlahEksemplar'=>$JumlahEksemplar,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-anggota-sering-meminjam-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-anggota-sering-meminjam-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordAnggotaSeringMeminjamFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.", 
                    COUNT(*) AS Frekuensi, 
                    COUNT(DISTINCT collections.Catalog_id) AS JumlahJudul, 
                    COUNT(DISTINCT collectionloanitems.Collection_id) AS JumlahEksemplar,
                    members.MemberNo AS NoAnggota, 
                    members.FullName AS NamaAnggota 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'), members.FullName ORDER BY members.FullName LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                }

        $sql .= $inValue;

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
                <th colspan="5">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="5">Anggota Sering Meminjam '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="5">Berdasarkan '.$Berdasarkan.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-left: 10px; margin-right: 10px; ">
                <th>No.</th>
                <th>Frekuensi</th>
                <th>Nomer Anggota</th>
                <th>Nama Anggota</th>
                <th>Jumlah Judul</th>
                <th>Jumlah Eksemplar</th>
            </tr>
            ';
        $no = 1;
        $JumlahFrekuensi = 0;
        $JumlahJudul = 0;
        $JumlahEksemplar = 0;
        foreach($model as $data):
            echo '
                <tr align="center">
                    <td>'.$no.'</td>
                    <td>'.$data['Frekuensi'].'</td>
                    <td>'.$data['NoAnggota'].'</td>
                    <td>'.$data['NamaAnggota'].'</td>
                    <td>'.$data['JumlahJudul'].'</td>
                    <td>'.$data['JumlahEksemplar'].'</td>
                </tr>
            ';
                        $JumlahFrekuensi = $JumlahFrekuensi + $data['Frekuensi'];
                        $JumlahJudul = $JumlahJudul + $data['JumlahJudul'];
                        $JumlahEksemplar = $JumlahEksemplar + $data['JumlahEksemplar'];
                        $no++;
                    endforeach;
                echo '
                    <tr align="center">
                        <td colspan="1" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$JumlahFrekuensi.'
                        </td>
                        <td style="font-weight: bold;">
                            
                        </td>
                        <td style="font-weight: bold;">
                            
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

public function actionExportPdfAnggotaSeringMeminjamFrekuensi()
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
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.LoanDate,"%Y") Periode';
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


            if (isset($_POST['no_anggota'])) {
            foreach ($_POST['no_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= " AND collectionloanitems.member_id = '".addslashes($value)."' ";
                    }
                }
            }
            
            if (isset($_POST['range_umur'])) {
            foreach ($_POST['range_umur'] as $key => $value) {
                if ($value != "0" ) {
                    $umur = MasterRangeUmur::findOne(['id' => $value]);
                    $andValue .= ' AND umur(members.DateOfBirth) BETWEEN "'.$umur->umur1.'" AND "'.$umur->umur2.'" ';
                    }
                }
            }

            if (isset($_POST['jenis_kelamin'])) {
            foreach ($_POST['jenis_kelamin'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= ' AND members.Sex_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_kelamin ON members.Sex_id = jenis_kelamin.ID ';
            }

            if (isset($_POST['jenis_anggota'])) {
            foreach ($_POST['jenis_anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND jenis_anggota.jenisanggota = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID ';
            }

            if (isset($_POST['Pekerjaan'])) {
            foreach ($_POST['Pekerjaan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pekerjaan.Pekerjaan = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pekerjaan ON members.Job_id = master_pekerjaan.ID ';
            }

            if (isset($_POST['Pendidikan'])) {
            foreach ($_POST['Pendidikan'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND master_pendidikan.Nama = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_pendidikan ON members.EducationLevel_id = master_pendidikan.ID ';
            }

            if (isset($_POST['unit_kerja'])) {
            foreach ($_POST['unit_kerja'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.UnitKerja_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN departments ON members.UnitKerja_id = departments.ID ';
            }
            
            if (isset($_POST['jenis_identitas'])) {
            foreach ($_POST['jenis_identitas'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.IdentityType_id = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'LEFT JOIN master_jenis_identitas ON members.IdentityType_id = master_jenis_identitas.ID ';
            }  
            
            if (isset($_POST['propinsi'])) {
            foreach ($_POST['propinsi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Province = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten'])) {
            foreach ($_POST['kabupaten'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.City = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['propinsi2'])) {
            foreach ($_POST['propinsi2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.ProvinceNow = "'.addslashes($value).'" ';
                    }
                }
            }
            
            if (isset($_POST['kabupaten2'])) {
            foreach ($_POST['kabupaten2'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.Citynow = "'.addslashes($value).'" ';
                    }
                }
            }  
            
            if (isset($_POST['nama_institusi'])) {
            foreach ($_POST['nama_institusi'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND members.InstitutionName = "'.addslashes($value).'" ';
                    }
                }
            }

            if (isset($_POST['lokasi_pinjam'])) {
            foreach ($_POST['lokasi_pinjam'] as $key => $value) {
                if ($value != "0" ) {
                    $andValue .= 'AND location_library.ID = "'.addslashes($value).'" ';
                    }
                }
            $subjek .= 'INNER JOIN memberloanauthorizelocation ON members.ID = memberloanauthorizelocation.Member_id 
                        INNER JOIN location_library ON memberloanauthorizelocation.LocationLoan_id = location_library.ID  
                        INNER JOIN locations ON collections.Location_Id = locations.ID ';
            }
   
            $inValue = $_POST['rank'];

            $sql = "SELECT ".$periode_format.", 
                    COUNT(*) AS Frekuensi, 
                    COUNT(DISTINCT collections.Catalog_id) AS JumlahJudul, 
                    COUNT(DISTINCT collectionloanitems.Collection_id) AS JumlahEksemplar,
                    members.MemberNo AS NoAnggota, 
                    members.FullName AS NamaAnggota 
                    FROM collectionloanitems 
                    INNER JOIN collections ON collectionloanitems.Collection_id = collections.ID 
                    INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    INNER JOIN users ON users.ID = collectionloanitems.CreateBy "; 
            $sql .= $subjek;
            $sql .= "WHERE DATE(collectionloanitems.LoanDate) "; 
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.LoanDate,'%d-%m-%Y'), members.FullName ORDER BY members.FullName LIMIT ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.LoanDate), members.FullName ORDER BY members.FullName LIMIT ";
                }

        $sql .= $inValue;

        // print_r($sql); 
        //      die;

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
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-anggota-sering-meminjam-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }

public function actionRenderKinerjaUserPeminjamanFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // print_r(implode($_POST['kataloger']);
        // die;

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
            'content' => $this->renderPartial('pdf-view-kinerja-user-peminjaman-frekuensi', $content),
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

public function actionExportExcelKinerjaUserPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

    $periode2 = $periode2;
    $format_hari = $periode;
        
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

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
                <th>jumlah</th>
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

public function actionExportExcelOdtKinerjaUserPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = '(Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = '(Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-kinerja-user-peminjaman-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-kinerja-user-peminjaman-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserPeminjamanFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

    $periode2 = $periode2;
    $format_hari = $periode;
        
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

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
               <p align="center"> <b>Kinerja User Peminjaman '.$periode2.' </b></p>
               <p align="center"> <b>'.$a.' '.$DetailFilter['kataloger'].' '.$dan.' '.$DetailFilter['kriteria'].'</b></p>
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
                    <th>jumlah</th>
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

public function actionExportPdfKinerjaUserPeminjamanFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';

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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), Kataloger ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 


        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

        // $DetailFilter = Users::find()->select('username')->asArray();
        // $umur = $_POST['kriteria'];

        // print_r($DetailFilter['kriteria']);
        // die;

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
        $content = $this->renderPartial('pdf-view-kinerja-user-peminjaman-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


public function actionRenderKinerjaUserPengembalianFrekuensi() 
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } 

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

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
            'content' => $this->renderPartial('pdf-view-kinerja-user-pengembalian-frekuensi', $content),
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

public function actionExportExcelKinerjaUserPengembalianFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

    $periode2 = $periode2;
    $format_hari = $periode;
        
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

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
                <th colspan="4">Kinerja User Pengembalian '.$periode2.'</th>
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
                <th>jumlah</th>
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

public function actionExportExcelOdtKinerjaUserPengembalianFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
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
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-kinerja-user-pengembalian-frekuensi.ods'; 

    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-kinerja-user-pengembalian-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordKinerjaUserPengembalianFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

    $periode2 = $periode2;
    $format_hari = $periode;
        
        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

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
                <tr>
                    <th>No.</th>
                    <th>Periode</th>
                    <th>Kataloger</th>
                    <th>jumlah</th>
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

public function actionExportPdfKinerjaUserPengembalianFrekuensi()
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
                $periode_format = 'DATE_FORMAT(modelhistory.date,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
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
                    $andValue .= ' AND modelhistory.user_id  = "'.$value.'" ';
                    $DetailFilter['kataloger'] = 'Kataloger';
                    }else {$DetailFilter['kataloger'] = '';}
                }
            }

            if (isset($_POST['kriteria'])) {
            foreach ($_POST['kriteria'] as $key => $value) {
                $isi_kriteria = $value; 
                if ($value != "" ) {
                    $andValue .= ' AND modelhistory.type = "'.$value.'" ';
                    }
                }
            } 

            switch (implode($_POST['kriteria'])) {
            case '0':
                $DetailFilter['kriteria'] = ' (Kriteria dibuat) ';
                break;

            case '2':
                $DetailFilter['kriteria'] = ' (Kriteria dihapus) ';
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
        $sql .= " AND modelhistory.table = 'collectionloanitems'";
        $sql .= $andValue;
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(modelhistory.date,'%d-%m-%Y'), DATE_FORMAT(modelhistory.date,'%Y-%m-%d') ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                } else {
                    $sql .= " GROUP BY YEAR(modelhistory.date), users.UserName ORDER BY DATE_FORMAT(modelhistory.date,'%Y-%m-%d') DESC";
                }

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        if(implode($_POST['kataloger']) != '0' || implode($_POST['kriteria']) != ''){
            $a = 'Berdasarkan';
        }else{ $a = '';}

        if(implode($_POST['kataloger']) != '0' && implode($_POST['kriteria']) != ''){
            $dan = 'dan';
        }else{ $dan = '';}

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
        $content = $this->renderPartial('pdf-view-kinerja-user-pengembalian-frekuensi', $content);
        if ($content_kop['kop']) {
        $pdf->SetHTMLHeader('<img src="'.Yii::$app->urlManager->createUrl("../uploaded_files/aplikasi/kop.png").'" style="margin-top: -30px; height: 180; width: 100%;" >');
        }else{
        $pdf->SetHTMLHeader();
        }
        $pdf->SetHTMLFooter('<div class="footer" style="position: relative; float: left;">Pages {PAGENO}</div>');
        $pdf->WriteHtml($content);
        echo $pdf->Output('Laporan_Periodik_Frekuensi.pdf', 'D');

    }


public function actionRenderPengembalianTerlambatFrekuensi() 
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    COUNT(collectionloanitems.Member_id) AS Jumlah 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0';
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.CreateDate,'%d-%M-%Y') ORDER BY Jumlah DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                }

        // echo $test;
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['test'] = $test;
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
            'content' => $this->renderPartial('pdf-view-pengembalian-terlambat-frekuensi', $content),
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

public function actionExportExcelPengembalianTerlambatFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    COUNT(collectionloanitems.Member_id) AS Jumlah 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0';
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.CreateDate,'%d-%M-%Y') ORDER BY Jumlah DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                }

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
                <th colspan="3">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="3">Pengembalian Terlambat '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="3">Berdasarkan Anggota '.$test.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 20px; margin-left: 20px;">
                <th>No.</th>
                <th>Periode</th>
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
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
        $Jumlah = $Jumlah + $data['Jumlah'];
        $no++;
        endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>                   
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportExcelOdtPengembalianTerlambatFrekuensi()
{
    $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    COUNT(collectionloanitems.Member_id) AS Jumlah 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0';
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.CreateDate,'%d-%M-%Y') ORDER BY Jumlah DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 
    $periode2 = $periode2;
    $format_hari = $periode;

    $headers = Yii::getAlias('@webroot','/teeeesst');

    $no = 1;
    $data = array();
    foreach($model as $model):
        $data[] = array('no'=> $no++,'Periode'=> $model['Periode'], 'Jumlah'=>$model['Jumlah'] );
            $Jumlah = $Jumlah + $model['Jumlah'];
    endforeach;

    $detail[] = array(
        'menu'=>$menu, 
        'format_hari'=>$format_hari, 
        'periode2'=>$periode2,
        'TotalJumlah'=>$Jumlah,
        'test' => $test,
        );

// print_r(sizeof($_POST['kriterias']));
// die;

    $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
    $template = Yii::getAlias('@uploaded_files').'/templates/laporan/sirkulasi/laporan-sirkulasi-pengembalian-terlambat-frekuensi.ods'; 


    // $OpenTBS->LoadTemplate($template);
    $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $OpenTBS->MergeBlock('a,b', $data);
    $OpenTBS->MergeBlock('detail', $detail);

    $OpenTBS->Show(OPENTBS_DOWNLOAD, 'laporan-sirkulasi-pengembalian-terlambat-frekuensi.ods');
    // !Open Office Calc Area


}

public function actionExportWordPengembalianTerlambatFrekuensi()
{
        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    COUNT(collectionloanitems.Member_id) AS Jumlah 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0';
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.CreateDate,'%d-%M-%Y') ORDER BY Jumlah DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                }

    $model = Yii::$app->db->createCommand($sql)->queryAll(); 

    $periode2 = $periode2;
    $format_hari = $periode; 

    $type = $_GET['type'];
    $filename = 'Laporan_Periodik_Frekuensi.'.$type;
    // header("Content-type: application/vnd-ms-word");
    header("Content-Disposition: attachment; filename =".$filename."");
    header("Pragma: no-cahce");
    header("Expires: 0");
    echo '<table border="0" align="center" width="700"> 
            <tr>
                <th colspan="3">Laporan Frekuensi '.$format_hari.'</th>
            </tr>
            <tr>
                <th colspan="3">Pengembalian Terlambat '.$periode2.'</th>
            </tr>
            <tr>
                <th colspan="3">Berdasarkan Anggota '.$test.'</th>
            </tr>
            <tr>
            </tr>
            ';
    echo '<table border="1" align="center">
            <tr style="margin-right: 40px; margin-left: 40px;">
                <th>No.</th>
                <th>Periode</th>
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
                    <td>'.$data['Jumlah'].'</td>
                </tr>
            ';
        $Jumlah = $Jumlah + $data['Jumlah'];
        $no++;
        endforeach;
                echo '
                    <tr align="center">
                        <td colspan="2" style="font-weight: bold;">
                            Total
                        </td>
                        <td style="font-weight: bold;">
                            '.$Jumlah.'
                        </td>                   
                    </tr>
                    ';
        
    echo '</table>';

}

public function actionExportPdfPengembalianTerlambatFrekuensi()
    {

        $_POST =  $_SESSION['Array_POST_Filter'];
        $andValue = '';
        $sqlPeriode = '';
        $test = '';

          //Untuk Header Laporan berdasarkan Periode yng dipilih
        if (isset($_POST['periode'])) 
        {
            if ($_POST['periode'] == "harian") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%d-%M-%Y") Periode';
                $periode = 'Harian';
                $periode2= 'Periode '.$_POST['from_date'].' s/d '.$_POST['to_date'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", strtotime($_POST['from_date']) )."' AND '".date("Y-m-d", strtotime($_POST['to_date']) )."' ";
            } 
            elseif ($_POST['periode'] == "bulanan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%M-%Y") Periode';
                $periode = 'Bulanan';
                $periode2= 'Periode '.date("M", mktime(0, 0, 0, $_POST['fromBulan'], 10)).'-'.$_POST['fromTahun'].' s/d '.date("M", mktime(0, 0, 0, $_POST['toBulan'], 10)).'-'.$_POST['toTahun'];
                $sqlPeriode = "BETWEEN '".date("Y-m-d", mktime(0,0,0,$_POST['fromBulan'],1,$_POST['fromTahun']))."' AND '".date("Y-m-t", mktime(0,0,0,$_POST['toBulan'],1,$_POST['toTahun']))."' ";
            } 
            elseif ($_POST['periode'] == "tahunan") 
            {
                $periode_format = 'DATE_FORMAT(collectionloanitems.CreateDate,"%Y") Periode';
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
            if (isset($_POST['anggota'])) {
            foreach ($_POST['anggota'] as $key => $value) {
                if ($value != "0" ) {
                    $Members = Members::findOne(['ID' => $value]);
                    $andValue .= ' AND collectionloanitems.Member_id = "'.$value.'" ';
                    $test = '('.$Members->Fullname.')';
                    }
                }
            }
            
           $sql = "SELECT ".$periode_format.",
                    COUNT(collectionloanitems.Member_id) AS Jumlah 
                    FROM collectionloanitems 
                    INNER JOIN members ON collectionloanitems.Member_id = members.ID 
                    WHERE DATE(collectionloanitems.CreateDate) ";
        
        $sql .= $sqlPeriode;
        $sql .= $andValue;
        $sql .= ' AND collectionloanitems.LateDays > 0';
        if ($_POST['periode'] == "harian"){
                    $sql .= " GROUP BY DATE_FORMAT(collectionloanitems.CreateDate,'%d-%M-%Y') ORDER BY Jumlah DESC ";
                } elseif ($_POST['periode'] == "bulanan") {
                    $sql .= " GROUP BY MONTH(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                } else {
                    $sql .= " GROUP BY YEAR(collectionloanitems.CreateDate) ORDER BY Jumlah DESC ";
                }

        // echo $test;
        // die;

        $data = Yii::$app->db->createCommand($sql)->queryAll(); 

        $content['LaporanKriteria'] = ""; 
        $content['LaporanSubJudulKriteriaVal'] = '$kriteriaVal'; 
        $content['TableLaporan'] = $data; 
        $content['LaporanPeriode'] = $periode;
        $content['LaporanPeriode2'] = $periode2;
        $content['sql'] = $sql; 
        $content['test'] = $test;
        $content_kop['kop'] =  isset($_POST['kop']); 

        if ($content_kop['kop']) {
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
        $content = $this->renderPartial('pdf-view-pengembalian-terlambat-frekuensi', $content);
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
        elseif ($kriterias == 'Petugas_perpanjangan') 
        {
            $name = 'Petugas Perpanjangan';
        }
        elseif ($kriterias == 'Kelas_dcc') 
        {
            $name = 'Kelas DCC';
        }
        elseif ($kriterias == 'Publisher') 
        {
            $name = 'Nama Penerbit';
        }
        elseif ($kriterias == 'PublishLocation') 
        {
            $name = 'Kota Terbit';
        }
        elseif ($kriterias == 'nama_institusi') 
        {
            $name = 'Nama Institusi';
        }
        elseif ($kriterias == 'penginput_data') 
        {
            $name = 'Penginput Data';
        }
        elseif ($kriterias == 'PublishYear') 
        {
            $name = 'Tahun Terbit';
        }
        elseif ($kriterias == 'partners') 
        {
            $name = 'Nama Sumber / Rekanan Perolehan';
        }
        elseif ($kriterias == 'harga') 
        {
            $name = 'Harga';
        }
        elseif ($kriterias == 'collectionrules') 
        {
            $name = 'Jenis Akses';
        }
        elseif ($kriterias == 'collectionmedias') 
        {
            $name = 'Jenis Bahan';
        }
        elseif ($kriterias == 'Subject') 
        {
            $name = 'Subjek';
        }
        elseif ($kriterias == 'no_klas') 
        {
            $name = 'Nomer Kekas';
        }
        elseif ($kriterias == 'no_panggil') 
        {
            $name = 'Nomer Panggil';
        }
        elseif ($kriterias == 'worksheets') 
        {
            $name = 'Jenis Bahan';
        }
        elseif ($kriterias == 'collectioncategorys') 
        {
            $name = 'Kategori';
        }
        elseif ($kriterias == 'collectionsources') 
        {
            $name = 'Jenis Sumber Perolehan';
        }
        elseif ($kriterias == 'locations') 
        {
            $name = 'Ruang Perpustakaan';
        }
        elseif ($kriterias == 'location_library') 
        {
            $name = 'Lokasi Perpustakaan';
        }
        elseif ($kriterias == 'jenis_identitas') 
        {
            $name = 'Jenis Identitas';
        }
        elseif ($kriterias == 'kabupaten') 
        {
            $name = 'Kabupaten/Kota Sesuai Identitas';
        }elseif ($kriterias == 'kabupaten2') 
        {
            $name = 'Kabupaten/Kota Sesuai Tempat Tinggal';
        }
        elseif ($kriterias == 'propinsi') 
        {
            $name = 'Propinsi Sesuai Identitas';
        }elseif ($kriterias == 'propinsi2') 
        {
            $name = 'Propinsi Sesuai Tempat Tinggal';
        }
        elseif ($kriterias == 'unit_kerja') 
        {
            $name = 'Unit Kerja';
        }
        elseif ($kriterias == 'Pekerjaan') 
        {
            $name = 'Pekerjaan';
        }
        elseif ($kriterias == 'subjek') 
        {
            $name = 'Subjek';
        }
        elseif ($kriterias == 'jenis_sumber') 
        {
            $name = 'Nama Sumber';
        }
        elseif ($kriterias == 'Partners') 
        {
            $name = 'Nama Sumber';
        } 
        elseif ($kriterias == 'kategori_koleksi') 
        {
            $name = 'Kategori';
        } 
        elseif ($kriterias == 'bentuk_fisik') 
        {
            $name = 'Bentuk Fisik';
        } 
        elseif ($kriterias == 'Pendidikan') 
        {
            $name = 'Pendidikan';
        }
        elseif ($kriterias == 'lokasi_pinjam') 
        {
            $name = 'Lokasi Pinjam';
        }
        elseif ($kriterias == 'tujuan') 
        {
            $name = 'Penginput Data Peminjaman';
        }
        elseif ($kriterias == 'tujuan2') 
        {
            $name = 'Penginput Data Pengembalian';
        }
        elseif ($kriterias == 'Status_Anggota') 
        {
            $name = 'Status Anggota';
        }
        elseif ($kriterias == 'currency') 
        {
            $name = 'Mata Uang';
        }
        elseif ($kriterias == 'Jenis_Anggota') 
        {
            $name = 'Jenis Anggota';
        }
        elseif ($kriterias == 'jenis_kelamin') 
        {
            $name = 'Jenis Kelamin';
        }
        elseif ($kriterias == 'Kelas') 
        {
            $name = 'Kelas';
        }
        elseif ($kriterias == 'jenis_anggota') 
        {
            $name = 'Jenis Anggota';
        }
        elseif ($kriterias == 'Fakultas') 
        {
            $name = 'Fakultas';
        }
        elseif ($kriterias == 'Jurusan') 
        {
            $name = 'Jurusan';
        }
        elseif ($kriterias == 'peminjam_terbanyak') 
        {
            $name = 'Peminjam';
        }
        elseif ($kriterias == 'departments') 
        {
            $name = 'Unit Kerja';
        }
        elseif ($kriterias == 'range_umur') 
        {
            $name = 'Kelompok Umur';
        }
        elseif ($kriterias == 'ruang_perpus') 
        {
            $name = 'Ruang Perpustakaan';
        }
        elseif ($kriterias == 'lokasi_perpus') 
        {
            $name = 'Lokasi Perpustakaan';
        }
        else 
        {
            $name = ' ';
        }
        
        return $name;

    }
}
