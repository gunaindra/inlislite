<?php

/**
 * @link https://www.inlislite.perpusnas.go.id/
 * @copyright Copyright (c) 2015 Perpustakaan Nasional Republik Indonesia
 * @license https://www.inlislite.perpusnas.go.id/licences
 */
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
// Kartik Widgets
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use common\widgets\MaskedDatePicker;
// MODEL
use common\models\MasterJenisIdentitas;
use common\models\JenisKelamin;
use common\models\MasterPekerjaan;
use common\models\MasterPendidikan;
use common\models\Jenisanggota;
use common\models\Agama;
use common\models\KelasSiswa;
use common\models\Departments;
use common\models\MasterJurusan;
use common\models\MasterProgramStudi;
use common\models\MasterFakultas;
use common\models\MasterStatusPerkawinan;
use common\models\JenisPermohonan;
use common\models\StatusAnggota;
use common\models\LocationLibrary;
use common\models\Collectioncategorys;

/**
 * @var yii\web\View $this
 * @var common\models\Members $model
 * @var yii\widgets\ActiveForm $form
 */
$this->title = 'Pendaftaran Anggota Online';
?>


<div class="member-form" style="padding:1em;display:block;position:relative;top:-30px;">
<?php
$form = ActiveForm::begin();

// /$result = \yii\helpers\ArrayHelper::getColumn($membersForm, 'Member_Field_id');
?>
<style type="text/css">
 .error-summary
 {
   background-color: #faffe1 ;
   padding: 5px;
   border:dashed 1px #FF0000 ;
   margin-bottom: 10px;
   font-size: 12px;
   margin: 10px;
 }
</style>
    <div class="col-md-12">
   
        <table class="table borderless1" style="table-layout: fixed;">
        <p class="text-danger"> <?= $form->errorSummary($model); ?></p>

            <tbody>
                <tr id="jaminanIdentitas" >
                    <td class="pull-right"><?= Yii::t('app', 'No.Identitas') ?> <span class="require">*</span></td>
                    <td class="col-xs-9">
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-xs-6" style="padding: 0;">
<?=
$form->field($model, 'IdentityType_id')->widget('\kartik\widgets\Select2', [
    'data' => ArrayHelper::map(MasterJenisIdentitas::find()->all(), 'id', 'Nama'),
    'size' => Select2::SMALL,
    'pluginOptions' => [
        'allowClear' => true,
    ],
    'options' => ['placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Type Identity')]
])->label(false);
?>
                            </div>
                            <div class="col-xs-6">
<?=
$form->field($model, 'IdentityNo')->textInput(
        ['placeholder' => Yii::t('app', 'Masukkan nomor identitas')]
)->label(false);
?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pull-right">
                        Password / Kata Sandi <span class="require">*</span>
                        <p><span class="label label-info">(minimal 6 karakter)</span></p>
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                                <?=
                                $form->field($model, 'password')->passwordInput(
                                        [
                                            'placeholder' => Yii::t('app', 'Masukkan Password'),
                                            'minlength' => 6,
                                        ]
                                )->label(false);
                                ?>
                            </div>

                        </div>
                    </td>
                </tr>
                <?php
                //$val1 = common\components\MemberHelpers::customMemberForm(29, 2);
                //if ($val1) {
                    ?>  
                    <tr>
                        <td class="pull-right">
                            Email <span class="require">*</span>
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'Email')->textInput([
                                        'placeholder' => Yii::t('app', 'Email'),
                                        // 'style'=>'width:350px;',
                                        'maxlength' => 255,
                                    ])->label(false)
                                    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
<?php //} ?>
                <tr>
                    <td class="pull-right">
                        Nama Lengkap <span class="require">*</span>
                        <p><span class="label label-info">Sesuai kartu identias anda</span></p>
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                                <?=
                                $form->field($model, 'Fullname')->TextInput(
                                        [
                                            'placeholder' => Yii::t('app', 'Masukkan Nama Lengkap Anda Sesuai Kartu Identitas'),
                                            'maxlength' => 255,
                                        ]
                                )->label(false);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
<?php
$val2 = common\components\MemberHelpers::customMemberForm(25, 2);
if ($val2) {
    ?>  
                    <tr>
                        <td class="pull-right">
                            Nama Ibu Kandung
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'MotherMaidenName')->textInput([
                                        'placeholder' => Yii::t('app', 'MotherMaidenName'),
                                        // 'style'=>'width:350px;',
                                        'maxlength' => 255,
                                    ])->label(false)
                                    ?>

                                </div>

                            </div>
                        </td>
                    </tr>

<?php } ?>

                <tr>
                    <td class="pull-right">
                        Tempat/Tanggal Lahir <span class="require">*</span>
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-6" style="padding:0;">
                                <?=
                                $form->field($model, 'PlaceOfBirth')->TextInput(
                                        [
                                            'placeholder' => Yii::t('app', 'Masukkan Tempat Lahir'),
                                            'maxlength' => 255,
                                        ]
                                )->label(false);
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?=
                                $form->field($model, 'TglLahir', [
                                ])->widget(MaskedDatePicker::classname(), [
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
                                        'placeholder' => Yii::t('app', 'Masukkan Tgl Lahir'),
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'dd-mm-yyyy',
                                    ]
                                ])->label(false)
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
<?php
//$valJK = common\components\MemberHelpers::customMemberForm(15, 2);
//if ($valJK) {
    ?>  
                    <tr>
                        <td class="pull-right">
                            Jenis Kelamin <span class="require">*</span>
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'Sex_id', [
                                    ])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(JenisKelamin::find()->all(), 'ID', 'Name'),
                                        'size' => Select2::SMALL,
                                        'options' => [
                                            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Jenis Kelamin'),
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        //'width'=> '150px',
                                        ],
                                            ]
                                    )->label(false)
                                    ?>
                                </div>

                            </div>
                        </td>
                    </tr>
<?php// } ?>

<?php
//$valAlamatKTP = common\components\MemberHelpers::customMemberForm(5, 2);
//if ($valAlamatKTP) {
    ?>  
                    <tr>
                        <td class="pull-right">
                            Alamat tinggal sesuai identitas <span class="require">*</span>
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'Address', [])->textArea([
                                        'placeholder' => Yii::t('app', 'Masukkan Alamat tinggal sesuai identitas'),
                                        //'style'=>'width:350px;',
                                        'maxlength' => 255,
                                    ])->label(false)
                                    ?>

                                    <?php
                                    //$valProp = common\components\MemberHelpers::customMemberForm(7, 2);
                                    //if ($valProp) {
                                        ?>  
                                            <?php
                                            // List Propinsi
                                            $province_name = common\models\Propinsi::find()
                                                    ->select(['(NamaPropinsi) as label'])
                                                    ->asArray()
                                                    ->all();
                                            ?>
                                        <div class="col-sm-6" style="padding:0;">
                                            <?=
                                            $form->field($model, 'Province')->widget(AutoComplete::className(), [
                                                'options' => [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Masukan propinsi sesuai identitas',
                                                    //'style'=>'width:300px;',
                                                    'maxlength' => 255,
                                                ],
                                                'clientOptions' => ['source' => $province_name]
                                            ])->label(false)
                                            ?>

                                            <?php
                                            //$valKecamatan = common\components\MemberHelpers::customMemberForm(39, 2);
                                            //if ($valKecamatan) {
                                                echo $form->field($model, 'Kecamatan')->textInput([
                                                    'placeholder' => Yii::t('app', 'Kecamatan'),
                                                    // 'style'=>'width:350px;',
                                                    'maxlength' => 255,
                                                ])->label(false);
                                            //}
                                            ?>

                                            <?php
                                            $valRT = common\components\MemberHelpers::customMemberForm(41, 2);
                                            if ($valRT) {
                                                echo $form->field($model, 'RT')->textInput([
                                                    'placeholder' => Yii::t('app', 'RT'),
                                                    // 'style'=>'width:350px;',
                                                    'maxlength' => 255,
                                                ])->label(false);
                                            }
                                            ?>

                                        </div>
                                        <?php //} ?>
                                        <?php
                                        //$valKota = common\components\MemberHelpers::customMemberForm(6, 2);
                                        //if ($valKota) {
                                            ?>  
                                        <div class="col-sm-6" style="padding:0;">
                                            <?=
                                            $form->field($model, 'City')->widget(AutoComplete::className(), [
                                                'options' => [
                                                    'class' => 'form-control',
                                                    'placeholder' => $model->getAttributeLabel('City'),
                                                    //'style'=>'width:300px;',
                                                    'maxlength' => 255,
                                                ],
                                                'clientOptions' => [
                                                    'source' => new JsExpression('function(request, response) {
		                                   $.ajax({
		                                       url: "' . Url::to(['pendaftaran/kabupaten-list']) . '",
		                                       dataType: "json",
		                                       data: {
		                                           term: request.term,
		                                           prop: $("#members-province").val()
		                                       },
		                                       success: function (data) {
		                                               response(data);
		                                       }
		                                   })
		                                }'),
                                                ]
                                            ])->label(false)
                                            ?>

                                            <?php


                                            //$valKelurahan = common\components\MemberHelpers::customMemberForm(40, 2);
                                           // if ($valKelurahan) {

                                                echo $form->field($model, 'Kelurahan')->textInput([
                                                    'placeholder' => Yii::t('app', 'Kelurahan'),
                                                    // 'style'=>'width:350px;',
                                                    'maxlength' => 255,
                                                ])->label(false);
                                            //}
                                            ?>

                                            <?php
                                            $valRW = common\components\MemberHelpers::customMemberForm(42, 2);
                                            if ($valRW) {
                                                echo $form->field($model, 'RW')->textInput([
                                                    'placeholder' => Yii::t('app', 'RW'),
                                                    // 'style'=>'width:350px;',
                                                    'maxlength' => 255,
                                                ])->label(false);
                                            //}
                                            ?>

                                        </div>

    <?php// } ?>                           

                                </div>

                            </div>
                        </td>

                    </tr>
                                <?php } ?>

                <!-- Duplicate Alamat -->
                <tr>
                    <td class="pull-right">

                    </td>
                    <td>
                        <div class="checkbox">
                            <label><?=Html::checkbox('duplicateAddrs',false,['id'=>'duplicateAddrs'])?> Alamat tinggal sama dengan alamat Identitas</label>
                        </div>

                    </td>
                </tr>

<?php
                                //$valAlamatNow = common\components\MemberHelpers::customMemberForm(8,2);
                              //  if($val1){
                        ?>  
                <tr>
                    <td class="pull-right">
                        Alamat tinggal saat ini <span class="require">*</span>
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'AddressNow', [])->textArea([
                                        'placeholder' => Yii::t('app', 'Masukkan Alamat Tempat Tinggal Sekarang'),
                                        //'style'=>'width:350px;',
                                        'maxlength' => 255,
                                    ])->label(false)
                                    ?>

                                <?php
                                      //  $valPropNow = common\components\MemberHelpers::customMemberForm(10,2);
                                       // if($valPropNow){
                                ?>  
                                <div class="col-sm-6" style="padding:0;">
                                    <?=
                                    $form->field($model, 'ProvinceNow')->widget(AutoComplete::className(), [
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'Masukan propinsi saat ini',
                                            //'style'=>'width:300px;',
                                            'maxlength' => 255,
                                        ],
                                        'clientOptions' => ['source' => $province_name]
                                    ])->label(false)
                                    ?>

                                    <?php

                                   // $valKecamatanNow = common\components\MemberHelpers::customMemberForm(43, 2);
                                    //if ($valKecamatanNow) {

                                        echo $form->field($model, 'KecamatanNow')->textInput([
                                            'placeholder' => Yii::t('app', 'Kecamatan saat ini'),
                                            // 'style'=>'width:350px;',
                                            'maxlength' => 255,
                                        ])->label(false);
                                   // }
                                    ?>

                                    <?php
                                    $valRTNow = common\components\MemberHelpers::customMemberForm(45, 2);
                                    if ($valRTNow) {
                                        echo $form->field($model, 'RTNow')->textInput([
                                            'placeholder' => Yii::t('app', 'RT saat ini'),
                                            // 'style'=>'width:350px;',
                                            'maxlength' => 255,
                                        ])->label(false);
                                    }
                                    ?>
                                </div>
                                        <?php //} ?>
                                <?php
                                //$valKotaNow = common\components\MemberHelpers::customMemberForm(9,2);
                                //if($valKotaNow){
                                ?>  
                                <div class="col-sm-6" style="padding:0;">
                                    <?=
                                    $form->field($model, 'CityNow')->widget(AutoComplete::className(), [
                                        'options' => [
                                            'class' => 'form-control',
                                            'placeholder' => 'Masukkan Kabupaten/Kota saat ini',
                                            // 'style'=>'width:300px;',
                                            'maxlength' => 255,
                                        ],
                                        'clientOptions' => [
                                            'source' => new JsExpression('function(request, response) {
			                                   $.ajax({
			                                       url: "' . Url::to(['pendaftaran/kabupaten-list']) . '",
			                                       dataType: "json",
			                                       data: {
			                                           term: request.term,
			                                           prop: $("#members-provincenow").val()
			                                       },
			                                       success: function (data) {
			                                               response(data);
			                                       }
			                                   })
			                                }'),
                                        ]
                                    ])->label(false)
                                    ?>

                                    <?php

                                    //$valKelurahanNow = common\components\MemberHelpers::customMemberForm(44, 2);
                                    //if ($valKelurahanNow) {
                                       echo $form->field($model, 'KelurahanNow')->textInput([
                                            'placeholder' => Yii::t('app', 'Kelurahan saat ini'),
                                            // 'style'=>'width:350px;',
                                            'maxlength' => 255,
                                        ])->label(false);
                                    //}
                                    ?>

                                    <?php

                                    $valRWNow = common\components\MemberHelpers::customMemberForm(46, 2);
                                    if ($valRWNow) {
                                        echo $form->field($model, 'RWNow')->textInput([
                                            'placeholder' => Yii::t('app', 'RW saat ini'),
                                            // 'style'=>'width:350px;',
                                            'maxlength' => 255,
                                        ])->label(false);
                                    //}
                                    ?>
                                </div>
                                <?php //} ?>
                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>
                
                               <?php
                                $val1 = common\components\MemberHelpers::customMemberForm(19,2);
                                if($val1){
                        ?>  
                    <tr>
                        <td class="pull-right">
                            Pendidikan 
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
    <?=
    $form->field($model, 'EducationLevel_id')->widget(
            Select2::classname(), [
        'data' => ArrayHelper::map(MasterPendidikan::find()->all(), 'id', 'Nama'),
        'size' => Select2::SMALL,
        'options' => [ 'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'EducationLevel_id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        //'width'=> '150px',
        ],
    ])->label(false)
    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>
                    
                <?php
                                $valPekerjaan = common\components\MemberHelpers::customMemberForm(16,2);
                                if($valPekerjaan){
                        ?>      
                <tr>
                    <td class="pull-right">
                        Pekerjaan
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
<?=
$form->field($model, 'Job_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(MasterPekerjaan::find()->all(), 'id', 'Pekerjaan'),
    'size' => Select2::SMALL,
    'options' => [
        'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Job_id'),
    ],
    'pluginOptions' => [
        'allowClear' => true,
    //'width'=> '150px',
    ],
        ]
)->label(false)
?>

                            </div>

                        </div>
                    </td>
                </tr>
                  <?php } ?>
                                <?php
                                $valAgama = common\components\MemberHelpers::customMemberForm(17,2);
                                if($valAgama){
                        ?>   
                    <tr>
                        <td class="pull-right">
                            Agama
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
    <?=
    $form->field($model, 'Agama_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Agama::find()->all(), 'ID', 'Name'),
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Agama_id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        //'width'=> '150px',
        ],
            ]
    )->label(false)
    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>

                <?php
                                $valStatusKawin = common\components\MemberHelpers::customMemberForm(20,2);
                                if($valStatusKawin){
                        ?>       
                <tr>
                    <td class="pull-right">
                        Status Perkawinan
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">

<?=
$form->field($model, 'MaritalStatus_id', [
])->widget(Select2::classname(), [
    'data' => ArrayHelper::map(MasterStatusPerkawinan::find()->all(), 'id', 'Nama'),
    'size' => Select2::SMALL,
    'options' => [
        'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Status Perkawinan'),
    ],
    'pluginOptions' => [
        'allowClear' => true,
    //'width'=> '150px',
    ],
        ]
)->label(false)
?>
                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>

                                <?php
                                $valUnitKerja = common\components\MemberHelpers::customMemberForm(36,2);
                                if($valUnitKerja){
                        ?>    
                    <tr>
                        <td class="pull-right">
                            Unit Kerja
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
    <?=
    $form->field($model, 'UnitKerja_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Departments::find()->all(), 'ID', 'Name'),
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'UnitKerja_id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        //'width'=> '150px',
        ],
            ]
    )->label(false)
    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>
                                <?php
                                $valFakultas = common\components\MemberHelpers::customMemberForm(37,2);
                                if($valFakultas){
                        ?>    
                    <tr>
                        <td class="pull-right">
                            Fakultas
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
    <?=
    $form->field($model, 'Fakultas_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(MasterFakultas::find()->all(), 'id', 'Nama'),
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Fakultas_id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        //'width'=> '150px',
        ],
            ]
    )->label(false)
    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>
                    
                                <?php
                                $valJurusan = common\components\MemberHelpers::customMemberForm(38,2);
                                if($valJurusan){
                        ?>    
                    <tr>
                        <td class="pull-right">
                            Jurusan
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                    <?=
                                    $form->field($model, 'Jurusan_id')->widget(DepDrop::classname(), [
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'data' => ArrayHelper::map(MasterJurusan::find()->all(), 'id', 'Nama'),
                                        'options' => [
                                            'id' => 'Jurusan',
                                            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Jurusan_id'),
                                        ],
                                        'select2Options' =>
                                        [
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            //'width'=> '150px',
                                            ]
                                        ],
                                        'pluginOptions' => [
                                            'loadingText' => 'Please wait...',
                                            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Jurusan_id'),
                                            'depends' => ['members-fakultas_id'],
                                            'url' => Url::to(['pendaftaran/jurusan']),
                                        ]
                                            ]
                                    )->label(false)
                                    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>

                                 <?php
                                $valProdi = common\components\MemberHelpers::customMemberForm(48,2);
                                if($valProdi){
                        ?>    
                    <tr>
                        <td class="pull-right">
                            Program Studi
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
                                     <?=$form->field($model, 'ProgramStudi_id', [
                                                /*'template' => '<span class="input-group-addon" style="width: 144px">'.Yii::t('app','Jurusan_id').'</span>{input}',
                                                'options'  => [
                                                    'class' => 'input-group form-group'
                                                ],*/
                                    ])->widget(DepDrop::classname(), [
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'data'=>ArrayHelper::map(MasterProgramStudi::find()->all(),'id','Nama'),
                                    //'size'=>'sm',
                                    'options'=>[
                                        'id'=>'ProgramStudi',
                                         'placeholder'=>Yii::t('app', 'Choose').' Program Studi',
                                    ],
                                    'select2Options'=>
                                        [
                                            'pluginOptions'=>[
                                                    'allowClear'=>true,
                                                    //'width'=> '150px',
                                                ]
                                        ],
                                    'pluginOptions'=>[
                                        'loadingText'=>'Please wait...',
                                        'placeholder'=>Yii::t('app', 'Choose').' Program Studi',
                                        'depends'=>['Jurusan'],
                                        'url'=>Url::to(['pendaftaran/prodi']),
                                    ]
                                ]
                            )->label(false)?>

                                </div>

                            </div>
                        </td>
                    </tr>
                                <?php } ?>

                                <?php
                                $valKelas = common\components\MemberHelpers::customMemberForm(35,2);
                                if($valKelas){
                        ?>    
                    <tr>
                        <td class="pull-right">
                            Kelas
                        </td>
                        <td >
                            <div class="form-group kv-fieldset-inline">
                                <div class="col-sm-12" style="padding:0;">
    <?=
    $form->field($model, 'Kelas_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(KelasSiswa::find()->all(), 'id', 'namakelassiswa'),
        'size' => Select2::SMALL,
        'options' => [
            'placeholder' => Yii::t('app', 'Choose') . ' ' . Yii::t('app', 'Kelas_id'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        //'width'=> '150px',
        ],
            ]
    )->label(false)
    ?>

                                </div>

                            </div>
                        </td>
                    </tr>
<?php } ?>
                <?php
                                $valTelp = common\components\MemberHelpers::customMemberForm(12,2);
                                if($valTelp){
                        ?>        
                <tr>
                    <td class="pull-right">
                        Nomor Telpon Rumah
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                                <?=
                                $form->field($model, 'Phone')->textInput([
                                    'placeholder' => $model->getAttributeLabel('Phone'),
                                    //'style'=>'width:350px;',
                                    'maxlength' => 255,
                                ])->label(false)
                                ?>

                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>
                
                <?php
                                $valHP = common\components\MemberHelpers::customMemberForm(11,2);
                                if($valHP){
                        ?>    
                <tr>
                    <td class="pull-right">
                        Nomor HP
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                                <?=
                                $form->field($model, 'NoHp')->textInput([
                                    'placeholder' => $model->getAttributeLabel('NoHp'),
                                    //'style'=>'width:350px;',
                                    'maxlength' => 255,
                                ])->label(false)
                                ?>

                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>

                <?php
                                $valInstitusi = common\components\MemberHelpers::customMemberForm(26,2);
                                if($valInstitusi){
                        ?>    
                <tr>
                    <td class="pull-right">
                        Nama Institusi
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
<?=
$form->field($model, 'InstitutionName')->textInput([
    'placeholder' => Yii::t('app', 'InstitutionName'),
    // 'style'=>'width:350px;',
    'maxlength' => 255,
])->label(false)
?>

                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>
                <?php
                                $valAlamatInstitusi = common\components\MemberHelpers::customMemberForm(27,2);
                                if($valAlamatInstitusi){
                        ?>    
                <tr>
                    <td class="pull-right">
                        Alamat Institusi
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
<?=
$form->field($model, 'InstitutionAddress')->textArea([
    'placeholder' => Yii::t('app', 'InstitutionAddress'),
    //'style'=>'width:350px;',
    'maxlength' => 255,
])->label(false)
?>

                            </div>

                        </div>
                    </td>
                </tr>
                                <?php } ?>
                
                <?php
                                $valTelpInstitusi = common\components\MemberHelpers::customMemberForm(28,2);
                                if($valTelpInstitusi){
                        ?>    
                <tr>
                    <td class="pull-right">
                        Telepon Institusi
                    </td>
                    <td >
                        <div class="form-group kv-fieldset-inline">
                            <div class="col-sm-12" style="padding:0;">
                        <?=
                        $form->field($model, 'InstitutionPhone')->textInput([
                            'placeholder' => Yii::t('app', 'InstitutionPhone'),
                            //'style'=>'width:350px;',
                            'maxlength' => 20,
                        ])->label(false)
                        ?>

                            </div>

                        </div>

                        <div id="test_div" >
<?=
        $form->field($model, 'locationCategory', [
                //'options'=>[ 'style'=>'width: 821px;']
        ])->checkboxList(ArrayHelper::map(LocationLibrary::find()->all(), 'ID', 'Name'))
        ->label('Lokasi Pinjam')
?>

    <?=
            $form->field($model, 'collectionCategory', [
                    //'options'=>[ 'style'=>'width: 821px;']
            ])->checkboxList(
                    ArrayHelper::map(Collectioncategorys::find()->all(), 'ID', 'Name'))
            ->label('Koleksi yang dapat dipinjam')
    ?>
                        </div>

    <?php
    //echo  Html::a(Yii::t('app', 'Save'), ['/pendaftaran/anggota/'], ['class' => 'btn btn-md btn-success',]);
    //echo '&nbsp;' .Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ?>
                    </td>

                </tr>
                                <?php }?>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <div class="checkbox"><label>
                                <input type="checkbox" name="disclamer" id="disclamer"><?= Yii::t('app', 'disclamer') ?></label>
                        </div>
                        <div class="pull-left" id="button" hidden="hidden">
                            <?php
                            //echo  Html::a(Yii::t('app', 'Save'), ['/pendaftaran/anggota/'], ['class' => 'btn btn-md btn-success',]);
                            echo '&nbsp;' . Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                            ?>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>





    <?php
//$value = \yii\helpers\ArrayHelper::getValue($membersForm, ['100']);

    ActiveForm::end();
    ?>
    <?php
    $this->registerJs("



$('#duplicateAddrs').click(function() {
    if(this.checked){
        $('#members-addressnow').val($('#members-address').val());
        $('#members-provincenow').val($('#members-province').val());
        $('#members-citynow').val($('#members-city').val());
        $('#members-kecamatannow').val($('#members-kecamatan').val());
        $('#members-kelurahannow').val($('#members-kelurahan').val());
        $('#members-rtnow').val($('#members-rt').val());
        $('#members-rwnow').val($('#members-rw').val());
    }
});


$(document).ready(function(){
  
    $('#members-identityno').blur(function(){
        if($('#members-identitytype_id').val() == ''){
            $('#members-identitytype_id').focus();
            alert('Harap pilih jenis identitas.');

        }else{
        
            $.get('get-data?id='+$('#members-identitytype_id').val()+'&val='+$('#members-identityno').val(), function(data, status){
                if(data != 'null'){
                    var obj = JSON.parse(data);
                    $('#members-fullname').val(obj.namalengkap);
                    $('#members-placeofbirth').val(obj.lhrtempat);
                    $('#members-tgllahir').val(obj.lhrtanggal);
                    $('#members-sex_id').val(obj.jk).change();
                    $('#members-address').val(obj.alamat);
                    $('#members-addressnow').val(obj.alamat);
                    $('#members-sex_id').val(obj.jk).change();
                                            $('#members-educationlevel_id').val(obj.pendidikan).change();
                                            $('#members-job_id').val(obj.pekerjaan).change();
                                            $('#members-maritalstatus_id').val(obj.statusKawin).change();
                                            $('#members-agama_id').val(obj.agama).change();
                    
                    
                }
            });
        }
        
    });
});


 var valid = false;
 $('#test_div').hide();

 validateEmail = function (email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) { return false; }
        else { return true; }
    };



 $('#disclamer').change(function(){
        if($(this).is(':checked'))
        {

			if ($('#members-identitytype_id').val() =='') {
                    $('#members-identitytype_id').focus();
					alert('Jenis Identitas harap dipilih.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-identityno').val() =='') {
                    $('#members-identityno').focus();
					alert('No.Identitas tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-password').val().toString().length < 6) {
                    alert('Maaf, Inputan password kurang valid. Silahkan isi password minimal 6 karakter');
                    $('#members-password').focus();
                    $('#disclamer').prop('checked', false);
                    valid = false;
            }else if ($('#members-email').val().length <= 0) {
                    $('#members-email').focus();
                    alert('Inputan Email tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
            }else if (!validateEmail($('#members-email').val())) {
                    $('#members-email').focus();
                    alert('Inputan Email Tidak Valid');
                    $('#disclamer').prop('checked', false);
                    valid = false;
            }else if ($('#members-fullname').val() =='') {
                    $('#members-fullname').focus();
					alert('Nama Lengkap tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-placeofbirth').val() =='') {
                    $('#members-placeofbirth').focus();
					alert('Tempat Lahir tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-tgllahir').val() =='') {
                    $('#members-tgllahir').focus();
					alert('Tanggal Lahir tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-sex_id').val() =='') {
                    $('#members-sex_id').focus();
					alert('Jenis Kelamin harap dipilih.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-address').val() =='') {
                    $('#members-address').focus();
					alert('Alamat tinggal sesuai identitas tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-provinces').val() =='') {
                    $('#members-province').focus();
					alert('Propinsi tinggal sesuai identitas tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-city').val() =='') {
                    $('#members-city').focus();
					alert('Kabupaten/Kota tinggal sesuai identitas tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-addressnow').val() =='') {
                    $('#members-addressnow').focus();
					alert('Alamat tinggal saat ini tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-provincenow').val() =='') {
                    $('#members-provincenow').focus();
					alert('Propinsi tinggal saat ini tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else if ($('#members-citynow').val() =='') {
                    $('#members-citynow').focus();
					alert('Kabupaten/Kota saat ini tidak boleh kosong.');
                    $('#disclamer').prop('checked', false);
                    valid = false;
        	}else{
            	valid = true;
            }







			if(valid == true){
				 $('#button').show();
                 $('#button').focus();
			}

        }else{
			$('#button').hide();
        }
    });
	");
    ?>
</div>
