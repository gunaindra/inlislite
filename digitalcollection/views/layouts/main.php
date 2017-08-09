<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use opac\assets_b\AppAsset;
use common\widgets\Alert;
use kartik\datecontrol\DateControl;
use kartik\datetime\DateTimePicker;
use kartik\widgets\DatePicker;
use common\models\Collections;
use common\models\Refferenceitems;
use common\models\Worksheets;
use common\components\OpacHelpers;
AppAsset::register($this);
$homeUrl=Yii::$app->homeUrl;
$base=Yii::$app->controller->route;
$dateNow = new \DateTime("now");
$bahasa = Refferenceitems::find()
    ->where(['Refference_id' => 5])
    ->all();
$bentukKarya = Refferenceitems::find()
    ->where(['Refference_id' => 17])
    ->all();
$targetPembaca = Refferenceitems::find()
    ->where(['Refference_id' => 2])
    ->all();
$Worksheets= OpacHelpers::sortWorksheets(Worksheets::find()->asArray()->all());
$dataExtension = Yii::$app->db->createCommand("SELECT DISTINCT SUBSTRING(FileURL,(LENGTH(FileURL)-LOCATE('.',REVERSE(FileURL)))+2) type  FROM catalogfiles;")-> queryALL(); 

$noAnggota =(!Yii::$app->user->isGuest ? \Yii::$app->user->identity->NoAnggota : '' );

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Layanan Koleksi Digital - Perpusnas RI</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type='image/x-icon' href="<?=Yii::$app->urlManager->createUrl('../uploaded_files/aplikasi/favicon.png');?>">


    <!--  <link rel="shortcut icon" type='image/x-icon' href="../..<?=Yii::getAlias('@upload')."/aplikasi/favicon.png"?>"> -->

    <?php $this->head() ?>

</head>


<body onload="startTime()" class="skin-blue layout-top-nav">
    <div class="wrapper" style=" background-color: #FFF;">
        <!-- Header web -->
        <header class="main-header">
            <!-- navbar -->
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <div class="title">
                           <!--  <div class="image"> <a href='<?=$homeUrl?>'> <img src="../<?=Yii::getAlias('@upload')."/aplikasi/logo_perpusnas_2015.png"?>" class="img-logo" height="65" width="70"> </a></div> -->
                           <!--  <div class="image"> <a href='<?=$homeUrl?>'> <img src="<?= Yii::$app->urlManager->createUrl('../uploaded_files/aplikasi/logo_perpusnas_2015.png') ?>" class="img-logo" height="65" width="70"> </a></div> -->
                            <div class="image"><a href="<?php echo $homeUrl; ?>"><img src="<?= Yii::$app->urlManager->createUrl('../uploaded_files/aplikasi/logo_perpusnas_2015.png') ?>" class="img-logo" height="65" width="70"></a></div> 
                            <div class="text">
                                <h3 style="margin-top: 20px;">Layanan Koleksi Digital</h3>
                                <div class="clear"></div>
                                <div class="time"><?= Yii::$app->config->get('NamaPerpustakaan') ?></div><br/>
                                <div class="clear"></div>
                                <div class="timeddr" style="margin-bottom: 10px"><?= Yii::$app->request->cookies->getValue('location_detail')['Address'] ?></div>
                                <div class="clear"></div>
                            </div>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                            <div class="clear">
                            </div>
                        </div>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                        <span class="pull-right" style="color:#fff; margin-right:5px; margin-top:5px" id="clocktime" ></span><br>
                        <ul class="nav navbar-nav pull-right">        
            
                    <li> <a class="bookmarkShow" href="javascript:void(0)"  onclick='tampilBooking()' ></a> </li>     
                    <li> <a href="<?php echo $homeUrl."bookmark"; ?>">Tampung</a> </li>
                      <?php 
                      if (Yii::$app->user->isGuest) {
                        echo"

                         <li> <a href=\"javascript:void(0)\"  onclick='tampilLogin()'>Login</a> </li>
                        <li> <a href=\"../".Url::to('pendaftaran')."\">Registrasi</a> </li>
                        ";
                      } else {
                        echo"
                        <li> <a href=\"".$homeUrl."site/logout  \">Logout (" . $noAnggota.")</a> </li>

                        ";

                        $_SESSION['__NoAnggota']= $noAnggota;
                      }
                      ?>
                          <!-- <li> <a href="#">Login</a> </li>
                          <li> <a href="#">Registrasi</a> </li> -->
                  </ul>

                    </div><!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <!-- /.navbar-custom-menu -->
                </div><!-- /.container-fluid -->
            </nav>
            <!-- /navbar -->
        </header>

           <?php 
            if ($base!='pencarian-lanjut/index' && $base!='browse/index') {
              ?>
                <section class="content-search">
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-12">
                      <span class="nav-tabs-custom">
                          <ul class="nav nav-tabs">
                            <li class="active"> <a href="#tab_1" data-toggle="tab">Cari</a> </li>
                    <li> <a href="<?= $homeUrl; ?>browse">Browse</a> </li>

                          </ul>
                        </span>
                        </div>
                        </div>
                    <form action="<?php echo $homeUrl; ?>pencarian-sederhana" method="GET"/>
                    <input type="hidden" name="action" value="pencarianSederhana"/>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                  <div class="col-sm-4"><div class="form-group">
                          <input type="text" class="form-control" name="katakunci" id="KataKunci" placeholder="Kata Kunci" size="25" ></div></div>
                      <div class="col-sm-4"><div class="form-group">

                    <select  class="form-control" name="ruas">
                      <option value="Judul">Judul</option>
                      <option value="Pengarang">Pengarang</option>
                      <option value="Penerbit">Penerbitan</option>
                      <option value="Subyek">Subyek</option>
                      <option value="Nomor Panggil">Nomor Panggil</option>
                      <option value="ISBN">ISBN</option>
                      <option value="ISSN">ISSN</option>                    
                      <option value="ISMN">ISMN</option>
                      <option value="Semua Ruas">Sembarang</option> 

                    </select>
                              </form>
                      </div></div>
                      <div class="col-sm-3"><div class="form-group">

							<select class="form-control" name="bahan" >
								<?php
								foreach ($dataExtension as $value) {
								echo"<option value=\"".$value['type']."\">.".$value['type']."</option>";
								}

								?>
								<option value="Semua Format File" selected>Semua Format File</option>

							</select>
                              
                      </div></div>
                      <div class="col-sm-1"><input class="btn btn-success" type="submit" value="Cari"  align="right"></div>
                   </div>

                   </div>
                  <div class="row">&nbsp;</div>
                  <div class="row">
                  <div class="col-sm-12">&nbsp; &nbsp; <a href="<?php echo $homeUrl."pencarian-lanjut"; ?>">Pencarian lanjut </a> - <a href="<?php echo $homeUrl."riwayat-pencarian"; ?>">Riwayat Pencarian </a> - <a href="" data-toggle="modal" data-target="#modalBantuan">Bantuan</a> </div>
                  </div>
                  

                 <!-- Modal -->
                  <div class="modal fade" id="modalBantuan" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Bantuan</h4>
                        </div>
                        <div class="modal-body">

                            <ul>
                            <li> Pencarian sederhana adalah pencarian koleksi dengan menggunakan hanya satu kriteria pencarian saja. </li>
                            <li> Ketikkan kata kunci pencarian, misalnya : " Sosial kemasyarakatan "  </li>
                            <li> Pilih ruas yang dicari, misalnya : " Judul " . </li>
                            <li> Pilih jenis koleksi misalnya  " Monograf(buku) ", atau biarkan pada  pilihan " Semua Jenis Bahan "</li>
                            <li> Klik tombol "Cari" atau tekan tombol Enter pada keyboard </li>

                        </ul>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                      </div>

                    </div>
                  </div>
                    
                    </div>
                </section>
              <?php
            }
            elseif ($base=='pencarian-lanjut/index') {
              ?>
               <div class="content-wrapper">
               <div class="container">
                <section class="content">
                  <div class="box box-default">
                    <div class="box-body" style="padding:20px 0">
                      
                    <form method="GET" action="<?php echo $homeUrl; ?>pencarian-lanjut">
                      <div id="Dynamic">
                        
                        <div class="row">
                            <div class="col-sm-1"> </div>
                            <div class="col-sm-1"> <label>Jenis Bahan</label> </div>
                            <input type="hidden" name="action" value="pencarianLanjut"  />
                            <div class="col-sm-3"> 
							<select class="form-control" name="bahan" >
								<?php
								foreach ($dataExtension as $value) {
								//echo $value['type']."</br>";
								echo"<option value=\"".$value['type']."\">.".$value['type']."</option>";
								}

								?>
								<option value="Semua Format File" selected>Semua Format File</option>

							</select>

                            </div>
                            <div class="col-sm-2"> <label>Bahasa</label> </div>
                            <div class="col-sm-3"> 

                              <select  name="bahasa" class="form-control">
                                <?php
                                for ($i=1; $i <sizeof($bahasa)-1 ; $i++) { 
                                   echo"<option value=\"".$bahasa[$i]['Code']."\">".$bahasa[$i]['Name']."</option>";
                                }

                                ?>
                                <option value="" selected>Semua Bahasa</option>

                              </select>

                            </div> 
                            <div class="col-sm-2">&nbsp;</div>
                            </div>
                          <div class="row">
                            <div class="col-sm-1"> </div>
                            <div class="col-sm-1"> <label>Target pembaca</label> </div>
                            <input type="hidden" name="action" value="pencarianLanjut"  />
                            <div class="col-sm-3"> 
                              <select name="targetPembaca" class="form-control">
                                <?php
                                for ($i=1; $i <sizeof($targetPembaca)-1 ; $i++) { 
                                   echo"<option value=\"".$targetPembaca[$i]['Code']."\">".$targetPembaca[$i]['Name']."</option>";
                                }

                                ?>
                                <option value="" selected>Semua Umur</option>
                              </select>

                            </div>
                            <div class="col-sm-2"> <label>Bentuk Karya</label> </div>
                            <div class="col-sm-3"> 

                              <select  name="bentukKarya" class="form-control">
                                <?php
                                for ($i=0; $i <sizeof($bentukKarya)-2 ; $i++) { 
                                   echo"<option value=\"".$bentukKarya[$i]['Code']."\">".$bentukKarya[$i]['Name']."</option>";
                                }

                                ?>
                                <option value="" selected>Semua Bentuk Karya</option>

                              </select>

                            </div> 
                            <div class="col-sm-2">&nbsp;</div>
                          </div>
                          <div class="row">
                            <div class="col-sm-1"> </div>
                            <div class="col-sm-1">
                              <label>Kata Kunci</label> </div>
                              <div class="col-sm-3"> 
                                <input type="text" class="form-control login-field" name="katakunci[]" />
                               </div>
                              <div class="col-sm-2">

                                <select  name="jenis[]"class="form-control">
                                  <option value="di dalam">di dalam</option>
                                  <option value="di awal">di awal</option>
                                  <option value="di akhir">di akhir</option>
                                </select>

                               </div>
                              <div class="col-sm-3">                  
                                  <select name="tag[]" class="form-control">
                                    <option value="Judul">Judul</option>
                                    <option value="Pengarang">Pengarang</option>
                                    <option value="Penerbitan">Penerbitan</option>
                                    <option value="Edisi">Edisi</option>
                                    <option value="Deskripsi Fisik">Deskripsi Fisik</option>
                                    <option value="Jenis Konten">Jenis Konten</option>
                                    <option value="Jenis Media">Jenis Media</option>
                                    <option value="Media Carrier">Media Carrier</option>
                                    <option value="Subyek">Subyek</option>
                                    <option value="ISBN">ISBN</option>
                                    <option value="ISSN">ISSN</option>
                                    <option value="ISMN">ISMN</option>
                                    <option value="Nomor Panggil">ISBN</option>
                                    <option value="Sembarang Ruas">Sembarang Ruas </option>
                                  </select>

                              </div>
                                <div class="col-sm-2"><a href="" id="AddInpElem"> <span  class="glyphicon glyphicon-plus-sign"> </span> </a> </div> 

                      </div>
                                      
                      </div> <!--div dinamic -->
                                                           
                                
                          </br>   
                              
                          <div class="row">
                            <div class="col-sm-2"> </div>
                            <div class="col-sm-1"> <div class="form-group"><input type="submit" class="btn btn-success btn-sm btn-block"value="Cari"/> </div> </div>
                            <div class="col-sm-9"> </div>
                          </div>
                                    
                              </form>


                    </div>           
                  </div>
                </section>
                </div>
                </div>
                

                <?php
            }
            ?>
           <!-- Full Width Column -->
           <div id="alert">
          </div>

        <?php $this->beginBody() ?>
        <div class="content-wrapper" style="min-height: 507px;">
            <div class="container">
                <!-- Content Header (Page header) -->

                <!-- Main content -->
                <section class="content">
                 <!--   <?= Alert::widget() ?>  -->
                    <div class="box box-default">
                        <?= $content ?>
                    </div>
                </section><!-- /.content -->
            </div><!-- /.container -->
        </div><!-- /.content-wrapper -->


    <footer class="footer main-footer">
      <div class="container">
        <div class="pull-right hidden-sm" style="font-family: "Corbel", Arial, Helvetica, sans-serif;">
          <?=\Yii::$app->params['footerInfoRight'];?>
        </div>
        <?=\Yii::$app->params['footerInfoLeft'];?>
      </div> <!-- /.container -->
    </footer>
        <?php $this->endBody() ?>
    </div><!-- ./wrapper -->
</body>
</html>
<?php $this->endPage() ?>

<script>
    //alert(Date());
  function startTime()
  {   var today=new Date();
    var weekday=new Array(7);
    var weekday=["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
    var monthname=new Array(12);
    var monthname=["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","Septeber","Oktober","November","Desember"];
    var dayname=weekday[<?= date('w')?>];
    var day=<?= date('d')?>;
    var month=monthname[<?= date('m')?>];
    var year=<?= date('Y')?>;
    var h=<?= date('h')?>;
    var m=<?= date('i')?>;
    var s=<?= date('s')?>;
    h=checkTime(h);
    m=checkTime(m);
    s=checkTime(s);
    document.getElementById('clocktime').innerHTML=dayname+", "+day+" "+month+" "+year+", "+h+":"+m+":"+s;
    t=setTimeout(function(){startTime()},500);
  }
  // function checkTime to add a zero in front of numbers < 10
  function checkTime(i)
  {   if(i<10){i="0"+i;}
    return i;
  }
  function getData(dropdown) {
    var value = dropdown.options[dropdown.selectedIndex].value;
    if(document.getElementById("dariTGL").style.display == "inline"){

    }
    document.getElementById("dariTGL").style.display = "none"
    document.getElementById("sampaiTGL").style.display = "none"
    if (value == '4'){   
      document.getElementById("dariTGL").style.display = "inline"
      document.getElementById("sampaiTGL").style.display = "inline"
    }
  }

    function tampilBooking() {
        $.ajax({
            type: "POST",
            cache: false,
            url: "booking?action=showBookingDetail",
            success: function (response) {
                $("#modalBooking").modal('show');
                $("#BookingShow").html(response);
            }
        });
    }

      function tampilLogin() {
        $.ajax({
            type: "POST",
            cache: false,
            url: "site/login",
            success: function (response) {
                $("#modalLogin").modal('show');
                $("#LoginShow").html(response);
            }
        });
    }

    function cancelBooking(id) {
        $.ajax({
            type: "POST",
            cache: false,
            url: "booking?action=cancelBooking&colID="+id,
            success: function (response) {
                $("#modalBooking").modal('hide');
                $("#alert").html(response);
            }
        });
    }
    function loginAnggota() {
        $.ajax({
            type: "POST",
            cache: false,
            url: "site/loginanggota",
            data : $("#login-anggota").serialize(), 
            success: function (response) {
                console.log(response);
                if (response) {
                  $("#error-login-opac-123-321").html(response);
                }
            }

        });
    }

  var MaxInputs = 50;
  var Dynamic = $("#Dynamic");
  var i = $("#Dynamic div").size() + 1;

  $("#AddInpElem").click( function () {
    if (i <= MaxInputs) {
      $("<div> <div class=\"row\">  <div class=\"col-sm-1\"></div>  <div class=\"col-sm-1\"><div class=\"form-group\"><select name=\"danAtau[]\" class=\"form-control\"><option value=\"and\">dan</option>  <option value=\"or\">atau</option>   <option value=\"selain\">selain</option>      </select></div></div><div class=\"col-sm-3\"><div class=\"form-group\">  <input name=\"katakunci[]\"  type=\"text\" class=\"form-control login-field\"  /></div></div><div class=\"col-sm-2\"><div class=\"form-group\"> <select name=\"jenis[]\" class=\"form-control\"><option>di dalam</option><option >di awal</option><option >di akhir</option> </select></div></div><div class=\"col-sm-3\"><div class=\"form-group\"><select   name=\"tag[]\" class=\"form-control\"> <option value=\"Judul\">Judul</option> <option value=\"Pengarang\">Pengarang</option> <option value=\"Penerbitan\">Penerbitan</option> <option value=\"Edisi\">Edisi</option> <option value=\"Deskripsi Fisik\">Deskripsi Fisik</option> <option value=\"Jenis Konten\">Jenis Konten</option> <option value=\"Jenis Media\">Jenis Media</option> <option value=\"Media Carrier\">Media Carrier</option> <option value=\"Subyek\">Subyek</option> <option value=\"ISBN\">ISBN</option> <option value=\"ISSN\">ISSN</option> <option value=\"ISMN\">ISMN</option> <option value=\"Nomor Panggil\">ISBN</option> <option value=\"Sembarang Ruas\">Sembarang Ruas </option>       </select> </div></div><a href=\"javascript:void(0)\" class=\"RemInpElem\"><span class=\"glyphicon glyphicon-minus-sign\"></span></a> &nbsp; </div> </div>").appendTo(Dynamic);
      i++;
    }
    return false;
  });


$("body").on("click",".RemInpElem", function(){
  if (i > 2) {
    $(this).parent("div").remove();
    i--;
  }
  return false;
}) 


</script>

<div class="modal fade" id="modalBooking" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Booking Detail</h4>
            </div>
            <div class="modal-body">
                <p id="demo"></p>
                <div id="BookingShow">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalLogin" role="dialog">
    <div class="modal-dialog modal-sm" >       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login Anggota</h4>
            </div>
            <div class="modal-body ">
                <p id="demo"></p>
                <div id="LoginShow">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalBantuan" role="dialog">
    <div class="modal-dialog">       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bantuan</h4>
            </div>
            <div class="modal-body">
                <ul>
              <li> Pencarian sederhana adalah pencarian koleksi dengan menggunakan hanya satu kriteria pencarian saja. </li>
              <li> Ketikkan kata kunci pencarian, misalnya : " Sosial kemasyarakatan "  </li>
              <li> Pilih ruas yang dicari, misalnya : " Judul " . </li>
              <li> Pilih jenis koleksi misalnya  " Monograf(buku) ", atau biarkan pada  pilihan " Semua Jenis Bahan "</li>
              <li> Klik tombol "Cari" atau tekan tombol Enter pada keyboard </li>
          </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

 