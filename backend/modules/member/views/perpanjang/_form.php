<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\widgets\MaskedDatePicker;

/**
 * @var yii\web\View $this
 * @var common\models\MemberPerpanjangan $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="member-perpanjangan-form">
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,]); ?>

    <div class="page-header">
        <!-- Button -->
        <?php
        echo Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']);
        echo '&nbsp;' . Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']);
        ?>
        <!-- ./Button -->
    </div>

    <?php
    $member_name = (new \yii\db\Query())
            ->from('members')
            //\common\models\Members::find()
            ->select(['(CONCAT(MemberNo," - ",Fullname)) as label'])
            //->asArray()
            ->all();

    echo $form->field($model, 'Member_id', [
    ])->widget(AutoComplete::className(), [
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'Masukan Anggota',
            'style' => 'width:300px;',
            'maxlength' => 255,
        ],
        'clientOptions' => ['source' => $member_name]
    ])->label(Yii::t('app', 'Anggota'));
    ?>
    <div class="form-group field-memberperpanjangan-biaya" id="MasaBerlaku" >
        <label class="control-label col-md-2" for="memberperpanjangan-biaya">Masa Berlaku Anggota Saat Ini </label>
        <div class="col-md-10">
            <label  id="IsiMasaBerlaku" class="control-label" style="font-size: 13px;" for="memberperpanjangan-biaya"></label>

        </div>
    </div>

<?php
echo $form->field($model, 'Biaya')->textInput([
    'placeholder' => $model->getAttributeLabel('Biaya'),
    //'readonly'=>true,
    //'value'=>$memberNo,
    'style' => 'font-weight:bold;width:250px;',
    'type' => 'number',
    'maxlength' => 10
]);
echo $form->field($model, 'Tanggal')->widget(MaskedDatePicker::classname(), [
    'enableMaskedInput' => true,
    'maskedInputOptions' => [
        'mask' => '99-99-9999',
        'pluginEvents' => [
            'complete' => "function(){console.log('complete');}"
        ]
    ],
    'removeButton' => false,
    'options' => [
        'style' => 'width:170px',
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'mm-dd-yyyy',
    ]
])->label(Yii::t('app', 'Tanggal Berakhir'));

echo $form->field($model, 'IsLunas')->checkbox()->label('Lunas');
echo $form->field($model, 'Keterangan', [
])->textArea([
    'placeholder' => Yii::t('app', 'Keterangan'),
    'style' => 'width:350px;',
    'maxlength' => 255,
]);




ActiveForm::end();
?>

</div>
    <?php
    $this->registerJs("
	 $(document).ready(function(){
	 	$('#MasaBerlaku').hide();
	    $('#memberperpanjangan-member_id').focusout(function(){
	    	 var NoAnggota = $('#memberperpanjangan-member_id').val();
	    	 var res = NoAnggota.split('-');
	       	 $.getJSON('check-membership',{ memberNo : res[0] },function(data){

	       	 		$('#MasaBerlaku').show();
	       	 		$('#IsiMasaBerlaku').html(data.EndDate);
	       	 		$('#memberperpanjangan-biaya').val(data.Biaya);
		            //alert(data.Fullname);
	        	
	        }).error(function(jqXHR) {
			    if (jqXHR.status == 404) {
			    	$('#MasaBerlaku').hide();
			    	$('#memberperpanjangan-member_id').val('');
			    	$('#memberperpanjangan-member_id').focus();
			        //alert(\"No.Anggota tidak ditemukan.\");
			    } else {
			        alert(\"Other non-handled error type\");
			    }
			});
	    });
	});

");
    ?>