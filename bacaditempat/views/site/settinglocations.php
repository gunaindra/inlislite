<?php
use yii\helpers\Html;
use common\models\Locations;
use common\models\LocationLibrary;
use yii\helpers\ArrayHelper;

use common\components\OpacHelpers;

/* @var $this yii\web\View */

$this->title = 'Baca Ditempat';

Yii::$app->view->params['subTitle'] = '<h3>Penentuan Lokasi<br>Baca Ditempat</h3>';

?>
    <div class="message" data-message-value="<?= Yii::$app->session->getFlash('message') ?>">
    </div>




<div class="box-body" style="padding:50px 0">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <center>
            <?= Html::beginForm(Yii::$app->request->baseUrl.'/site/setting-locations', 'post', ['class'=>'uk-width-medium-1-1 uk-form uk-form-horizontal']); ?>
            <h4><b>IP Komputer</b></h4>
            <h4><b><?= OpacHelpers::getIP() ?></b></h4>
            <!-- <h4><b><?= Yii::$app->request->userIP ?></b></h4> -->
            <br>

            <div class="form-group">
                <?= Html::dropDownList('LocationLibrary', 'asd',
                    ArrayHelper::map($loclibs, 'ID', 'Name'),
                    ['prompt' => "-- Silahkan pilih lokasi perpustakaan --", 'class'=>'form-control','id'=>'locations-Library']) ?>
            </div>
            
            <div class="form-group" id="selecter-locations">
            </div>

            <button type="submit" class="btn btn-success btn-md btn-block">Simpan</button>
            <!--<a class="login-link" href="#">Lupa password?</a>-->
            <?= Html::endForm(); ?>   
        </center>
    </div>
    <div class="col-sm-4"></div>          
</div>


<?php
$script = <<< JS

    $('#locations-Library').change(function(){
        var idLoc = $(this).val();
        // swal(idLoc);
        $.get('load-selecter-locations',{idLoc : idLoc},function(data){
        })
        .done(function(data) {
            $( '#selecter-locations' ).html(data); 
            // alert( "second success" );
        })
        .fail(function(data) {
            $('#locations-id').hide();
            // alert( "error" );
        });
    });


    if ($('.message').data("messageValue")) {
        swal($('.message').data("messageValue"));
    }

JS;

$this->registerJs($script);
?>