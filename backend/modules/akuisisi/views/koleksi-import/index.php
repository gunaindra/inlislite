<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\QuarantinedCollectionSearch $searchModel
 */

$this->title = Yii::t('app', 'Import Data dari Excel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Akuisisi'), 'url' => Url::to(['/akuisisi'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quarantined-collections-index">
<?php 
$url = Yii::$app->urlManager->createUrl(['../uploaded_files/templates/datasheet/koleksi/sample_data_koleksi_AACR.xlsx']);
?>
    Template : <?= Html::a('Unduh Template', $url, ['class'=>'btn btn-primary btn-xs btn-flat']) ?>
    <br>
    <br>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','target'=>"hidden_iframe"]]) ?>

    <!-- $form->field($model, 'file')->fileInput() -->
    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
        'showMessage'=>true,
        'options'=>['accept'=>'.xls, .xlsx, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
        'pluginOptions'=>[
            'allowedFileExtensions'=>['xls','xlsx'],
            'showPreview' => false,
            'autoReplace' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => true,
            'uploadLabel' => Yii::t('app','Proses'),
            'uploadUrl' => Url::to(['proses']),
        ]
    ]);?>
   <?php 
   
   ?>

<?php ActiveForm::end() ?>

</div>
