<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\JenisAnggotaSearch $searchModel
 */
$this->title = Yii::t('app', 'Jenis Anggotas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['#']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member'), 'url' => Url::to(['/setting/member'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-anggota-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
          'modelClass' => 'Jenis Anggota',
          ]), ['create'], ['class' => 'btn btn-success']) */ ?>
    </p>
    <?php //echo \common\components\PageSize::widget();  ?>
    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // set your toolbar
        'toolbar' => [
            ['content' =>
                \common\components\PageSize::widget(
                        [
                            'template' => '{label} <div class="col-sm-8" style="width:175px">{list}</div>',
                            'label' => 'Tampilkan :',
                            'labelOptions' => [
                                'class' => 'col-sm-4 control-label',
                                'style' => [
                                    'width' => '75px',
                                    'margin' => '0px',
                                    'padding' => '0px',
                                ]
                            ],
                            'sizes' => Yii::$app->params['pageSize'],
                            'options' => [
                                'id' => 'aa',
                                'class' => 'form-control'
                            ]
                        ]
                )
            ],
            //'{toggleData}',
            '{export}',
        ],
        'filterSelector' => 'select[name="per-page"]',
        'columns' => 
        [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 30px;'],
            ],
            'jenisanggota',

            [
                'attribute'=>'MasaBerlakuAnggota',
                'label'=>Yii::t('app','Masa Berlaku Anggota (hari)'),
                'contentOptions' => ['style' => 'width: 30px;'],
            ],
            'BiayaPendaftaran',
            'BiayaPerpanjangan',
            'MaxPinjamKoleksi',
            // 'UploadDokumenKeanggotaanOnline:boolean',
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'UploadDokumenKeanggotaanOnline',

            ],
            //[
            //  'attribute' => 'jenisanggota',
            // 'contentOptions'=>['style'=>'width: 550px;'],
            //],
            /* [
              'attribute' => 'BiayaPendaftaran',
              'contentOptions'=>['style'=>'width: 30px;'],
              'header'=>'Pendaftaran'
              ],
              [
              'attribute' => 'BiayaPerpanjangan',
              'contentOptions'=>['style'=>'width: 30px;'],
              'header'=>'Perpanjangan'
              ],

              'MaxPinjamKoleksi', */
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Yii::t('app', 'Default Kategori <br/> Koleksi'), Yii::$app->urlManager->createUrl(['setting/member/jenis-anggota/default-kategori', 'id' => $data->id]), [
                                'title' => Yii::t('app', 'Default Kategori Koleksi'),
                                'class' => 'btn btn-warning btn-sm'
                    ]);
                },
                'contentOptions' => ['style' => 'width: 50px;'],
            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Yii::t('app', 'Default Lokasi <br/> Perpustakaan'), Yii::$app->urlManager->createUrl(['setting/member/jenis-anggota/default-lokasi', 'id' => $data->id]), [
                        'title' => Yii::t('app', 'Default Lokasi Perpustakaan'),
                        'class' => 'btn btn-success btn-sm'
                        ]);
                },
                'contentOptions' => ['style' => 'width: 150px;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'max-width: 100px;'],
                'template' => '<div class="btn-group-vertical"> {update} {delete} </div>',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), Yii::$app->urlManager->createUrl(['setting/member/jenis-anggota/update', 'id' => $model->id, 'edit' => 't']), [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'btn btn-primary btn-sm'
                            ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Delete'), Yii::$app->urlManager->createUrl(['setting/member/jenis-anggota/delete', 'id' => $model->id, 'edit' => 't']), [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            ],
                            ]);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Download'), Yii::$app->urlManager->createUrl(['setting/member/jenis-anggota/delete', 'id' => $model->id, 'edit' => 't']), [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            ],
                            ]);
                    },
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
        'type' => 'info',
        'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']),
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
        'showFooter' => false
        ],
        ]);
        Pjax::end();
?>

</div>
