<?php
/**
 * @copyright Copyright &copy; Perpustakaan Nasional RI, 2015
 * @package _form.php
 * @version 1.0.0
 * @author Henry <alvin_vna@yahoo.com>
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use kartik\widgets\Select2;
use leandrogehlen\querybuilder\QueryBuilderForm;

/**
 * @var yii\web\View $this
 * @var common\models\MemberSearch $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="row">
    <div class="col-xs-12 col-xs-12">
<?php 

QueryBuilderForm::begin([
    'rules' => $rules,
    'options' => ['data-pjax' => true ],
    'builder' => [
        'id' => 'query-builder',
        'allowGroups' => false,
        'selectPlaceholder'=>'-Pilih Kriteria-',
        'filters' => [
            //['id' => 'ID', 'label' => 'Id', 'type' => 'integer'],
            ['id' => 'catalogs.Worksheet_id', 
             'label' => 'Jenis Bahan', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Worksheets::find()->all(),'ID','Name'),['0'=>'-Pilih Jenis Bahan-'])
            ],
            ['id' => 'NomorBarcode', 'label' => 'Nomor Barcode', 'type' => 'string'],
            ['id' => 'NoInduk', 'label' => 'No. Induk', 'type' => 'string'],
            ['id' => 'RFID', 'label' => 'RFID', 'type' => 'string'],
            ['id' => 'collections.CallNumber', 'label' => 'Nomor Panggil', 'type' => 'string'],
            ['id' => 'catalogs.Title', 'label' => 'Judul', 'type' => 'string'],
            ['id' => 'catalogs.Author', 'label' => 'Pengarang', 'type' => 'string'],
            ['id' => 'catalogs.PublishLocation', 'label' => 'Tempat Terbit', 'type' => 'string'],
            ['id' => 'catalogs.Publisher', 'label' => 'Penerbit', 'type' => 'string'],
            ['id' => 'catalogs.PublishYear', 'label' => 'Tahun Terbit',  'type' => 'integer', 'input'=>'text'],
            ['id' => 'catalogs.PhysicalDescription', 'label' => 'Deskripsi Fisik', 'type' => 'string'],
            ['id' => 'catalogs.Edition', 'label' => 'Edisi', 'type' => 'string'],
            ['id' => 'EDISISERIAL', 'label' => 'Edisi Serial', 'type' => 'string'],
            ['id' => 'catalogs.ISBN', 'label' => 'ISBN / ISSN', 'type' => 'string'],
            ['id' => 'Source_id', 
             'label' => 'Jenis Sumber', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Collectionsources::find()->all(),'ID','Name'),['0'=>'-Pilih Jenis Sumber-'])
            ],
            ['id' => 'Media_id', 
             'label' => 'Bentuk Fisik', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Collectionmedias::find()->all(),'ID','Name'),['0'=>'-Pilih Bentuk Fisik-'])
            ],
            ['id' => 'Category_id', 
             'label' => 'Jenis Kategori', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Collectioncategorys::find()->all(),'ID','Name'),['0'=>'-Pilih Jenis Kategori-'])
            ],
            ['id' => 'Rule_id', 
             'label' => 'Akses', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Collectionrules::find()->all(),'ID','Name'),['0'=>'-Pilih Akses-'])
            ],
            ['id' => 'Status_id', 
             'label' => 'Ketersediaan', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Collectionstatus::find()->all(),'ID','Name'),['0'=>'-Pilih Ketersediaan-'])
            ],
            ['id' => 'Location_Library_id', 
             'label' => 'Lokasi Perpustakaan', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\LocationLibrary::find()->all(),'ID','Name'),['0'=>'-Pilih Lokasi Perpustakaan-'])
            ],
            ['id' => 'Location_id', 
             'label' => 'Lokasi Ruang', 
             'type' => 'integer',
             'input'=> 'select',
             'values'=> ArrayHelper::merge(ArrayHelper::map(\common\models\Locations::find()->all(),'ID','Name'),['0'=>'-Pilih Lokasi Ruang-'])
            ],
            ['id' => 'catalogs.BIBID', 'label' => 'BIBID', 'type' => 'string'],
            ['id' => 'IDJILID', 'label' => 'IDJILID', 'type' => 'string'],
            ['id' => 'NOMORPANGGILJILID', 'label' => 'Nomor Panggil Jilid', 'type' => 'string'],
            ['id' => 'BAHAN_SERTAAN', 'label' => 'Bahan Sertaan (Serial)', 'type' => 'string'],
            ['id' => 'KETERANGAN_LAIN', 'label' => 'Keterangan Lain (Serial)', 'type' => 'string'],
            ['id' => 'collections.ID', 'label' => 'ID Koleksi', 'type' => 'string'],
            ['id' => 'collections.CreateBy', 'label' => 'Operator (Tambah)', 'type' => 'string'],
            ['id' => 'collections.UpdateBy', 'label' => 'Operator (Ubah Terakhir)', 'type' => 'string'],
            [
                'id' => 'DATE(collections.CreateDate)', 'label' => 'Tanggal Entri', 'type' => 'date',
                /*'validation'=> [
                      'format'=> 'YYYY-MM-DD'
                ],*/
                'plugin'=> 'datepicker',
                'pluginConfig'=> [
                  'format'=> 'yyyy-mm-dd',
                  'todayBtn'=> 'linked',
                  'todayHighlight'=> true,
                  'autoclose'=> true
                ]

            ],
            [
                'id' => 'DATE(collections.UpdateDate)', 'label' => 'Tanggal Ubah Terakhir', 'type' => 'date',
                /*'validation'=> [
                      'format'=> 'YYYY-MM-DD'
                ],*/
                'plugin'=> 'datepicker',
                'pluginConfig'=> [
                  'format'=> 'yyyy-mm-dd',
                  'todayBtn'=> 'linked',
                  'todayHighlight'=> true,
                  'autoclose'=> true
                ]

            ],
            [
                'id' => 'TanggalPengadaan', 'label' => 'Tanggal Pengadaan', 'type' => 'date',
                /*'validation'=> [
                      'format'=> 'YYYY-MM-DD'
                ],*/
                'plugin'=> 'datepicker',
                'pluginConfig'=> [
                  'format'=> 'yyyy-mm-dd',
                  'todayBtn'=> 'linked',
                  'todayHighlight'=> true,
                  'autoclose'=> true
                ]

            ],
            ['id' => 'collections.ISOPAC', 
             'label' => 'OPAC', 
             'type' => 'integer',
             'input'=> 'radio',
             'values'=> ['1'=>'Tampil','0'=>'Tidak Tampil']
            ],
            [
                'id' => 'SUBSTR(IDJILID,6,4)', 
                'label' => 'Tahun Jilid', 
                'type' => 'integer',
                'input'=> 'text'

            ],
             
        ]
    ]
 ])?>
  <div class="form-group pull-right">
      <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Cari', ['class' => 'btn btn-primary btn-sm']); ?>
      <?php //echo Html::resetButton('Ulangi',['class' => 'btn btn-default']); 
        echo Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Ulangi'), ['index'], ['class' => 'btn btn-info btn-sm']);
      ?>
  </div>
 <?php QueryBuilderForm::end() ?>
 </div>

</div>