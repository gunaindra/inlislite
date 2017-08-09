<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\CollectioncategorySearch $searchModel
 */

$this->title = Yii::t('app', 'Histori Pencarian Telusur');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LKD'), 'url' => ['#']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'History'), 'url' => Url::to(['/lkd/history'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historyopac-index">
    <div class="page-header">
           
    </div>
  

    <p>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // set your toolbar
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
            '{export}',
        ],
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'waktu',
        	'User_id',
            'ip',           
            
             [
                'attribute'=> 'keyword',
                //'value'=>'source.Name',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(Html::encode($model->keyword),$model->url);
                }
            ],  
            'jenis_bahan',

        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',       
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app','Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
