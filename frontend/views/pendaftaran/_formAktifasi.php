<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Pengaktifan Keanggotaan Online';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$url2           = Url::to('anggota-aktif');
$ajaxOptions    = [
	'type' => 'POST',
	'url'  => $url2,
	'data' => array(
		'NoAnggota' => new yii\web\JsExpression('function(){ return $("#dynamicmodel-memberno").val(); }'),
		'Password' => new yii\web\JsExpression('function(){ return $("#dynamicmodel-password").val(); }'),
	),

	'success'=>new yii\web\JsExpression('function(data){
				if(data == "sukses"){
                       swal({
                            title:" ",
                            text: "Anggota sudah berhasil terdaftar.",
                            type: "success",
                             timer: 1700,
                            cancelButtonText: "Tutup",
                            closeOnConfirm: true,
                          });
                          $("#dynamicmodel-memberno").val("");
                          $("#dynamicmodel-password").val("");

                }else if(data == "already"){
					 swal({
                            title:" ",
                            text: "Maaf No.Anggota " + $("#dynamicmodel-memberno").val() + " sudah pernah terdaftar disistem kami, \n Silahkan hubungi bagian layanan keanggotaan untuk bantuan.",
                            type: "warning",
                             timer: 3000,
                            cancelButtonText: "Tutup",
                            closeOnConfirm: true,
                          });
                }else{
					 swal({
                            title:" ",
                            text: "Maaf No.Anggota " + $("#dynamicmodel-memberno").val() + " tidak terdaftar disistem kami, \n Silahkan hubungi bagian layanan keanggotaan untuk bantuan pengaktifan.",
                            type: "warning",
                             timer: 3000,
                            cancelButtonText: "Tutup",
                            closeOnConfirm: true,
                          });
                 }
                   }'),

];
?>
<center>
<div class="site-reset-password">

	<div class="row">
		<div class="col-md-12">
			<?php $form = ActiveForm::begin(['id' => 'reset-password-form','layout' => 'horizontal','enableAjaxValidation' => true,]); ?>

			<?= $form->field($model, 'memberNo')->label('No.Anggota *') ?>

			<?= $form->field($model, 'password')->passwordInput()->label('Password / Kata Sandi * <p><span class="label label-info">(minimal 6 karakter)</span></p>') ?>

			<div class="form-group">
				<?php
				echo \common\widgets\AjaxButton::widget([
						'label' => Yii::t('app','Daftar Keanggotaan Online'),
						'ajaxOptions' => $ajaxOptions,
						'htmlOptions' => [
							'class' => 'btn btn-success btn-md',
							'id' => 'cari',
							'type' => 'submit'
						]
					]);
				?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
</center>
