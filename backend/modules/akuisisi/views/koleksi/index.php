<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\CollectionSearch $searchModel
 */
switch ($for) {
    case 'koleksi':
        $title = Yii::t('app', 'Collections');
        $datacheckbox = array(
            'OPAC1'=>'Tampil di OPAC',
            'OPAC0'=>'Jangan tampil di OPAC',
            'MEDIA'=>'Pilih Bentuk Fisik',
            'SUMBER'=>'Pilih Sumber',
            'KATEGORI'=>'Pilih Kategori',
            'AKSES'=>'Pilih Akses',
            'STATUS'=>'Pilih Ketersediaan',
            'LOKASI'=>'Pilih Lokasi Perpustakaan dan Ruang',
            //'LOKASI'=>'Pilih Lokasi Ruang',
            'CETAKLABEL'=>'Cetak Label',
            'KERANJANG1'=>'Masukan ke Keranjang Koleksi',
            'KARANTINA'=>'Karantina Data');
        $template = '<div class="btn-group-vertical"></div>';
        break;
    case 'keranjang':
        $title = Yii::t('app', 'Keranjang Koleksi');
        $datacheckbox = array(
            'OPAC1'=>'Tampil di OPAC',
            'OPAC0'=>'Jangan tampil di OPAC',
            'MEDIA'=>'Pilih Bentuk Fisik',
            'SUMBER'=>'Pilih Sumber',
            'KATEGORI'=>'Pilih Kategori',
            'AKSES'=>'Pilih Akses',
            'STATUS'=>'Pilih Ketersediaan',
            'LOKASI'=>'Pilih Lokasi Perpustakaan dan Ruang',
            //'LOKASI'=>'Pilih Lokasi Ruang',
            'CETAKLABEL'=>'Cetak Label',
            'KERANJANG0'=>'Hapus dari Keranjang Koleksi',
            'KARANTINA'=>'Karantina Data');
        $template= '<div class="btn-group-vertical"></div>';
        break;
    case 'karantina':
        $title = Yii::t('app', 'Karantina Koleksi');
        $datacheckbox = array();
        $template='<div class="btn-group-vertical">{restore}</div>';
        break;
    
    default:
        # code...
        break;
}
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Akuisisi'), 'url' => Url::to(['/akuisisi'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  .standard-error-summary
  {
    background-color: #faffe1;
    padding: 5px;
    border:dashed 1px #cccccc;
    margin-bottom: 10px;
    font-size: 12px;
    margin: 10px;
  }
</style>

<div class="collections-index">
<?php  echo $this->render('_searchAdvanced', ['model' => $searchModel,'rules' => $rules]); ?>
<?php 
if($for != 'karantina'){
?>
<div class="row form-group">
  <label for="inputType" class="col-md-1 control-label control-label-sm">Aksi</label>
  <div class="col-md-3">
      <?php 

  echo Select2::widget([
    'id' => 'cbActioncheckbox',
    'name' => 'cbActioncheckbox',
    'data' => $datacheckbox,
    'size'=>'sm',
    /*'pluginOptions' => [
        'allowClear' => true
    ],*/
    //'theme' => Select2::THEME_BOOTSTRAP,
    'pluginEvents' => [
        "select2:select" => 'function() { 
            var id = $("#cbActioncheckbox").val();
             isLoading=true;
             $.ajax({
                type     :"POST",
                cache    : false,
                url  : "'.Yii::$app->urlManager->createUrl(["akuisisi/koleksi/get-dropdown"]).'?id="+id,
                success  : function(response) {
                    $("#actionDropdown").html(response);
                }
            });
        }',
    ]
]);

  ?>
  </div>
   <div id="actionDropdown"></div>
    <div class="col-md-1">
    <?php 
    echo Html::button('<i class="glyphicon glyphicon-check"></i> Proses', [
                        'id'=>'btnCheckprocess',
                        'class' => 'btn btn-primary btn-sm', 
                        'title' => 'Proses', 
                        //'data-toggle' => 'tooltip'
                    ]);
    ?>
    </div>

    <div class="col-md-1" style="padding-left: 5px;">
    <?php 
    if($for == 'keranjang'){
    echo Html::button('<i class="glyphicon glyphicon-trash"></i> Kosongkan Keranjang', [
                        'id'=>'btnKosongkanKeranjang',
                        'class' => 'btn btn-danger btn-sm', 
                        'title' => 'Kosongkan Keranjang', 
                        'onclick'=> '
                            swal({   
                                title: "'.Yii::t('yii','Apakah anda yakin menkosongkan keranjang?').'",      
                                showCancelButton: true,   
                                confirmButtonColor: "#DD6B55",   
                                confirmButtonText: "Ya, kosongkan!",  
                                cancelButtonText: "Tidak", 
                                closeOnConfirm: false }, 

                                function(){   
                                   window.location="'.Yii::$app->urlManager->createUrl(["akuisisi/koleksi/keranjang-reset"]).'";
                            });
                        '
                    ]);
    }
    ?>
    </div>
</div>

<div id="checkError"></div>

<?php
}
?>
    <?php
    echo  $urlcombine;
     Pjax::begin(['id' => 'myGridviewListColl']); echo GridView::widget([
        'id'=>'myGridListColl',
        'pjax'=>true,
        'dataProvider' => $dataProvider,
		'toolbar'=> [
            ['content'=>
                 \common\components\PageSize::widget(
                    [
                        'template'=> '{label} <div class="col-sm-8" style="width:175px">{list}</div>',
                        'label'=>Yii::t('app', 'Showing :'),
                        'labelOptions'=>[
                            'class'=>'col-sm-4 control-label',
                            'style'=>[
                                'width'=> '75px',
                                'margin'=> '0px',
                                'padding'=> '0px',
                            ]

                        ],
                        'sizes'=>Yii::$app->params['pageSize'],
                        'options'=>[
                            'id'=>'aa',
                            'class'=>'form-control'
                        ]
                    ]
                 )

            ],

            //'{toggleData}',
            '{export}',
        ],
        'filterSelector' => 'select[name="per-page"]',
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class'       => '\kartik\grid\CheckboxColumn',
                'pageSummary' => true,
                'rowSelectedClass' => GridView::TYPE_INFO,
                'name' => 'cek',
                'checkboxOptions' => function ($searchModel, $key, $index, $column) {
                    return [
                        'value' => $searchModel->ID
                    ];
                },
                'vAlign' => GridView::ALIGN_TOP
            ],
            ['class' => 'yii\grid\SerialColumn'],
            [
                 //'label'=>'Nama',
                 'format'=>'raw',
                 'attribute'=>'NomorBarcode',
                 'value' => function($data) use ($for){
                     if($for=='karantina')
                     {
                        $url = Url::to(['viewkarantina','id'=>$data->ID,'edit'=>'t']);
                     }else{
                        $url = Yii::$app->urlManager->createUrl(['/pengkatalogan/katalog/update','for' => 'coll','rda' => (int)$data->catalog->IsRDA,'id'=>$data->ID,'edit'=>'t']);
                     }
                     
                     return Html::a($data->NomorBarcode, $url, ['title' => $data->NomorBarcode]); 
                 }
            ],
            //'RFID',
            [
                'attribute'=>'TanggalPengadaan',
                'format' => 'date',
            ],
            'NoInduk',
            [
                'attribute'=>'DataBib',
                //'value'=>'source.Name',
                'format' => 'raw',
            ],
            [
                'attribute'=>'Media_id',
                'value'=>'media.Name',
            ],
            [
                'attribute'=>'Source_id',
                'value'=>'source.Name',
            ],
            [
                'attribute'=>'Category_id',
                'value'=>'category.Name',
            ],
            [
                'attribute'=>'Rule_id',
                'value'=>'rule.Name',
            ],
            [
                'attribute'=>'Status_id',
                'value'=>'status.Name',
            ],
            [
                'attribute'=>'Location_Library_id',
                'value'=>'locationLibrary.Name',
            ],
            [
                'attribute'=>'Location_id',
                'value'=>'location.Name',
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'ISOPAC', 
                'vAlign'=>'top'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                /*'contentOptions'=>['style'=>'width: 250px;'],*/
                'template' => $template,
                'buttons' => [                       
                'restore' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-retweet"></span> '.Yii::t('app', 'Restore'), Yii::$app->urlManager->createUrl(['akuisisi/koleksi/restore','id' => $model->ID,'edit'=>'t']), [
                                                    'title' => Yii::t('app', 'Restore'),
                                                    //'data-toggle' => 'tooltip',
                                                    'class' => 'btn btn-success btn-sm',
                                                    'data' => [
                                                        'confirm' => Yii::t('yii','Are you sure you want to restore this item?'),
                                                        'method' => 'post',
                                                    ],
                                                  ]);},

                ],
            ],
        ],
        //'summary'=>'',
        'responsive'=>true,
        'containerOptions'=>['style'=>'font-size:12px'],
        'hover'=>true,
        'condensed'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
<input type="hidden" id="hdnUrlProsesCetakLabel" value="<?=Yii::$app->urlManager->createUrl(["akuisisi/koleksi/cetak-label-proses"])?>">
<?php 

    $this->registerJs(' 

    $(document).ready(function(){
    $(\'#btnCheckprocess\').click(function(){
        var CekAction = $(\'#cbActioncheckbox\').val();
        var CekActionDetail = $(\'#cbActionDetail\').val();
        var CekId = $(\'#myGridListColl\').yiiGridView(\'getSelectedRows\');
        if(CekId.length == 0){
            alertSwal(\'Harap pilih data koleksi.\',\'error\',\'2000\');
            return;
        }
        
        if(CekAction === \'LOKASI\')
        {
            CekActionDetail = $(\'#cbActionDetail2\').val();
        }

        if(CekAction === \'CETAKLABEL\')
        {
            var arrayId = {CekId} 
            var ids = jQuery.param(arrayId);
            var url =  $(\'#hdnUrlProsesCetakLabel\').val();
            var sumber = $(\'input:radio[name ="cbActionLabel1"]:checked\').val();
            var model = $(\'#cbActionLabel3\').val();
            var format = $(\'#cbActionLabel4\').val();
            CekActionDetail = sumber+"|"+model+"|"+format;

            window.location.href = url+\'?actids=\'+CekActionDetail+\'&\'+ids;
        }else{

            isLoading=true;
            if (CekAction === \'KARANTINA\')
            {
                swal(
                {   
                  title: "Apakah anda yakin?",   
                  text: "akan memindahkan data ini ke karantina",   
                  showCancelButton: true,   
                  closeOnConfirm: false,   
                  showLoaderOnConfirm: true,
                  confirmButtonColor: "#DD6B55",   
                  confirmButtonText: "OK, Karantinakan!",
                  cancelButtonText: "Tidak",  
                }, 
                function(){   
                    $.ajax({
                        type: \'POST\',
                        url : "'.Yii::$app->urlManager->createUrl(["akuisisi/koleksi/checkbox-process"]).'",
                        data : {row_id: CekId, action: CekAction, actionid : CekActionDetail},
                        success : function(response) {
                          $(\'#checkError\').html(response);
                          $.pjax.reload({container:"#myGridviewListColl",async:false});  //Reload GridView
                          alertSwal(\'Data terpilih berhasil diproses.\',\'success\',\'2000\');
                        }
                    });
                });
            }else{
                $.ajax({
                    type: \'POST\',
                    url : "'.Yii::$app->urlManager->createUrl(["akuisisi/koleksi/checkbox-process"]).'",
                    data : {row_id: CekId, action: CekAction, actionid : CekActionDetail},
                    success : function(response) {
                      $.pjax.reload({container:"#myGridviewListColl",async:false});  //Reload GridView
                      alertSwal(\'Data terpilih berhasil diproses.\',\'success\',\'2000\');
                    }
                });
            }
            

            
        }

    });
    });', \yii\web\View::POS_READY);

?>
