<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\CollectionSearchKardeks;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\QuarantinedCollectionSearch $searchModel
 */
?>

<?php

echo GridView::widget([
    /* 'id'=>'myGrid3',
      'pjax'=>true, */
    'dataProvider' => $dataProvider,
    /* 'toolbar'=> [
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
      ], */
    'filterSelector' => 'select[name="per-page"]',
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'NomorBarcode',
        /* [
          'attribute'=>'Source_Id',
          'value'=>'source.Name',
          ],
          [
          'attribute'=>'Media_Id',
          'value'=>'media.Name',
          ],
          [
          'attribute'=>'Category_id',
          'value'=>'category.Name',
          ], */
        'CallNumber',
        /*            [
          'attribute'=>'Rule_id',
          'value'=>'rule.Name',
          ],
          [
          'attribute'=>'Location_id',
          'value'=>'location.Name',
          ],
          [
          'attribute'=>'Status_id',
          'value'=>'status.Name',
          ], */
        'akses',
        'lokasi',
        'ketersediaan'
    ],
    'summary' => false,
    'responsive' => true,
    'containerOptions' => ['style' => 'font-size:13px'],
    'hover' => true,
    'condensed' => true,
    'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
    'options' => ['font-size' => '12px']
]);
?>
