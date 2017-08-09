<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use unclead\widgets\TabularInput;
use unclead\widgets\MultipleInput;


use common\models\Formats;
use common\models\Fields;
use common\models\Worksheets;

/**
 * @var yii\web\View $this
 * @var common\models\Worksheets $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="worksheets-form">
    <div class="col-xs-6 col-sm-6">
        <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]]); 

        echo '<div class="page-header">'. Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Create'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        echo  '&nbsp;' . Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) . '</div>';

        ?>

  


        <?php

        if ($model->isNewRecord) 
        {

            echo $form->field($model3, 'copyWorksheet')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Worksheets::find()->all(),'ID','Name'),
                'options' => ['placeholder' => 'Copy dari Jenis Bahan'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'addon' => [

                    'append' => [
                        'content' => Html::button('Proses', [
                            'class' => 'btn btn-primary prosesCopyWorksheet', 
                            'title' => 'Proses', 
                            //'data-toggle' => 'tooltip'
                        ]),
                        'asButton' => true
                    ]
                ],
                ])->label('Copy dari Jenis Bahan');
        } 
        

        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

            'Format_id'=>[
                'type'=>Form::INPUT_WIDGET, 
                'widgetClass'=>'\kartik\widgets\Select2', 
                'options'=>[
                    'data'=>ArrayHelper::map(Formats::find()->all(),'ID','Name'),
                        //'options'=> ['placeholder'=>Yii::t('app', 'Choose').' '.Yii::t('app', 'Format')], 
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width'=> '200px',
                            'disabled' => true,
                        ],

                ],
            ],

//'Format_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Format').'...']], 

            'CODE'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Kode').'...', 'maxlength'=>10]], 

            'Name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Nama').'...', 'maxlength'=>100]], 
            'Keterangan'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Keterangan').'...', 'maxlength'=>255]], 

            'NoUrut'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'No Urut').'...']], 

            'ISSERIAL'=>['type'=> Form::INPUT_CHECKBOX, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Isserial').'...']], 
            'ISMUSIK'=>['type'=> Form::INPUT_CHECKBOX, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Ismusik').'...'],'label'=>'Musik'], 

//'CardFormat'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Card Format').'...', 'maxlength'=>100]], 

//'DEPOSITFORMAT_CODE'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'Depositformat  Code').'...', 'maxlength'=>5]], 

            ]


            ]);

            ?> 
            <div class="form-horizontal"> <!-- hidden="hidden" -->
                <table class="table" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <td class="col-sm-3">
                                <label class="control-label">
                                &nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= Yii::t('app','Tag') ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-12" style="padding: 0;">
                                 <?php   echo TabularInput::widget([
                                    'models' => $model2,


                                    'allowEmptyList'    => false,
                                    'limit' => 80,


                                    'columns' => [
                                    [
                                        'name'  => 'Field_id',
                                        // 'type'  => 'dropDownList',
                                        'type'  => \kartik\widgets\Select2::className(),
                                        'title' => 'Tag',
                                        'options' => [
                                            'data' => ArrayHelper::map(Fields::find()->all(),'ID','Name') , 
                                            'pluginOptions' => [
                                                // 'todayHighlight' => true
                                            ]
                                        ],
                                        // 'items' => ArrayHelper::map(Fields::find()->all(),'ID','Name')  
                                    ],

                                    ],
                                    ]) ;
                                    ?>      

                                </div>
                                <div class="padding0 col-sm-9"><b class="hint-uang"></b></div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>

                <?php





            ActiveForm::end(); ?>

    </div>
</div>

<?php
    $this->registerJs("
    $('.prosesCopyWorksheet').click(function(){
        //alert('halo');
        var CopyWorkID = $('#dynamicmodel-copyworksheet').val();
        window.location = 'create?copy=' + CopyWorkID;
    });
");


?>