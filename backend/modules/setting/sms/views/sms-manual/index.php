<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var common\models\Members $model
 */

$this->title = Yii::t('app', 'Kirim SMS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['#']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SMS'), 'url' => Url::to(['/setting/sms'])];
$this->params['breadcrumbs'][] = 'Kirim SMS';
?>

<?php $form = ActiveForm::begin(
    [
        'type'=>ActiveForm::TYPE_HORIZONTAL,
        'enableClientValidation' => true,
        'formConfig' => [
            'labelSpan' => '3',
            //'deviceSize' => ActiveForm::SIZE_TINY,
            'showErrors'=>false,
        ],
       /*'fieldConfig' => [
                        'template' => "<div class=\"row\">
                                        \n<div class=\"col-sm-12\">{label} {input}</div>
                                        \n
                                        <div class=\"col-xs-offset-3 col-xs-9\">
                                        <div style=\"margin-top: 5px;margin-bottom: 10px;\"></div></div>
                                        </div>",
                    ],*/
    ]
    );
?>
<div class="row-fluid control-label-narrow">
    <div class="page-header">
        <h3>
            &nbsp;
            <!-- <span class="glyphicon glyphicon-plus-sign"></span> Tambah -->

            <div class="pull-left">
            <?php
               /* echo '<p>';
                echo  Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Create'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                echo  '&nbsp;' . Html::a(Yii::t('app', 'Salin dari Data Kependudukan'), ['detail-kependudukan'], ['class' => 'btn btn-primary','data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Detail Data",]);
                echo  '&nbsp;' . Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-warning']);
                
                //echo  '&nbsp;' . Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) . '</p>';
                echo '</p>';*/
            ?>
            </div>
        </h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'form'=>$form,
        'modelDynamic' => $modelDynamic,    

    ]) ?>

<div class="rowa">
    <div class="col-sm-12" style="border-top: 1px solid #eee;margin-top: 10px ">
<br/>
        
            <?php
                echo '<p>';
                echo  Html::submitButton( Yii::t('app', 'Kirim SMS'), ['class' =>  'btn btn-success' ]);
                echo  '&nbsp;' . Html::a(Yii::t('app', 'Pilih Nomor'), ['detail-kependudukan'], ['class' => 'btn btn-primary','data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Detail Data",
                                                    'data-backdrop'=>"static",
                                                    ]);
                echo  '&nbsp;' . Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-warning']);
                
                //echo  '&nbsp;' . Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) . '</p>';
                echo '</p>';
            ?>
        
    </div>

</div>

<?php 





ActiveForm::end();
?>




<?php
Modal::begin([
    'id' => 'myModal',
    'size'=>'modal-lg',
    'header' => '<h4 class="modal-title">...</h4>',
    'clientOptions' => ['backdrop' => 'static'],
]);
 
echo '<div id="myModal-body"></div>';
 
Modal::end();






$this->registerJs("

    
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        isLoading = false;
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        });

");


?>

</div>
