<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\bootstrap\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
?>
<div class="col-md-4">
        <div id="frameFoto" class="img-frame">

                                <div id="inlis_camera"></div>
                                <form>
                                    <div id="pre_take_buttons" style="padding-top: 10px">
                                        <button class="btn btn-primary" type="button" onClick="preview_snapshot()"><span class="glyphicon glyphicon-camera"></span> <?= Yii::t('app','Ambil Foto') ?> </button>
                                    </div>
                                    <div id="post_take_buttons" style="display:none;padding-top: 10px">

                                        <button class="btn btn-primary" type="button" onClick="cancel_preview()"><span class="glyphicon glyphicon-camera"></span> <?= Yii::t('app','Ulangi Foto') ?></button>
                                        <button class="btn btn-warning" type="button" onClick="save_photo()"><span class="glyphicon glyphicon-save"></span> <?= Yii::t('app','Simpan Foto') ?></button>

                                    </div>
                                </form>
                                <?php
                                    $this->registerJs("
                                    Webcam.set({
                                            // live preview size
                                            force_flash: true,
                                            width: 320,
                                            height: 240,
                                            //dest_width: 640,
                                            //dest_height: 480,
                                            image_format: 'jpeg',
                                            jpeg_quality: 90
                                        });
                                        Webcam.attach('#inlis_camera'); ",yii\web\View::POS_END);

                                $this->registerJs("

                                    function preview_snapshot() {
                                        // freeze camera so user can preview pic
                                        Webcam.freeze();

                                        // swap button sets
                                        document.getElementById('pre_take_buttons').style.display = 'none';
                                        document.getElementById('post_take_buttons').style.display = '';
                                    }

                                    function cancel_preview() {
                                        // cancel preview freeze and return to live camera feed
                                        Webcam.unfreeze();

                                        // swap buttons back
                                        document.getElementById('pre_take_buttons').style.display = '';
                                        document.getElementById('post_take_buttons').style.display = 'none';
                                    }

                                    function save_photo() {
                                        // actually snap photo (from preview freeze) and display it
                                        Webcam.snap( function(data_uri) {
                                            // display results in page
                                            //document.getElementById('results').innerHTML =
                                            //    '<h2>Here is your image:</h2>' +
                                            //    '<img src=\"'+data_uri+'\"/>';

                                            // swap buttons back
                                            document.getElementById('pre_take_buttons').style.display = '';
                                            document.getElementById('post_take_buttons').style.display = 'none';


                                            Webcam.on( 'uploadComplete', function(code, text) {
                                                // Upload complete!
                                                // 'code' will be the HTTP response code from the server, e.g. 200
                                                // 'text' will be the raw response content
                                                //alert(code);
                                                $('#fotoanggota').attr('src', data_uri);
                                                location.reload();

                                            } );
                                            Webcam.upload(data_uri, \"save-foto?id=$model->ID\");

                                        } );
                                    }

                                    ",yii\web\View::POS_END);
                                ?>
        </div>
</div>
<div class="col-md-8">
    Unggah Foto Anggota
    <?php echo FileInput::widget([
        'name' => 'image',
        'options'=>[
            'accept' => 'image/*'
        ],
        'pluginOptions' => [

            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => true,
            'browseLabel' => '',
            'removeLabel' => Yii::t('app','Remove'),
            'uploadLabel' => Yii::t('app','Upload'),
            'uploadUrl' => Url::to(['/member/member/upload-foto-anggota?id='.$model->ID]),
            'allowedFileExtensions'=> ["jpg", "jpeg"],
            'msgInvalidFileExtension'=>Yii::t('app','Invalid extension for file "{name}". Only "{extensions}" files are supported.'),
            'minImageWidth'=> 1004,
            'minImageHeight'=> 638,
        ]
    ]);?>
</div>