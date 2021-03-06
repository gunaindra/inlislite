
<?php 
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\KataSandang;
use common\models\Refferenceitems;
use common\widgets\MaskedDatePicker;
?>
<style type="text/css">
  .btm-add-on {
    background-color: #f5f5f5;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    padding: 5px;
    text-align: center;
    font-size:12px;
    border: 1px solid #C0C0C0;
    border-top: none;
}
.has-add-on {
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
}

/* .floating-topright1{
  position: fixed;
  top:295px;
  right: 40px;
  z-index: 2147483647;
} */
</style>
<?php
/*echo '<pre>'; print_r($modelbib); echo '</pre>';*/
/* die;*/

$divclass='';
if (!$model->isNewRecord && $for == 'coll')
{
  $divclass='disabled';
}

?>
<div id="entryBibliografiPanel" class="<?=$divclass?>">
  <div class="box-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="box-header with-border">
                              <div class="col-xs-6 col-sm-6" >
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                          Data Bibliografis
                                        </a>
                                    </h4>
                              </div>
                              <div class="col-xs-6 col-sm-6">
                                 <small><?php echo Html::a("<i class='glyphicon glyphicon-th'></i> Tampilkan Form MARC", '#', ['id'=>'btn-change-advance','class' =>'btn bg-navy floating-topright1  pull-right btn-sm','onclick'=>'js:BibliografisToogleForm("advance")']); ?></small>
                              </div>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in">
                          <div class="box-body">
                            <?php echo Html::hiddenInput('modeform',(string)$isAdvanceEntry,['id'=>'modeform']); ?>
                              <div id="simple">

                                    <div class="panel panel-default ">
                                      <div class="panel-heading">Judul</div>
                                      <div class="panel-body">
                                        <div class="form-group kv-fieldset-inline">
                                          <div class="col-sm-12">
                                               <input type="hidden" id="Ruasid_245" name="Ruasid[245]" value="<?=$taglist['ruasid']['245']?>" size="3" />
                                               <div class="form-group">
                                                  <span class="<?=$listvar['input_required']['245']['status']?>"  id="status-245">
                                                  <input type="hidden" id="message-245" value="<?=$listvar['input_required']['245']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Title'); ?></label>
                                                    <div class="col-sm-6">
                                                        <?php echo Html::activeTextInput($modelbib,'Title',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Judul').'...']); ?>
                                                        <div id="error-245" class="help-block"></div>
                                                    </div>
                                                  </span>
                                                  <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'KataSandang'); ?></label>
                                                  <div class="col-sm-2">
                                                    <?php 
                                                      echo Select2::widget([
                                                      'model' => $modelbib,
                                                      'attribute' => 'KataSandang',
                                                      'data'=>ArrayHelper::map(KataSandang::find()->all(),'JumlahKarakter','Name'),
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true,
                                                                        ],
                                                      'options'=> ['placeholder'=>'--Tidak diawali--']
                                                      ]);?>
                                                  </div>
                                                </div>
                                            </div>
                                         <!--  <div class="col-sm-1">
                                           &nbsp;
                                         </div> -->
                                        </div>

                                        <div class="form-group kv-fieldset-inline">
                                          <div class="col-sm-12">
                                              <div class="form-group">
                                                  <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'TitleAdded'); ?></label>
                                                  <div class="col-sm-6">
                                                    <?php echo Html::activeTextInput($modelbib,'TitleAdded',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Anak Judul').'...']); ?>
                                                  </div>
                                                </div>
                                             </div>
                                          <!-- <div class="col-sm-1">
                                              &nbsp;
                                          </div> -->
                                        </div>

                                        <div class="form-group kv-fieldset-inline">
                                          <div class="col-sm-12">
                                              <div class="form-group">
                                                  <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'PenanggungJawab'); ?></label>
                                                  <div class="col-sm-6">
                                                    <?php echo Html::activeTextInput($modelbib,'PenanggungJawab',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Penanggung Jawab').'...']); ?>
                                                  </div>
                                                </div>
                                          </div>
                                          <!-- <div class="col-sm-1">
                                              &nbsp;
                                          </div> -->
                                        </div>
                                      </div>
                                    </div>

                                    <div class="panel panel-default ">
                                      <div class="panel-heading">Tajuk Pengarang</div>
                                      <div class="panel-body">

                                        <div class="form-group kv-fieldset-inline">
                                          <div class="col-sm-12">
                                              <div class="form-group">
                                              <span class="<?=$listvar['input_required']['100']['status']?>"  id="status-100">
                                              <input type="hidden" id="message-100" value="<?=$listvar['input_required']['100']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Author'); ?></label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="Ruasid_100" name="Ruasid[100]" value="<?=$taglist['ruasid']['100']?>" size="3" />
                                                  <?php echo Html::activeTextInput($modelbib,'Author',['class'=>'form-control tajukpengarang',"onkeyup"=>"AutoCompleteOn(this,'pengarang');",'style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Pengarang').'...']); ?>
                                                  <div class="btm-add-on" style="text-align:left">
                                                       <?php $list = [0 => 'Nama Depan', 1 => 'Nama Belakang', 3 => 'Nama Keluarga', '#' => 'Badan Korporasi', '##' => 'Nama Pertemuan'];
                                                       echo Html::activeRadioList($modelbib, 'AuthorType',$list); 
                                                       ?>
                                                  </div>
                                                  <div id="error-100" class="help-block"></div>
                                                </div>
                                                </span>
                                              </div>
                                        </div>
                                        <!-- <div class="col-sm-1">
                                            &nbsp;
                                        </div> -->
                                      </div>

                                      <div class="form-group kv-fieldset-inline">
                                          <div class="col-sm-12">
                                              <div class="form-group">
                                                  <span class="<?=$listvar['input_required']['700']['status']?>"  id="status-700">
                                                  <input type="hidden" id="message-700" value="<?=$listvar['input_required']['700']['message']?>" />
                                                  <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'AuthorAdded'); ?></label>
                                                  <div class="col-sm-8">
                                                  <input id="AuthorAddCount" type="hidden" value="<?=count($listvar['author'])?>">
                                                    <div id="AuthorAddList">
                                                      <?php
                                                          if(count($listvar['author']) > 0 && count($listvar['authortype']) > 0){
                                                            $count700=0;
                                                            $count710=0;
                                                            $count711=0;
                                                            foreach ($listvar['author'] as $key => $value) {
                                                            $type1=''; $type2=''; $type3=''; $type4=''; $type5='';
                                                            switch ($listvar['authortype'][$key]) {
                                                              case '0':
                                                                $type1='checked ';
                                                                $tagpengarangtambahan='700';
                                                                $count700++;
                                                                break;
                                                              case '1':
                                                                $type2='checked ';
                                                                $tagpengarangtambahan='700';
                                                                $count700++;
                                                                break;
                                                              case '3':
                                                                $type3='checked ';
                                                                $tagpengarangtambahan='700';
                                                                $count700++;
                                                                break;
                                                              case '#':
                                                                $type4='checked ';
                                                                $tagpengarangtambahan='710';
                                                                $count710++;
                                                                break;
                                                              case '##':
                                                                $type5='checked ';
                                                                $tagpengarangtambahan='711';
                                                                $count711++;
                                                                break;
                                                              
                                                              default:
                                                                # code...
                                                                break;
                                                            }

                                                            if($tagpengarangtambahan == '700'){
                                                                $indexruas=$count700-1;
                                                            }else if($tagpengarangtambahan == '710'){
                                                                $indexruas=$count710-1;
                                                            }else if($tagpengarangtambahan == '711'){
                                                                $indexruas=$count711-1;
                                                            }
                                                           
                                                      ?>
                                                      <div id="DivAuthorAdded<?=$key?>">
                                                        <input type="hidden" id="Ruasid_<?=$tagpengarangtambahan?>_<?=$indexruas?>" name="Ruasid[<?=$tagpengarangtambahan?>][<?=$indexruas?>]" value="<?=$taglist['ruasid'][$tagpengarangtambahan][$indexruas]?>" size="3" />
                                                        <div style="margin-top:5px" class="input-group">
                                                          <input value="<?=$value?>" type="text" id="collectionbiblio-authoradded-<?=$key?>" class="form-control tajukpengarang" onkeyup="AutoCompleteOn(this,'pengarang');" name="CollectionBiblio[AuthorAdded][<?=$key?>]" style="width:100%" placeholder="Masukan Pengarang Tambahan...">
                                                          <span class="input-group-btn">
                                                          <?php 
                                                          if($key == 0)
                                                          {
                                                          ?>
                                                            <button id="btnAuthorAdded" class="btn btn-success pull-right" type="button" onclick="AddAuthorAdded();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          <?php
                                                          }else{
                                                          ?>
                                                            <button class="btn btn-danger btn-flat" type="button" onclick="RemoveAuthorAdded(<?=$key?>,'<?=$tagpengarangtambahan?>','<?=$indexruas?>')"><i class="glyphicon glyphicon-trash"></i></button>
                                                          <?php
                                                          }
                                                          ?>
                                                          </span>
                                                        </div>
                                                        <div class="btm-add-on">
                                                          <input type="hidden" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="">
                                                            <div id="collectionbiblio-authoraddedtype-<?=$key?>">
                                                            <label><input <?=$type1?> type="radio" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="0"> Nama Depan</label>
                                                            <label><input <?=$type2?> type="radio" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="1"> Nama Belakang</label>
                                                            <label><input <?=$type3?> type="radio" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="3"> Nama Keluarga</label>
                                                            <label><input <?=$type4?> type="radio" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="#"> Badan Korporasi</label>
                                                            <label><input <?=$type5?> type="radio" name="CollectionBiblio[AuthorAddedType][<?=$key?>]" value="##"> Nama Pertemuan</label>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <?php
                                                            }
                                                          }else{
                                                      ?>
                                                      <div id="DivAuthorAdded0">
                                                        <input type="hidden" id="Ruasid_700_0" name="Ruasid[700][0]" value="<?=$taglist['ruasid'][700][0]?>" size="3" />
                                                        <div class="input-group">
                                                          <?php echo Html::activeTextInput($modelbib,'AuthorAdded[0]',['class'=>'form-control tajukpengarang','onkeyup'=>"AutoCompleteOn(this,'pengarang');",'style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Pengarang Tambahan').'...']); ?>
                                                          <span class="input-group-btn">
                                                            <button id="btnAuthorAdded" class="btn btn-success pull-right" type="button" onclick="AddAuthorAdded();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          </span>
                                                        </div>
                                                        <div class="btm-add-on" style="text-align:left">
                                                           <?php $list = [0 => 'Nama Depan', 1 => 'Nama Belakang', 3 => 'Nama Keluarga', '#' => 'Badan Korporasi', '##' => 'Nama Pertemuan'];
                                                           echo Html::activeRadioList($modelbib, 'AuthorAddedType[0]',$list); 
                                                           ?>
                                                        </div>
                                                      </div>
                                                      <?php
                                                          }
                                                      ?>
                                                      
                                                    </div>
                                                    <div id="error-700" class="help-block"></div>
                                                  </div>

                                                </span>
                                                </div>
                                            </div>
                                          <!-- <div class="col-sm-1">
                                              &nbsp;
                                          </div> -->
                                        </div>

                                      </div>
                                    </div>

                                    <div class="panel panel-default ">
                                      <div class="panel-heading">Penerbitan</div>
                                      <div class="panel-body">
                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                            <input type="hidden" id="Ruasid_260_0" name="Ruasid[260][0]" value="<?=$taglist['ruasid'][260][0]?>" size="3" />
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['260a']['status']?>"  id="status-260a">
                                                    <input type="hidden" id="message-260a" value="<?=$listvar['input_required']['260a']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'PublishLocation'); ?></label>
                                                    <div class="col-sm-6">
                                                      <?php echo Html::activeTextInput($modelbib,'PublishLocation',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Lokasi terbit').'...']); ?>
                                                      <div id="error-260a" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>

                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['260b']['status']?>"  id="status-260b">
                                                    <input type="hidden" id="message-260b" value="<?=$listvar['input_required']['260b']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Publisher'); ?></label>
                                                    <div class="col-sm-6">
                                                      <?php echo Html::activeTextInput($modelbib,'Publisher',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Penerbit').'...']); ?>
                                                    <div id="error-260b" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>

                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['260c']['status']?>"  id="status-260c">
                                                    <input type="hidden" id="message-260c" value="<?=$listvar['input_required']['260c']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'PublishYear'); ?></label>
                                                    <div class="col-sm-3">
                                                      <?php echo Html::activeTextInput($modelbib,'PublishYear',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Tahun terbit').'...']); ?>
                                                    <div id="error-260c" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>
                                      </div>

                                    </div>

                                    <div class="panel panel-default ">
                                      <div class="panel-heading">Deskripsi Fisik</div>
                                      <div class="panel-body">
                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                            <input type="hidden" id="Ruasid_300" name="Ruasid[300]" value="<?=$taglist['ruasid'][300]?>" size="3" />
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['300a']['status']?>"  id="status-300a">
                                                    <input type="hidden" id="message-300a" value="<?=$listvar['input_required']['300a']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'JumlahHalaman'); ?></label>
                                                    <div class="col-sm-6">
                                                      <?php echo Html::activeTextInput($modelbib,'JumlahHalaman',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Jumlah Halaman').'...']); ?>
                                                    <div id="error-300a" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>

                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['300b']['status']?>"  id="status-300b">
                                                    <input type="hidden" id="message-300b" value="<?=$listvar['input_required']['300b']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'KeteranganIllustrasi'); ?></label>
                                                    <div class="col-sm-6">
                                                      <?php echo Html::activeTextInput($modelbib,'KeteranganIllustrasi',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Keterangan Illustrasi').'...']); ?>
                                                    <div id="error-300b" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>

                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['300c']['status']?>"  id="status-300c">
                                                    <input type="hidden" id="message-300c" value="<?=$listvar['input_required']['300c']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Dimensi'); ?></label>
                                                    <div class="col-sm-3">
                                                      <?php echo Html::activeTextInput($modelbib,'Dimensi',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Dimensi').'...']); ?>
                                                    <div id="error-300c" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                &nbsp;
                                            </div> -->
                                          </div>
                                      </div>

                                    </div>

                                    <div class="panel panel-default ">
                                      <div class="panel-body">

                                    <?php 
                                    if($rda=='1')
                                    {
                                    $visibleRDA= 'block';
                                    }else{
                                    $visibleRDA= 'none';
                                    }
                                    ?>  
                                    <div class="rdainput form-group kv-fieldset-inline" style="display: <?=$visibleRDA?>">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['336']['status']?>"  id="status-336">
                                              <input type="hidden" id="message-336" value="<?=$listvar['input_required']['336']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'JenisIsi'); ?></label>
                                              <div class="col-sm-6">
                                                <input type="hidden" id="Ruasid_336_0" name="Ruasid[336][0]" value="<?=$taglist['ruasid'][336][0]?>" size="3" />
                                                <?php echo Html::activeTextInput($modelbib,'JenisIsi',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_JenisIsi').'...']); ?>
                                              <div id="error-336" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>
                                    <div class="rdainput form-group kv-fieldset-inline" style="display: <?=$visibleRDA?>">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['337']['status']?>"  id="status-337">
                                              <input type="hidden" id="message-337" value="<?=$listvar['input_required']['337']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'JenisMedia'); ?></label>
                                              <div class="col-sm-6">
                                                <input type="hidden" id="Ruasid_337_0" name="Ruasid[337][0]" value="<?=$taglist['ruasid'][337][0]?>" size="3" />
                                                <?php echo Html::activeTextInput($modelbib,'JenisMedia',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_JenisMedia').'...']); ?>
                                              <div id="error-337" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>
                                    <div class="rdainput form-group kv-fieldset-inline" style="display: <?=$visibleRDA?>">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['338']['status']?>"  id="status-338">
                                              <input type="hidden" id="message-338" value="<?=$listvar['input_required']['338']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'JenisCarrier'); ?></label>
                                              <div class="col-sm-6">
                                                <input type="hidden" id="Ruasid_338_0" name="Ruasid[338][0]" value="<?=$taglist['ruasid'][338][0]?>" size="3" />
                                                <?php echo Html::activeTextInput($modelbib,'JenisCarrier',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_JenisCarrier').'...']); ?>
                                              <div id="error-338" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>
         

  <?php
  //Khusus jenis bahan terbitan berkala (serial)
  if($isSerial != 1)
  {
  ?>
                                    <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['250']['status']?>"  id="status-250">
                                              <input type="hidden" id="message-250" value="<?=$listvar['input_required']['250']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Edition'); ?></label>
                                              <div class="col-sm-6">
                                                <input type="hidden" id="Ruasid_250" name="Ruasid[250]" value="<?=$taglist['ruasid'][250]?>" size="3" />
                                                <?php echo Html::activeTextInput($modelbib,'Edition',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Edisi').'...']); ?>
                                              <div id="error-250" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>



  <?php
  }
  ?>
                                    
                                      <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['650']['status']?>"  id="status-650">
                                              <input type="hidden" id="message-650" value="<?=$listvar['input_required']['650']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Subject'); ?></label>
                                              <div class="col-sm-8">
                                                <input id="SubjectCount" type="hidden" value="<?=count($listvar['subject'])?>">
                                                    <div id="SubjectList">
                                                      <?php
                                                        if(count($listvar['subject']) > 0){
                                                          $count600=0;
                                                          $count650=0;
                                                          $count651=0;
                                                          foreach ($listvar['subject'] as $key => $value) {
                                                            $type1=''; $type2=''; $type3=''; $type4='';
                                                            switch ($listvar['subjectind'][$key]) {
                                                              case '#':
                                                                $type1='checked ';
                                                                break;
                                                              case '0':
                                                                $type2='checked ';
                                                                break;
                                                              case '1':
                                                                $type3='checked ';
                                                                break;
                                                              case '3':
                                                                $type4='checked ';
                                                                break;
                                                              
                                                              default:
                                                                # code...
                                                                break;
                                                            }

                                                            if($listvar['subjecttag'][$key] == '600')
                                                            {
                                                              $displaystatus ="";
                                                            }else{
                                                              $displaystatus = "style=\"display: none\"";
                                                            }

                                                            if($listvar['subjecttag'][$key] == '600'){
                                                                $count600++;
                                                                $indexruas=$count600-1;
                                                            }else if($listvar['subjecttag'][$key] == '650'){
                                                                $count650++;
                                                                $indexruas=$count650-1;
                                                            }else if($listvar['subjecttag'][$key] == '651'){
                                                                $count651++;
                                                                $indexruas=$count651-1;
                                                            }

                                                      ?>
                                                      <div id="DivSubject<?=$key?>">
                                                         <input type="hidden" id="Ruasid_<?=$listvar['subjecttag'][$key]?>_<?=$indexruas?>" name="Ruasid[<?=$listvar['subjecttag'][$key]?>][<?=$indexruas?>]"  value="<?=$taglist['ruasid'][$listvar['subjecttag'][$key]][$indexruas]?>" size="3" />
                                                         <div class="row" style="margin-top: 5px">
                                                             <div class="col-sm-3" style="padding-right: 0px">
                                                            <?php 
                                                            echo  Html::activeDropDownList($modelbib,'SubjectTag['.$key.']',
                                                              [
                                                              '650'=>'Topikal',
                                                              '600'=>'Nama Orang',
                                                              '651'=>'Nama Geografis'
                                                              ],
                                                              [
                                                              'class'=>'form-control',
                                                              'onchange'=>'ShowOptionSubject(<?=$key?>);'
                                                              ]
                                                            ); ?> 

                                                             </div>
                                                             <div class="col-sm-9" style="padding-left: 0px">
                                                                <div class="input-group">
                                                                  <input value="<?=$value?>" type="text" id="collectionbiblio-Subject-<?=$key?>" class="form-control tajuksubyek" onkeyup="AutoCompleteOn(this,'subyek');" name="CollectionBiblio[Subject][<?=$key?>]" style="width:100%" placeholder="Masukan Subject...">
                                                                  <span class="input-group-btn">
                                                                  <?php 
                                                                  if($key == 0)
                                                                  {
                                                                  ?>
                                                                    <button id="btnSubject" class="btn btn-success pull-right" type="button" onclick="AddSubject();"><i class="glyphicon glyphicon-plus"></i></button>
                                                                  <?php
                                                                  }else{
                                                                  ?>
                                                                    <button class="btn btn-danger btn-flat" type="button" onclick="RemoveSubject(<?=$key?>,'<?=$listvar['subjecttag'][$key]?>','<?=$indexruas?>')"><i class="glyphicon glyphicon-trash"></i></button>
                                                                  <?php
                                                                  }
                                                                  ?>
                                                                  </span>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="btm-add-on" style="text-align:left">
                                                               <input type="hidden" name="CollectionBiblio[SubjectInd][<?=$key?>]" value="">
                                                                <div id="collectionbiblio-subjectind-<?=$key?>">
                                                                <label id="opt#_<?=$key?>"><input <?=$type1?> type="radio" id="subjectind_X_<?=$key?>" name="CollectionBiblio[SubjectInd][<?=$key?>]" value="#"> Tdk Ada Info Tambahan</label>
                                                                <label id="opt0_<?=$key?>" <?=$displaystatus?> ><input <?=$type2?> type="radio" id="subjectind_0_<?=$key?>" name="CollectionBiblio[SubjectInd][<?=$key?>]" value="0"> Nama Depan</label>
                                                                <label id="opt1_<?=$key?>" <?=$displaystatus?> ><input <?=$type3?> type="radio" id="subjectind_1_<?=$key?>" name="CollectionBiblio[SubjectInd][<?=$key?>]" value="1"> Nama Belakang</label>
                                                                <label id="opt3_<?=$key?>" <?=$displaystatus?> ><input <?=$type4?> type="radio" id="subjectind_3_<?=$key?>" name="CollectionBiblio[SubjectInd][<?=$key?>]" value="3"> Nama Keluarga</label>
                                                                </div>
                                                            </div>
                                                      </div>
                                                      <?php
                                                          }
                                                        }else{
                                                      ?>

                                                      <div id="DivSubject0">
                                                        <input type="hidden" id="Ruasid_650_0" name="Ruasid[650][0]" value="<?=$taglist['ruasid'][650][0]?>" size="3" />
                                                        <div class="row">
                                                             <div class="col-sm-3" style="padding-right: 0px">
                                                            <?php 
                                                            echo  Html::activeDropDownList($modelbib,'SubjectTag[0]',
                                                              [
                                                              '650'=>'Topikal',
                                                              '600'=>'Nama Orang',
                                                              '651'=>'Nama Geografis'
                                                              ],
                                                              [
                                                              'class'=>'form-control',
                                                              'onchange'=>'ShowOptionSubject(0);'
                                                              ]
                                                            ); ?> 

                                                             </div>
                                                             <div class="col-sm-9" style="padding-left: 0px">
                                                                <div class="input-group">
                                                                  <?php echo Html::activeTextInput($modelbib,'Subject[]',['class'=>'form-control tajuksubyek',"onkeyup"=>"AutoCompleteOn(this,'subyek');",'style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Subject').'...']); ?>
                                                                  <span class="input-group-btn">
                                                                    <button id="btnSubject" class="btn btn-success pull-right" type="button" onclick="AddSubject();"><i class="glyphicon glyphicon-plus"></i></button>
                                                                  </span>
                                                                </div>
                                                             </div>
                                                        </div>
                                                          <div class="btm-add-on" style="text-align:left">
                                                               <input type="hidden" name="CollectionBiblio[SubjectInd][0]" value="">
                                                            <div id="collectionbiblio-subjectind-0">
                                                            <label id="opt#_0"><input checked type="radio" id="subjectind_X_0" name="CollectionBiblio[SubjectInd][0]" value="#"> Tdk Ada Info Tambahan</label>
                                                            <label id="opt0_0" style="display: none"><input type="radio" id="subjectind_0_0" name="CollectionBiblio[SubjectInd][0]" value="0"> Nama Depan</label>
                                                            <label id="opt1_0" style="display: none"><input type="radio" id="subjectind_1_0" name="CollectionBiblio[SubjectInd][0]" value="1"> Nama Belakang</label>
                                                            <label id="opt3_0" style="display: none"><input type="radio" id="subjectind_3_0" name="CollectionBiblio[SubjectInd][0]" value="3"> Nama Keluarga</label>
                                                            </div>
                                                          </div>
                                                        
                                                      </div>

                                                      <?php
                                                        }

                                                      ?>
                                                    </div>
                                                    <div id="error-650" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>
                                    
                                    <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['082']['status']?>"  id="status-082">
                                              <input type="hidden" id="message-082" value="<?=$listvar['input_required']['082']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Class'); ?></label>
                                              <div class="col-sm-6">
                                                <input type="hidden" id="Ruasid_082_0" name="Ruasid[082][0]" value="<?=$taglist['ruasid']['082'][0]?>" size="3" />
                                                <?php echo Html::activeTextInput($modelbib,'Class',['class'=>'form-control','onfocus'=>"AutoCompleteDDC(this);",'style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Kelas').'...']); ?>
                                              <div id="error-082" class="help-block"></div>
                                              </div>
                                              </span>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['084']['status']?>"  id="status-084">
                                              <input type="hidden" id="message-084" value="<?=$listvar['input_required']['084']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'CallNumber'); ?></label>
                                              <div class="col-sm-6">
                                                <input id="CallNumberCount" type="hidden" value="<?=count($listvar['callnumber'])?>">
                                                    <div id="CallNumberList">
                                                      <?php
                                                        if(count($listvar['callnumber']) > 0){
                                                          foreach ($listvar['callnumber'] as $key => $value) {  
                                                      ?>
                                                      <div id="DivCallNumber<?=$key?>">
                                                        <input type="hidden" id="Ruasid_084_<?=$key?>" name="Ruasid[084][$key]" value="<?=$taglist['ruasid']['084'][$key]?>" size="3" />
                                                        <div style="margin-top:5px" class="input-group">
                                                          <input value="<?=$value?>" type="text" id="collectionbiblio-CallNumber-<?=$key?>" class="form-control" name="CollectionBiblio[CallNumber][<?=$key?>]" style="width:100%" placeholder="Masukan CallNumber..." onfocus="AutoCopyCallNumber(this)">
                                                          <span class="input-group-btn">
                                                          <?php 
                                                          if($key == 0)
                                                          {
                                                          ?>
                                                            <button id="btnCallNumber" class="btn btn-success pull-right" type="button" onclick="AddCallNumber();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          <?php
                                                          }else{
                                                          ?>
                                                            <button class="btn btn-danger btn-flat" type="button" onclick="RemoveCallNumber(<?=$key?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                                          <?php
                                                          }
                                                          ?>
                                                          </span>
                                                        </div>
                                                      </div>
                                                      <?php
                                                          }
                                                        }else{
                                                      ?>

                                                      <div id="DivCallNumber0">
                                                        <input type="hidden" id="Ruasid_084_0" name="Ruasid[084][0]" value="<?=$taglist['ruasid']['084'][0]?>" size="3" />
                                                        <div class="input-group">
                                                          <?php echo Html::activeTextInput($modelbib,'CallNumber[]',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_CallNumber').'...','onfocus'=>'AutoCopyCallNumber(this)']); ?>
                                                          <span class="input-group-btn">
                                                            <button id="btnCallNumber" class="btn btn-success pull-right" type="button" onclick="AddCallNumber();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          </span>
                                                        </div>
                                                      </div>

                                                      <?php
                                                        }

                                                      ?>
                                                    </div>
                                                    <div id="error-084" class="help-block"></div>
                                              </div>

                                              </span>
                                            </div>
                                      </div>
                                      <!-- <div class="col-sm-6">
                                          &nbsp;
                                      </div> -->
                                    </div>

                                    
<?php
//Khusus jenis bahan terbitan berkala (serial)
if($isSerial ==1)
{
?>
                                    <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['022']['status']?>"  id="status-022">
                                              <input type="hidden" id="message-022" value="<?=$listvar['input_required']['022']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'ISSN'); ?></label>
                                              <div class="col-sm-6">
                                                <input id="ISSNCount" type="hidden" value="<?=count($listvar['issn'])?>">
                                                    <div id="ISSNList">
                                                      <?php
                                                        if(count($listvar['issn']) > 0){
                                                          foreach ($listvar['issn'] as $key => $value) {  
                                                      ?>
                                                      <div id="DivISSN<?=$key?>">
                                                        <input type="hidden" id="Ruasid_022_<?=$key?>" name="Ruasid[022][<?=$key?>]" value="<?=$taglist['ruasid']['022'][$key]?>" size="3" />
                                                        <div style="margin-top:5px" class="input-group">
                                                          <input value="<?=$value?>" type="text" id="collectionbiblio-issn-<?=$key?>" class="form-control" name="CollectionBiblio[ISSN][<?=$key?>]" style="width:100%" placeholder="Masukan ISSN...">
                                                          <span class="input-group-btn">
                                                          <?php 
                                                          if($key == 0)
                                                          {
                                                          ?>
                                                            <button id="btnISSN" class="btn btn-success pull-right" type="button" onclick="AddISSN();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          <?php
                                                          }else{
                                                          ?>
                                                            <button class="btn btn-danger btn-flat" type="button" onclick="RemoveISSN(<?=$key?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                                          <?php
                                                          }
                                                          ?>
                                                          </span>
                                                        </div>
                                                      </div>
                                                      <?php
                                                          }
                                                        }else{
                                                      ?>

                                                      <div id="DivISSN0">
                                                        <input type="hidden" id="Ruasid_022_0" name="Ruasid[022][0]" value="<?=$taglist['ruasid']['022'][0]?>" size="3" />
                                                        <div class="input-group">
                                                          <?php echo Html::activeTextInput($modelbib,'ISSN[]',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_ISSN').'...']); ?>
                                                          <span class="input-group-btn">
                                                            <button id="btnISSN" class="btn btn-success pull-right" type="button" onclick="AddISSN();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          </span>
                                                        </div>
                                                      </div>

                                                      <?php
                                                        }

                                                      ?>
                                                    </div>
                                                  <div id="error-022" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                    </div>
<?php
}else{
?>
                                    <div class="form-group kv-fieldset-inline">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <span class="<?=$listvar['input_required']['020']['status']?>"  id="status-020">
                                              <input type="hidden" id="message-020" value="<?=$listvar['input_required']['020']['message']?>" />
                                              <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'ISBN'); ?></label>
                                              <div class="col-sm-6">
                                                <input id="ISBNCount" type="hidden" value="<?=count($listvar['isbn'])?>">
                                                    <div id="ISBNList">
                                                      <?php
                                                        if(count($listvar['isbn']) > 0){
                                                          foreach ($listvar['isbn'] as $key => $value) {  
                                                      ?>
                                                      <div id="DivISBN<?=$key?>">
                                                        <input type="hidden" id="Ruasid_020_<?=$key?>" name="Ruasid[020][<?=$key?>]" value="<?=$taglist['ruasid']['020'][$key]?>" size="3" />
                                                        <div style="margin-top:5px" class="input-group">
                                                          <input value="<?=$value?>" type="text" id="collectionbiblio-isbn-<?=$key?>" class="form-control" name="CollectionBiblio[ISBN][<?=$key?>]" style="width:100%" placeholder="Masukan ISBN...">
                                                          <span class="input-group-btn">
                                                          <?php 
                                                          if($key == 0)
                                                          {
                                                          ?>
                                                            <button id="btnISBN" class="btn btn-success pull-right" type="button" onclick="AddISBN();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          <?php
                                                          }else{
                                                          ?>
                                                            <button class="btn btn-danger btn-flat" type="button" onclick="RemoveISBN(<?=$key?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                                          <?php
                                                          }
                                                          ?>
                                                          </span>
                                                        </div>
                                                      </div>
                                                      <?php
                                                          }
                                                        }else{
                                                      ?>

                                                      <div id="DivISBN0">
                                                        <input type="hidden" id="Ruasid_020_0" name="Ruasid[020][0]" value="<?=$taglist['ruasid']['020'][0]?>" size="3" />
                                                        <div class="input-group">
                                                          <?php echo Html::activeTextInput($modelbib,'ISBN[]',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_ISBN').'...']); ?>
                                                          <span class="input-group-btn">
                                                            <button id="btnISBN" class="btn btn-success pull-right" type="button" onclick="AddISBN();"><i class="glyphicon glyphicon-plus"></i></button>
                                                          </span>
                                                        </div>
                                                      </div>

                                                      <?php
                                                        }

                                                      ?>
                                                    </div>
                                                  <div id="error-020" class="help-block"></div>
                                              </div>
                                              </span>
                                            </div>
                                      </div>
                                    </div>
<?php
}
?>

                                  
                                    

                                    </div>
                                    </div>

                                     <div class="panel panel-default ">
                                        <div class="panel-heading">Catatan</div>
                                        <div class="panel-body">
                                          <div class="form-group kv-fieldset-inline">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <span class="<?=$listvar['input_required']['520']['status']?>"  id="status-520">
                                                    <input type="hidden" id="message-520" value="<?=$listvar['input_required']['520']['message']?>" />
                                                    <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Note'); ?></label>
                                                    <div class="col-sm-8">
                                                      <input id="NoteCount" type="hidden" value="<?=count($listvar['note'])?>">
                                                          <div id="NoteList">
                                                            <?php
                                                              if(count($listvar['note']) > 0){
                                                                $count520=0;
                                                                $count502=0;
                                                                $count504=0;
                                                                $count505=0;
                                                                $count500=0;
                                                                foreach ($listvar['note'] as $key => $value) {  

                                                                  if($listvar['notetag'][$key] == '520'){
                                                                      $count520++;
                                                                      $indexruas=$count520-1;
                                                                  }else if($listvar['notetag'][$key] == '502'){
                                                                      $count502++;
                                                                      $indexruas=$count502-1;
                                                                  }else if($listvar['notetag'][$key] == '504'){
                                                                      $count504++;
                                                                      $indexruas=$count504-1;
                                                                  }else if($listvar['notetag'][$key] == '505'){
                                                                      $count505++;
                                                                      $indexruas=$count505-1;
                                                                  }else if($listvar['notetag'][$key] == '500'){
                                                                      $count500++;
                                                                      $indexruas=$count500-1;
                                                                  }
                                                            ?>
                                                            <div id="DivNote<?=$key?>">
                                                              <input type="hidden" id="Ruasid_<?=$listvar['notetag'][$key]?>_<?=$indexruas?>" name="Ruasid[<?=$listvar['notetag'][$key]?>][<?=$indexruas?>]" value="<?=$taglist['ruasid'][$listvar['notetag'][$key]][$indexruas]?>" size="3" />
                                                              <div style="margin-top:5px" class="input-group">
                                                                <textarea name="CollectionBiblio[Note][<?=$key?>]" rows="2" cols="20" id="collectionbiblio-note-<?=$key?>" style="resize: vertical;height:34px;width:100%;" placeholder="Masukan Catatan..." class="form-control"><?=$value?></textarea>
                                                                <span class="input-group-btn" style="vertical-align: bottom">
                                                                <?php 
                                                                if($key == 0)
                                                                {
                                                                ?>
                                                                  <button id="btnNote" class="btn btn-success pull-right" type="button" onclick="AddNote();"><i class="glyphicon glyphicon-plus"></i></button>
                                                                <?php
                                                                }else{
                                                                ?>
                                                                  <button class="btn btn-danger btn-flat" type="button" onclick="RemoveNote(<?=$key?>,'<?=$listvar['notetag'][$key]?>','<?=$indexruas?>')"><i class="glyphicon glyphicon-trash"></i></button>
                                                                <?php
                                                                }
                                                                ?>
                                                                </span>
                                                              </div>
                                                              <div class="btm-add-on"  style="text-align:left">
                                                                   <?php $list = ['520' => 'Abstrak / Anotasi', '502' => 'Catatan Disertasi', '504' => 'Catatan Bibliografi', '505' => 'Rincian Isi', '500' => 'Catatan Umum'];
                                                                   echo Html::activeRadioList($modelbib, 'NoteTag['.$key.']',$list); 
                                                                   ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                              }else{
                                                            ?>

                                                            <div id="DivNote0">
                                                              <input type="hidden" id="Ruasid_520_0"  name="Ruasid[520][0]"  value="<?=$taglist['ruasid'][520][0]?>" size="3" />
                                                              <div class="input-group">
                                                                <?php echo Html::activeTextarea($modelbib,'Note[]',['class'=>'form-control','rows'=>'2','cols'=>'20','style'=>'resize: vertical;height:34px;width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'bib_Catatan').'...']); ?>
                                                                <span class="input-group-btn" style="vertical-align: bottom">
                                                                  <button id="btnNote" class="btn btn-success pull-right" type="button" onclick="AddNote();"><i class="glyphicon glyphicon-plus"></i></button>
                                                                </span>
                                                              </div>
                                                               <div class="btm-add-on"  style="text-align:left">
                                                                   <?php $list = ['520' => 'Abstrak / Anotasi', '502' => 'Catatan Disertasi', '504' => 'Catatan Bibliografi', '505' => 'Rincian Isi', '500' => 'Catatan Umum'];
                                                                   echo Html::activeRadioList($modelbib, 'NoteTag[0]',$list); 
                                                                   ?>
                                                                </div>
                                                            </div>

                                                            <?php
                                                              }

                                                            ?>
                                                          </div>
                                                          <div id="error-520" class="help-block"></div>
                                                    </div>
                                                    </span>
                                                  </div>
                                                </div>
                                          </div>

                                          

                                        </div>
                                      </div>


                                    <?php
                                    if($for == 'cat')
                                    {
                                    ?>
                                    <div class="panel panel-default ">
                                      <div class="panel-body">
                                      <input type="hidden" id="Ruasid_008" name="Ruasid[008]" value="<?=$taglist['ruasid']['008']?>" size="3" />
                                      <?php 
                                      if($rulesform['008_Bahasa'] == 1){
                                      ?>
                                          <div class="form-group kv-fieldset-inline">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'Bahasa'); ?></label>
                                                        <div class="col-sm-6">
                                                          <?php 
                                                          echo Select2::widget([
                                                          'model' => $modelbib,
                                                          'attribute' => 'Bahasa',
                                                          'data'=>ArrayHelper::map(Refferenceitems::findByRefferenceId(5),'Code','Name'),
                                                                            'pluginOptions' => [
                                                                                'allowClear' => false,
                                                                            ]
                                                          ]);?>
                                                        </div>
                                                      </div>
                                                </div>
                                          </div>
                                      <?php 
                                      }
                                      ?>
                                          
                                      <?php 
                                      if($rulesform['008_KaryaTulis'] == 1){
                                      ?>
                                          <div class="form-group kv-fieldset-inline">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'BentukKaryaTulis'); ?></label>
                                                        <div class="col-sm-6">
                                                          <?php 
                                                          echo Select2::widget([
                                                          'model' => $modelbib,
                                                          'attribute' => 'BentukKaryaTulis',
                                                          'data'=>ArrayHelper::map(Refferenceitems::findByRefferenceId(17),'Code','Name'),
                                                                            'pluginOptions' => [
                                                                                'allowClear' => false,
                                                                            ]
                                                          ]);?>
                                                        </div>
                                                      </div>
                                                </div>
                                          </div>
                                        <?php 
                                        }
                                        ?>

                                        <?php 
                                        if($rulesform['008_KelompokSasaran'] == 1){
                                        ?>
                                          <div class="form-group kv-fieldset-inline">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email"><?php echo Html::activeLabel($modelbib,'KelompokSasaran'); ?></label>
                                                        <div class="col-sm-6">
                                                          <?php 
                                                          echo Select2::widget([
                                                          'model' => $modelbib,
                                                          'attribute' => 'KelompokSasaran',
                                                          'data'=>ArrayHelper::map(Refferenceitems::findByRefferenceId(2),'Code','Name'),
                                                                            'pluginOptions' => [
                                                                                'allowClear' => false,
                                                                            ]
                                                          ]);?>
                                                        </div>
                                                      </div>
                                                </div>
                                          </div>
                                        <?php 
                                        }
                                        ?>
                                      </div>
                                    </div>

                                    <?php
                                    }
                                    ?>
                              </div>
                              <?php //ActiveForm::end(); ?>

                            </div>
                        </div>
                      </div>
  </div>
</div>
<?php
//Khusus jenis bahan terbitan berkala (serial)
if($isSerial ==1 && $for=='coll')
{
?>
<div class="box-group" id="cardexbox">
                    <div class="panel panel-default">
                      <div class="box-header with-border">
                            <div class="col-xs-12 col-sm-12" >
                                  <h4 class="box-title">
                                      <a data-toggle="collapse" data-parent="#cardexbox" href="#collapseTwo2">
                                        Cardex (Edisi Serial)
                                      </a>
                                  </h4>
                            </div>
                      </div>
                      <div id="collapseTwo2" class="panel-collapse collapse in">
                        <div class="box-body">
                                 <div class="form-group kv-fieldset-inline">
                                    <div class="col-sm-8">
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="email"><?php echo Html::activeLabel($model,'EDISISERIAL'); ?></label>
                                            <div class="col-sm-8">
                                              <?php echo Html::activeTextInput($model,'EDISISERIAL',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'coll_Edisiserial').'...']); ?>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-sm-4">
                                        &nbsp;
                                    </div>
                                  </div>

                                  <div class="form-group kv-fieldset-inline">
                                    <div class="col-sm-8">
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="email"><?php echo Html::activeLabel($model,'TANGGAL_TERBIT_EDISI_SERIAL'); ?></label>
                                            <div class="col-sm-8">

                                              <?php 
                                              echo MaskedDatePicker::widget(
                                              [
                                                'model' => $model, 
                                                'attribute' => 'TANGGAL_TERBIT_EDISI_SERIAL',
                                                'enableMaskedInput' => true,
                                                'maskedInputOptions' => [
                                                    'mask' => '99-99-9999',
                                                    'pluginEvents' => [
                                                        'complete' => "function(){console.log('complete');}"
                                                    ]
                                                ],
                                               'removeButton' => false,
                                               'options'=>[
                                                                'style'=>'width:170px',
                                                            ],
                                                'pluginOptions' => [
                                                              'autoclose' => true,
                                                              'todayHighlight' => true,
                                                              'format'=>'dd-mm-yyyy',
                                                            ]
                                              ]);
                                              ?>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-sm-4">
                                        &nbsp;
                                    </div>
                                  </div>

                                  <div class="form-group kv-fieldset-inline">
                                    <div class="col-sm-8">
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="email"><?php echo Html::activeLabel($model,'BAHAN_SERTAAN'); ?></label>
                                            <div class="col-sm-8">
                                              <?php echo Html::activeTextInput($model,'BAHAN_SERTAAN',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'coll_Bahan  Sertaan').'...']); ?>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-sm-4">
                                        &nbsp;
                                    </div>
                                  </div>

                                  <div class="form-group kv-fieldset-inline">
                                    <div class="col-sm-8">
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="email"><?php echo Html::activeLabel($model,'KETERANGAN_LAIN'); ?></label>
                                            <div class="col-sm-8">
                                              <?php echo Html::activeTextInput($model,'KETERANGAN_LAIN',['class'=>'form-control','style'=>'width:100%','placeholder'=>Yii::t('app', 'Enter').' '.Yii::t('app', 'coll_Keterangan  Lain').'...']); ?>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-sm-4">
                                        &nbsp;
                                    </div>
                                  </div>

                          </div>
                      </div>
                    </div>
</div>
<?php
}
?>
<input type="hidden" id="hdnAjaxUrlTajukPengarang" value="<?=Yii::$app->urlManager->createUrl(["pengkatalogan/katalog/tajuk-pengarang"])?>">
<input type="hidden" id="hdnAjaxUrlTajukSubyek" value="<?=Yii::$app->urlManager->createUrl(["pengkatalogan/katalog/tajuk-subyek"])?>">
<input type="hidden" id="hdnAjaxUrlDDC" value="<?=Yii::$app->urlManager->createUrl(["pengkatalogan/katalog/tajuk-ddc"])?>">
<?php 
/*$taglistnya = \Yii::$app->session['taglist'];  
echo '<pre>'; print_r($taglistnya['inputvalue']); echo '</pre>'; */

$this->registerJsFile( 
    Yii::$app->request->baseUrl.'/assets_b/js/catalogs_simple.js'
);
?>

