<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CollectionloanitemSearch $searchModel
 */

$this->title = Yii::t('app', 'Daftar Peminjaman');
$this->params['breadcrumbs'][] = 'Sirkulasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collectionloanitems-index">
   
    <div class="page-header">
        
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','Add'), ['create'], ['class' => 'btn btn-success'])
//Html::encode($this->title) ?>
    </div>

    <?php  echo $this->render('_search', ['model' => $searchModel,'rules' => $rules]); ?>
    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
		'toolbar'=> [
            ['content'=>
                 \common\components\PageSize::widget(
                    [
                        'template'=> '{label} <div class="col-sm-8" style="width:175px">{list}</div>',
                        'label'=>'Tampilkan :',
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
        //'emptyCell'=>'-',
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
            //'CollectionLoan_id',
            [
                'attribute'=>'CollectionLoan_id', 
                'width'=>'310px',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) { 

                    $col  =  "Nomor Transaksi : <b>" . $model->CollectionLoan_id . "</b><br/>" ;
                    $col .=  "No.Anggota      : <b>" .
                        Html::a(Yii::t('app',  $model->member->MemberNo), ['detail-anggota','memberNo'=>$model->member->MemberNo], ['data-toggle'=>"modal",
                            'data-target'=>"#myModal",
                            'data-title'=>"Detail Data Anggota",]). "</b><br/>" ;
                    $col .=  "Nama Anggota    : <b>" . $model->member->Fullname . "</b>" ;
                    return "<pre>".$col."</pre>";
                },
               
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
               
            ],
            [
                'attribute'=>'collection.NomorBarcode',
                'contentOptions'=>['style'=>'max-width: 100px;'],
                
            ],
            //'collection.RFID',
            [
                'attribute'=>'collection.catalog.Title',
                'header'    => 'Judul',
                'contentOptions'=>['style'=>'max-width: 250px;'],
            ],
            [
                'attribute' => 'collection.catalog.Publisher',
                'header'    => 'Penerbit',
                'contentOptions'=>['style'=>'max-width: 90px;'],
            ],
            
            [
                'attribute'=>'LoanDate',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'contentOptions'=>['style'=>'max-width: 90px;'],
            ],
            [
                'attribute'=>'DueDate',
                'header'=>'Jatuh Tempo',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'contentOptions'=>['style'=>'max-width: 90px;'],
            ],
            [
                'attribute'=>'LateDays', 
                //'width'=>'310px',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) { 
                    $late = \common\components\SirkulasiHelpers::lateDays(date('Y-m-d') ,date("Y-m-d", strtotime($model->DueDate)));
                   if($late > 0){
                            // $html = '<span class="label label-danger">'.$late.' Hari</span>';
                            $html = $late;
                        }else{
                            // $html = '<span class="label label-warning">'.$late.' Hari</span>';
                            $html = $late;
                        }
                    
                    return $html;
                },
               
            ],

//            'LateDays',
//            'LoanStatus', 
//            'Collection_id', 
//            'member_id', 
//            ['attribute'=>'KIILastUploadDate','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

            [
                'class' => 'yii\grid\ActionColumn',
				//'contentOptions'=>['style'=>'max-width: 20px;'],
                'template' => '{delete}',
                'buttons' => [
				'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"> '.Yii::t('app', 'Edit').'</span>', Yii::$app->urlManager->createUrl(['sirkulasi/peminjaman/update','id' => $model->ID,'edit'=>'t']), [
                                                    'title' => Yii::t('app', 'Edit'),
                                                    'class' => 'btn btn-primary btn-sm'
                                                  ]);},
												  
                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash">'.Yii::t('app', 'Delete').'</span>', Yii::$app->urlManager->createUrl(['sirkulasi/peminjaman/delete','id' => $model->CollectionLoan_id,'edit'=>'t']), [
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'data' => [
                                                        'confirm' => Yii::t('yii','Are you sure you want to delete this item?'),
                                                        'method' => 'post',
                                                    ],
                                                  ]);},

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
        'rowOptions'=>function ($model, $key, $index, $grid){
                    $style = array();
                    $warningLoanDueDay = \common\components\SirkulasiHelpers::getWarningLoanDueDay($model['Collection_id'],$model->member->MemberNo);

                    if (date('Y-m-d') > date("Y-m-d", strtotime($model['DueDate'])))// Warning Terlambat
                    {
                         $style = 'danger'; // Terlambat
                    }
                    elseif (\common\components\Helpers::addDayswithdate(date('Y-m-d'),$warningLoanDueDay) == date("Y-m-d", strtotime($model['DueDate'])))
                    {
                        $style = 'warning'; // Warning
                    }

                    return array('key'=>$key,'index'=>$index,'class'=>$style);
                },
        
        'containerOptions'=>['style'=>'font-size:11px'],
        'options'=>['font-size'=>'11px'],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','Add'), ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'size'=>'modal-lg',
    'header' => '<h4 class="modal-title">...</h4>',
]);

echo '<div id="myModal-body"></div>';

Modal::end();


$this->registerJs("
    isLoading = false;
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title')
        var href = button.attr('href')
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        });

");
?>
