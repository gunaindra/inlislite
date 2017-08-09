<?php
/**
 * @copyright Copyright &copy; Perpustakaan Nasional RI, 2016
 * @version 1.0.0
 * @author Andy Kurniawan <dodot.kurniawan@gmail.com>
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Collectioncategorys $model
 * @var yii\widgets\ActiveForm $form
 */

$datacheckbox1 = ['0'=>'-Kosong-','1'=>'Manual Input','2'=>'Kode Jenis Bahan','3'=>'Kode Kategori Koleksi','4'=>'Kode Bentuk Fisik'];
$datacheckbox2 = ['0'=>'99999','1'=>'YYYYY'];
if (strtolower($model->NomorInduk) != 'otomatis')
{
  $disabletemplate =true;
}
$FormatNomorInduks=explode('|',$model->FormatNomorInduk);
if(strpos($FormatNomorInduks[0],'{') !== FALSE)
{

    $dataTemplateInput1=trim(str_replace('}','',str_replace('{','',$FormatNomorInduks[0])));
    $FormatNomorInduks[0]=1;
}else{
    $display1='display:none;';
}
if(strpos($FormatNomorInduks[2],'{') !== FALSE)
{

    $dataTemplateInput2=trim(str_replace('}','',str_replace('{','',$FormatNomorInduks[2])));
    $FormatNomorInduks[2]=1;
}else{
    $display2='display:none;';
}
if(strpos($FormatNomorInduks[4],'{') !== FALSE)
{

    $dataTemplateInput3=trim(str_replace('}','',str_replace('{','',$FormatNomorInduks[4])));
    $FormatNomorInduks[4]=1;
}else{
    $display3='display:none;';
}

echo Html::beginForm ('', 'post');
?>
<div class="settingparameters-form">
    <div class="form-group">
        <div class="page-header">
        	<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>

         <div class="form-group kv-fieldset-inline">
            <div class="col-sm-12">
              <div class="form-group">
                  <label class="control-label col-sm-2" for="email"><?php echo Html::label(Yii::t('app', 'Induk Number')); ?></label>
                  <div class="col-sm-6">
                    <?php echo Html::activeRadioList(
                    $model,
                    'NomorInduk',
                    ['Otomatis' => Yii::t('app', 'Automatic'), 'Manual' => Yii::t('app', 'Manual')]
                    ); ?>
                  </div>
                </div>
             </div>
        </div>
        <br><br><br>
         <div id="modelForm" class="form-group kv-fieldset-inline">
            <div class="col-sm-12">
              <div class="form-group">
                  <label class="control-label col-sm-2" for="email"><?php echo Html::label(Yii::t('app', 'Middle Induk Number')); ?></label>
                        <div class="col-sm-2">
                        <?php 
                        echo Select2::widget([
                                'id' => 'cbTemplate1',
                                'name' => 'cbTemplate[]',
                                'data' => $datacheckbox1,
                                'size'=>'sm',
                                'disabled'=>$disabletemplate,
                                'value'=>$FormatNomorInduks[0],
                                'pluginEvents' => [
                                    "select2:select" => 'function() { 
                                        var id = $("#cbTemplate1").val();
                                        if(id==1)
                                        {
                                            $("#cbTemplateInput1").show();
                                        }else{
                                            $("#cbTemplateInput1").hide();
                                        }
                                    }',
                                ]
                            ]);
                        echo Html::textInput('cbTemplateInput[0]',$dataTemplateInput1,['id'=>'cbTemplateInput1','class'=>'form-control manualinp','style'=> $display1.'width:100%;']);
                        ?>
                        </div>
                        <div class="col-sm-2">
                        <?php 
                        echo Select2::widget([
                                'id' => 'cbTemplate2',
                                'name' => 'cbTemplate[]',
                                'data' => $datacheckbox2,
                                'size'=>'sm',
                                'disabled'=>$disabletemplate,
                                'value'=>$FormatNomorInduks[1],
                                'pluginEvents' => [
                                    "select2:select" => 'function() { 
                                        var id = $("#cbTemplate2").val();
                                    }',
                                ]
                            ]);
                        ?>
                        </div>
                        <div class="col-sm-2">
                        <?php 
                        echo Select2::widget([
                                'id' => 'cbTemplate3',
                                'name' => 'cbTemplate[]',
                                'data' => $datacheckbox1,
                                'size'=>'sm',
                                'disabled'=>$disabletemplate,
                                'value'=>$FormatNomorInduks[2],
                                'pluginEvents' => [
                                    "select2:select" => 'function() { 
                                        var id = $("#cbTemplate3").val();
                                        if(id==1)
                                        {
                                            $("#cbTemplateInput2").show();
                                        }else{
                                            $("#cbTemplateInput2").hide();
                                        }
                                    }',
                                ]
                            ]);
                        echo Html::textInput('cbTemplateInput[2]',$dataTemplateInput2,['id'=>'cbTemplateInput2','class'=>'form-control manualinp','style'=>$display2.'width:100%']);
                        ?>
                        </div>
                        <div class="col-sm-2">
                        <?php 
                        echo Select2::widget([
                                'id' => 'cbTemplate4',
                                'name' => 'cbTemplate[]',
                                'data' => $datacheckbox2,
                                'size'=>'sm',
                                'disabled'=>$disabletemplate,
                                'value'=>$FormatNomorInduks[3],
                                'pluginEvents' => [
                                    "select2:select" => 'function() { 
                                        var id = $("#cbTemplate4").val();
                                    }',
                                ]
                            ]);
                        ?>
                        </div>
                        <div class="col-sm-2">
                        <?php 
                        echo Select2::widget([
                                'id' => 'cbTemplate5',
                                'name' => 'cbTemplate[]',
                                'data' => $datacheckbox1,
                                'size'=>'sm',
                                'disabled'=>$disabletemplate,
                                'value'=>$FormatNomorInduks[4],
                                'pluginEvents' => [
                                    "select2:select" => 'function() { 
                                        var id = $("#cbTemplate5").val();
                                        if(id==1)
                                        {
                                            $("#cbTemplateInput3").show();
                                        }else{
                                            $("#cbTemplateInput3").hide();
                                        }
                                    }',
                                ]
                            ]);
                        echo Html::textInput('cbTemplateInput[4]',$dataTemplateInput3,['id'=>'cbTemplateInput3','class'=>'form-control manualinp','style'=>$display3.'width:100%']);
                        ?>
                        </div>
                </div>
             </div>
        </div>
        <br><br><br><br>
         <div class="form-group kv-fieldset-inline"  >
            <div class="col-sm-12">
              <div class="form-group">
                  <label class="control-label col-sm-2" for="email"><?php echo Html::label(Yii::t('app', 'Format Number Barcode')); ?></label>
                  <div class="col-sm-6">
                    <?php echo Html::activeRadioList($model,'FormatNomorBarcode',['Item ID' => 'Item ID', 'No. Induk' => 'No.Induk']); ?>
                  </div>
                </div>
             </div>
        </div>
        <br><br><br>
        <div class="form-group kv-fieldset-inline" >
            <div class="col-sm-12">
              <div class="form-group">
                  <label class="control-label col-sm-2" for="email"><?php echo Html::label(Yii::t('app', 'Format Number RFID')); ?></label>
                  <div class="col-sm-6">
                    <?php echo Html::activeRadioList($model,'FormatNomorRFID',['Item ID' => 'Item ID', 'No. Induk' => 'No.Induk']); ?>
                  </div>
                </div>
             </div>
        </div>


    </div>
<?php 
echo Html::endForm();
?>

</div>
<script type="text/javascript">
     $('input:radio[name ="DynamicModel[NomorInduk]"]').click(function(){
        if($('input:radio[name ="DynamicModel[NomorInduk]"]:checked').val() != 'Otomatis')
        {
            $('#modelForm select,input:text').prop('disabled', true);
        }else{
            $('#modelForm select,input:text').prop('disabled', false);
        }
     });

      $('.manualinp').keypress(function(e){
        //disable kurawal
        if(e.which == 123 || e.which == 125){
          return false;
        } else {
        }
      });
</script>