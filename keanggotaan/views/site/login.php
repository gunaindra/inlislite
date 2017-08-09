<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;


$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<div class="row">
    <div class="col-sm-5">
        <div class="box-body" style="padding:70px 0">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <h4>Login Anggota</h4>

    
        
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'login-form',
                ]
            ); ?>
         <div class="login-form">
                <?= $form->field($model, 'noanggota', $fieldOptions1)->textInput(array('placeholder' => 'No.Anggota'))->label(false) ?>

                <?= $form->field($model, 'password',$fieldOptions2)->passwordInput(array('placeholder' => 'Password'))->label(false) ?>

                <?php // $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <div class="col-sm-3">
                    <?= Html::submitButton('Masuk', ['class' => 'btn btn-success btn-md btn-block', 'name' => 'login-button']) ?>
                    </div>
                    <div class="col-sm-9"><?= Html::a('Lupa password / No. Anggota ?', ['site/request-password-reset']) ?>.</div>
                </div>
               <br/>
                <hr>
                <div class="form-group">
                    <h4><?= Html::a('Pendaftaran Anggota',['../pendaftaran/'], ['class' => '', 'name' => 'login-button','onClick'=>'GoToPagePendaftaran();']) ?></h4>
                </div>

            <?php ActiveForm::end(); ?>
        
    
    <div class="col-sm-6"></div>          
    </div>
</div>
