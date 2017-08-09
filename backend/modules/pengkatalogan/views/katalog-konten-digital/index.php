<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\components\DirectoryHelpers;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\CollectionSearch $searchModel
 */

$this->title = Yii::t('app', 'Daftar Konten Digital');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pengkatalogan'), 'url' => Url::to(['/pengkatalogan'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogfiles-index">
<?php  echo $this->render('_searchAdvanced', ['model' => $searchModel,'rules' => $rules]); ?>

<div class="form-group" style="padding-bottom:30px">
  <div class="col-md-3">
      <?php 
  echo Select2::widget([
    'id' => 'cbActioncheckbox',
    'name' => 'cbActioncheckbox',
    'data' => array(
            'REMOVE'=>'Hapus Data'),
    'size'=>'sm',
]);

  ?>
  </div>
   <div id="actionDropdown"></div>
   <div class="col-md-4">
    <?php 
    echo Html::button('<i class="glyphicon glyphicon-check"></i> Proses', [
                        'id'=>'btnCheckprocess',
                        'class' => 'btn btn-primary btn-sm', 
                        'title' => 'Proses', 
                        //'data-toggle' => 'tooltip'
                    ]);
    ?>
    </div>
</div>
<div class="catalogs-salin-index">
    	 <?php Pjax::begin(['id' => 'myGridview','linkSelector'=>false]); 
    	 echo GridView::widget([
        'id'=>'myGrid',
        'pjax'=>false,
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
                'attribute'=>'CreateDate',
                'format' => 'date',
            ],
            [
               //'label'=>'Nama',
               'format'=>'raw',
               'attribute'=>'FileURL',
               'value' => function($data){
                  $modelcat = \common\models\Catalogs::findOne($data->Catalog_id);
                   $worksheetDir=DirectoryHelpers::GetDirWorksheet($modelcat->Worksheet_id);
                   $url = '../../../uploaded_files/dokumen_isi/'.$worksheetDir.'/'.'/'.$data->FileURL;
                   return Html::a($data->FileURL, $url, ['title' => $data->FileURL,'target' => '_blank']); 
               }
            ],
            [
                'attribute'=> 'FileType',
                'value'=> function($data)
                {
                  $modelcat = \common\models\Catalogs::findOne($data->Catalog_id);
                   $worksheetDir=DirectoryHelpers::GetDirWorksheet($modelcat->Worksheet_id);
                   $url = Yii::getAlias('@uploaded_files/dokumen_isi').'/'.$worksheetDir.'/'.$data->FileURL;
                   if(file_exists($url))
                   {
                      return mime_content_type($url); 
                   }else{
                      return 'N/A';
                   }
                }
            ],
            [
                'attribute'=> 'FileSize',
                'value'=> function($data)
                {
                  $modelcat = \common\models\Catalogs::findOne($data->Catalog_id);
                   $worksheetDir=DirectoryHelpers::GetDirWorksheet($modelcat->Worksheet_id);
                   $url = Yii::getAlias('@uploaded_files/dokumen_isi').'/'.$worksheetDir.'/'.$data->FileURL;
                   if(file_exists($url))
                   {
                     $byte = filesize($url);
                     $kilobyte = round($byte / 1000,2);
                     $megabyte = round($kilobyte / 1000,2);
                     if($byte >= 1000000)
                     {
                          $result = (string)$megabyte.' MB';
                     }else 
                     {
                          $result = (string)$kilobyte.' KB';
                     }
                      return $result; 
                   }else{
                      return 'N/A';
                   }
                }
            ],
            'BIBID',
            [
                'attribute'=>'DataBib',
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                /*'contentOptions'=>['style'=>'width: 250px;'],*/
                'template' => '<div class="btn-group-vertical">{delete}</div>',
                'buttons' => [
                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app', 'Delete'), Yii::$app->urlManager->createUrl(['pengkatalogan/katalog-konten-digital/delete','id' => $model->ID,'edit'=>'t']), [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        //'data-toggle' => 'tooltip',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data' => [
                                                            'confirm' => Yii::t('yii','Are you sure you want to delete this item?'),
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
            //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> ', ['create'], ['class' => 'btn btn-success','title' => Yii::t('app','Add'),'data-toggle' => 'tooltip',]),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
 </div>

 </div>

 <?php 
    $this->registerJs(' 
    $(document).ready(function(){
        $(\'#btnCheckprocess\').click(function(){
            var CekAction = $(\'#cbActioncheckbox\').val();
            var CekId = $(\'#myGrid\').yiiGridView(\'getSelectedRows\');
            if(CekId.length == 0){
                alertSwal(\'Harap pilih data konten digital.\',\'error\',\'2000\');
                return;
            }
            if (CekAction === \'REMOVE\')
            {
                swal(
                {   
                  title: "Apakah anda yakin?",   
                  text: "berkas akan terhapus secara permanen",   
                  showCancelButton: true,   
                  closeOnConfirm: false,   
                  showLoaderOnConfirm: true,
                  confirmButtonColor: "#DD6B55",   
                  confirmButtonText: "OK, Hapus!",
                  cancelButtonText: "Tidak",  
                }, 
                function(){   
                  $.ajax({
                      type: \'POST\',
                      url : "'.Yii::$app->urlManager->createUrl(["pengkatalogan/katalog-konten-digital/checkbox-process"]).'",
                      data : {row_id: CekId, action: CekAction},
                      success : function(response) {
                          $.pjax.reload({container:"#myGridview", async:false});
                          alertSwal(\'Data terpilih berhasil dihapus.\',\'success\',\'2000\');
                      },
                  });
                });
                
            }
            
        });
    });', \yii\web\View::POS_READY);

?>