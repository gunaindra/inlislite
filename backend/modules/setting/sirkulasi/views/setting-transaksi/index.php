<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Collectioncategorys $model
 */

$this->title = Yii::t('app', 'Pengaturan Setting Transaksi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['#']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sirkulasi'), 'url' => Url::to(['/setting/sirkulasi'])];
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">
	.col-sm-4 label{
		font-weight: normal;
	}

	.table{
		margin-bottom: 0px;
	}

	.form-group > .col-md-offset-2, .col-md-10{
		margin-left: 0px;
	}
</style>

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);  ?>

<div class="settingparameters-create">
	<div class="page-header">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
	</div>
    <div class="settingparameters-form">
      <div class="form-group">
        <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); ?>

        <?= $form->field($model, 'IsCetakSlipPeminjaman')->checkbox(array('label'=>'Ya'))->label('Cetak Slip Peminjaman'); ?>
        <?= $form->field($model, 'IsCetakSlipPengembalian')->checkbox(array('label'=>'Ya'))->label('Cetak Slip Pengembalian'); ?>
        <?php //echo $form->field($model,'Value4')->radioList(['Simple'=>Yii::t('app', 'Simple'),'Advance'=>Yii::t('app', 'Advance')], ['inline'=>true])->label(Yii::t('app', 'Entry Form Collection'))?>

        </div>
    </div>

</div>


<?php ActiveForm::end();  ?>