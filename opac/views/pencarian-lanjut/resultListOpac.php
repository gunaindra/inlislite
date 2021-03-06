<?php

use yii\widgets\ListView;
use yii\web\Session;
use yii\helpers\Url;
use yii\helpers\Html;
use common\components\DirectoryHelpers;

$base = Yii::$app->homeUrl;
Yii::$app->controller->module->id;

$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 10;
$offset = ceil($page / $limit);
$fAuthor = ( isset($_GET['fAuthor']) ) ? urldecode($_GET['fAuthor']) : '';
$fPublisher = ( isset($_GET['fPublisher']) ) ? urldecode($_GET['fPublisher']) : '';
$fPublishLoc = ( isset($_GET['fPublishLoc']) ) ? urldecode($_GET['fPublishLoc']) : '';
$fPublishYear = ( isset($_GET['fPublishYear']) ) ? urldecode($_GET['fPublishYear']) : '';
$fSubject = ( isset($_GET['fSubject']) ) ? urldecode($_GET['fSubject']) : '';
$FacedAuthorMax=Yii::$app->config->get('FacedAuthorMax');
$FacedAuthorMin=Yii::$app->config->get('FacedAuthorMin');
$FacedPublisherMax=Yii::$app->config->get('FacedPublisherMax');
$FacedPublisherMin=Yii::$app->config->get('FacedPublisherMin');
$FacedPublishLocationMax=Yii::$app->config->get('FacedPublishLocationMax');
$FacedPublishLocationMin=Yii::$app->config->get('FacedPublishLocationMin');
$FacedPublishYearMax=Yii::$app->config->get('FacedPublishYearMax');
$FacedPublishYearMin=Yii::$app->config->get('FacedPublishYearMin');
$FacedSubjectMax=Yii::$app->config->get('FacedSubjectMax');
$FacedSubjectMin=Yii::$app->config->get('FacedSubjectMin');
$action = $_GET['action'];
//$katakunci=urldecode($_GET['katakunci']);
if ($alert == TRUE) {
    foreach (Yii::$app->session->getAllFlashes() as $message):;

        echo \kartik\widgets\Growl::widget([
            'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
            'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'showSeparator' => true,
            'delay' => 1, //This delay is how long before the message shows
            'pluginOptions' => [
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                ]
            ]
        ]);

    endforeach;
}
foreach ($_GET['katakunci'] as $katakunci) {
    $katakunci = urldecode($katakunci);
}

if ($action === 'pencarianLanjut') {
    //$ruas=$_GET['ruas'];
    $bahan = $_GET['bahan'];
}
?>

<?= Html::csrfMetaTags() ?>		
<script type="text/javascript">

    function favorite(id) {
        //var id = $("#catalogID").val();
        $.ajax({
            type: "POST",
            cache: false,
            url: "?action=favourite&catID=" + id,
            success: function (response) {
                $("#favourite" + id).html(response);
            }
        });


    }
    function collection(CatID, Serial) {
        //var id = $("#catalogID").val();
        $.ajax({
            type: "POST",
            cache: false,
            url: "?action=showCollection&catID=" + CatID + "&serial=" + Serial,
            success: function (response) {
                $("#collectionShow" + CatID).html(response);
            }
        });


    }
    function search(id) {
        //var id = $("#catalogID").val();
        $.ajax({
            type: "POST",
            cache: false,
            url: "?action=search&catID=" + id,
            success: function (response) {
                $("#search" + id).html(response);
            }
        });


    }
    function kontenDigital(id) {
        //var id = $("#catalogID").val();
        $.ajax({
            type: "GET",
            cache: false,
            url: "?action=showKontenDigital&catID=" + id,
            success: function (response) {
                $("#kontenDigitalShow" + id).html(response);
            }
        });


    }

    function usulanKoleksi() {
        var formData = {
            'NomorAnggota'  : $('input[name=NomorAnggota]').val(),
            'JenisBahan'    : $('#JenisBahan').val(),
            'Judul'         : $('input[name=Judul]').val(),
            'Pengarang'     : $('input[name=Pengarang]').val(),
            'KotaTerbit'    : $('input[name=KotaTerbit]').val(),
            'Penerbit'      : $('input[name=Penerbit]').val(),
            'TahunTerbit'   : $('input[name=TahunTerbit]').val(),
            'Keterangan'    : $('textarea#Keterangan').val()

        };
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/pencarian-sederhana/usulan' ?>',
            type: 'post',
            data: {
                formData,
                        _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
            },
            success: function (response) {
                $("#modalUsulan").modal('hide');
                $("#usulan").html(response);

            }

        });


    }


</script>


<?php if ($totalCountResult == 0) {
    ?>

    <p class="text-center">Data tidak ditemukan </p>
<?php if(Yii::$app->config->get('UsulanKoleksi') == 'TRUE'){?>
<p class="text-center"><a href="./usulan-koleksi"  >klik disini</a> untuk mengusulkan koleksi yang anda butuhkan.</p>
<?php }?>
    <div class="modal fade" id="modalUsulan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Form Usulan Koleksi</h4>
                </div>
                <div class="modal-body">













                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="NomorAnggota">Nomor Anggota:</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="NomorAnggota" name="NomorAnggota" placeholder="Nomor Anggota">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Jenis Bahan</label>
                            <div class="col-xs-8">
                                <select class="form-control" name="JenisBahan" id="JenisBahan">
                                    <option>Date</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="Judul">Judul</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="Judul" name="Judul" placeholder="Judul">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="Pengarang">Pengarang</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="Pengarang" name="Pengarang" placeholder="Pengarang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="KotaTerbit">KotaTerbit</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="KotaTerbit" name="KotaTerbit" placeholder="KotaTerbit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="Penerbit">Penerbit</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="Penerbit" name="Penerbit" placeholder="Penerbit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3" for="TahunTerbit">TahunTerbit</label>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" id="TahunTerbit" name="TahunTerbit" placeholder="TahunTerbit">
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="control-label col-xs-3" for="Keterangan">Keterangan:</label>
                            <div class="col-xs-8">
                                <textarea class="form-control" rows="2" id="Keterangan" name="Keterangan" placeholder="Keterangan"></textarea>
                            </div>
                        </div>
                        <br>

                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="usulanKoleksi()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    ?>
    <section class="content">
        <div class="box box-default">
            <div class="box-body" style="padding:20px 0">
                <div class="breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="<?= $base; ?>">Home</a></li>
                        <li><a href="#">Pencarian Lanjut</a></li>
                        <li class="active"><?= $katakunci; ?></li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $awal = ($page == 1) ? $page : (($page - 1) * $limit) + 1;
                        $akhir = $page * $limit;
                        if ($akhir > $totalCountResult) {
                            $akhir = $totalCountResult;
                        }
                        echo"Menampilkan <b>" . $awal . " - " . $akhir . "</b> dari <b>" . $totalCountResult . "</b> hasil <br> <br>";
                        ?>


                        <script language="JavaScript">
                            function toggle(source) {
                                checkboxes = document.getElementsByName('catID[]');
                                for (var i = 0, n = checkboxes.length; i < n; i++) {
                                    checkboxes[i].checked = source.checked;
                                }
                            }
                        </script>
                        <!-- Modal -->
                        <div class="modal fade" id="modalBooking" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
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
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-9">
                        <form id="theForm" method="POST" action="">
                            <input type="checkbox" onClick="toggle(this)"> Pilih semua &nbsp; &nbsp; &nbsp;
                            <input type="submit" class="btn btn-default btn-xs navbar-btn" value="Tambah ke tampung">
                           <!--  <a href="javascript:void(0)" class="btn btn-default btn-xs navbar-btn" onclick='tampilBooking()' >Lihat Pesanan</a> <br> -->
                            <input type="hidden" value="keranjang" name="action"/>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                            <table class="table2 table-striped" width="100%">

                                <?php
                                $homeUrl = Yii::$app->homeUrl;
                                $detail_url = Yii::$app->urlManager->createAbsoluteUrl('detail-opac');
                                $pengarang_url = Yii::$app->urlManager->createAbsoluteUrl('pencarianSederhana');

                                for ($i = 1; $i <= $countResult; $i++) {

                                    if($dataResult[$i]['CoverURL'])
                                    {

                                         if(file_exists(Yii::getAlias('@uploaded_files/sampul_koleksi/original/'.DirectoryHelpers::GetDirWorksheet($dataResult[$i]['worksheet_id']).'/'.$dataResult[$i]['CoverURL'])))
                                        {
                                             $urlcover= '../uploaded_files/sampul_koleksi/original/'.DirectoryHelpers::GetDirWorksheet($dataResult[$i]['worksheet_id']).'/'.$dataResult[$i]['CoverURL'];
                                        }
                                        else {
                                             $urlcover= '../uploaded_files/sampul_koleksi/original/Monograf/tdkada.gif';
                                        }
                                    }else{
                                        $urlcover= '../uploaded_files/sampul_koleksi/original/Monograf/tdkada.gif';
                                    }



                                    
                                    $pengarang = explode(";", $dataResult[$i]['author']);
                                    if ($dataResult[$i]['worksheet_id'] == 4) {
                                        $serial[$i] = 'true';
                                    } else {
                                        $serial[$i] = 'false';
                                    }
                                    ?>
                                    <tr><td>
                                            <div id="search<?= $dataResult[$i]['CatalogId']; ?>">
                                                <div class="row">
                                                    <div class="col-sm-1"><?php
                                                        if ($page == 1) {
                                                            echo $i;
                                                        } else {
                                                            echo ($page - 1) * $limit + $i;
                                                        }
                                                        ?> &nbsp;
                                                        <input type="checkbox" name="catID[]" value="<?= $dataResult[$i]['CatalogId']; ?>"  >
                                                        <input type="hidden"  id='catalogID<?= $dataResult[$i]['CatalogId']; ?>'  name="catalogID" value="<?= $dataResult[$i]['CatalogId']; ?>"> &nbsp;
                                                        <div id="favourite<?= $dataResult[$i]['CatalogId'] ?>">
                                                         <?php 
                                                        if (!isset($noAnggota)) {
                                                             echo "<a href=\"javascript:void(0)\" onclick=\"tampilLogin()\"title=\"Tambah ke Favorite\"><span class=\"glyphicon glyphicon-star\"></span></a>";
                                                        }
                                                         else echo"<a onclick=\"favorite(".$dataResult[$i]['CatalogId'].")\" href=\"javascript:void(0)\"  title=\"Tambah ke Favorite\"><span class=\"glyphicon glyphicon-star\"></span></a>";  
                                                         ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2"><a ><img src="<?= $urlcover ?>" style="width:97px ; height:144px"></a></div>
                                                    <div class="col-sm-9">
                                                        <table class="table2" style="background:transparent" width="100%">
                                                            <tr>
                                                                <th colspan="2">  <a href="<?= $detail_url."?id=".$dataResult[$i]['CatalogId']; ?>" class="topnav-content"> <?= $dataResult[$i]['kalimat2'] ?> </a></th>
                                                            </tr>
                                                            <tr>
                                                                <td width="22%">Jenis Bahan</td>
                                                                <td width="78%"><?= $dataResult[$i]['worksheet']; ?></td>
                                                            </tr>
                                                            <?php
                                                            for ($x = 0; $x < sizeof($pengarang); $x++) {
                                                                if ($x == 0) {
                                                                    echo"
                                                                        <tr>
                                                                        <td>Pengarang</td>
                                                                        <td><a href=\".\?action=pencarianSederhana&ruas=Pengarang&bahan=" . $dataResult[$i]['worksheet_id'] . "&katakunci=" . $pengarang[$x] . "\"> " . $pengarang[$x] . " </a></td>

                                                                        </tr>


                                                                        ";
                                                                } else {

                                                                    echo"
                                                                        <tr>
                                                                        <td></td>
                                                                        <td><a href=\".\?action=pencarianSederhana&ruas=Pengarang&bahan=" . $dataResult[$i]['worksheet_id'] . "&katakunci=" . $pengarang[$x] . "\"> " . $pengarang[$x] . " </a></td>

                                                                        </tr>


                                                                        ";
                                                                }
                                                            }
                                                            ?>

                                                            <tr>
                                                                <td>Penerbitan</td>
                                                                <td><?=
                                                                    $dataResult[$i]['PublishLocation'] . " " . $dataResult[$i]['publisher'];
                                                                    echo $dataResult[$i]['PublishYear'];
                                                                    ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Konten Digital</td>
                                                                <td> <?php
                                                                    if ($dataResult[$i]['KONTEN_DIGITAL'] == NULL) {
                                                                        $dataResult[$i]['KONTEN_DIGITAL'] = "Tidak Ada Data";
                                                                    } else {
                                                                        echo"<a data-toggle='collapse' data-target='#collapseKontenDigital" . $dataResult[$i]['CatalogId'] . "'  class='show_hide' id='showmenu" . $dataResult[$i]['CatalogId'] . "' onclick='kontenDigital(" . $dataResult[$i]['CatalogId'] . ")' href='javascript:void(0)' >";
                                                                    } echo $dataResult[$i]['KONTEN_DIGITAL'];
                                                                    ?> </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ketersediaan</td>
                                                                <td> <?php
                                                                    if ($dataResult[$i]['ALL_BUKU'] != 0) {
                                                                        echo"<a data-toggle='collapse' data-target='#collapsecollection" . $dataResult[$i]['CatalogId'] . "'  id='showmenu" . $dataResult[$i]['CatalogId'] . "' onclick='collection(" . $dataResult[$i]['CatalogId'] . "," . $serial[$i] . ")' href='javascript:void(0)' >";
                                                                    } echo $dataResult[$i]['JML_BUKU'] . " dari " . $dataResult[$i]['ALL_BUKU'] . " ekslempar";
                                                                    ?> </a></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-1">&nbsp;</div>
                                                    <div class="col-sm-11">
                                                        <div class="collapse" id="collapseKontenDigital<?= $dataResult[$i]['CatalogId']; ?>">
                                                            <div id="kontenDigitalShow<?= $dataResult[$i]['CatalogId']; ?>">

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="collapse" id="collapsecollection<?= $dataResult[$i]['CatalogId']; ?>">
                                                            <div id="collectionShow<?= $dataResult[$i]['CatalogId']; ?>">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td></tr>



                                    <?php
                                }
                                ?>


                            </table>
                        </form>

                        <div class="modal fade" id="myModal123" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

                        <!--awal paging -->
                        <div class="text-center"> 
                            <?php
                            $total_records = $totalCountResult;
                            $total_pages = ceil($total_records / $limit);
                            $perpage = 10 * $offset;                            
                            $perpage = ($perpage > $total_pages) ? $total_pages : 10 * $offset;
                            $startpage = $perpage - 9;
                            $startpage = ($startpage <= 0) ? 1 : $startpage = $perpage - 9;
                            
                            ?>
                            <ul class="pagination pagination-lg" >
                                <?php
                                if ($startpage <= 10) {

                                    echo"<li class=\"disable\"> </li>";
                                } else {
                                    echo"<li> <a href='?" . $urls . "&page=" . ($perpage - 10) . "&limit=" . $limit . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "    '> &laquo;</a></li>";
                                }
                                ?>

                                <?php
                                //echo"start page"=;
                                //$total_pages
                                for ($startpage; $startpage <= $perpage; $startpage++) {

                                    echo"<li ";
                                    if ($page == $startpage) {
                                        echo'class="active"';
                                    }

                                    echo"><a href='?" . $urls . "&page=" . $startpage . "&limit=" . $limit . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "    '>" . $startpage . "</a></li>";
                                };

                                if ($perpage >= $total_pages) {

                                    echo"<li class=\"disable\"> </li>";
                                } else {

                                    echo"<li> <a href='?" . $urls . "&page=" . ($perpage + 1) . "&limit=" . $limit . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "    '> &raquo;</a></li>";
                                }
                                ?>


                            </ul><br>
                        </div> <!--end paging -->
                    </div>
                    <?php
                    $url = Yii::$app->request->url;
                    $rawurl = substr($url, 33);
                    ?>

                    <div class="col-sm-3">
                        <span style="margin-bottom:13px"><strong>Lebih Spesifik :</strong></span>
                        <div class="list-group facet" id="side-panel-authorStr">
                            <div class="list-group-item title" >
                                <a data-toggle="collapse"  href="#side-collapse-authorStr">Pengarang </a> 
                                <?php
                                if ($fAuthor != '')
                                    echo"
                                        <span style=\"background-color:#c5d4ff;\" class=\"badge\">
                                            <a href='pencarian-lanjut?" . $urls . "&fAuthor=&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>Clear </a>
                                        </span>					
                                        ";
                                ?>

                            </div>
                            <div id="side-collapse-authorStr" class="collapse in">

                                <?php
                                $divHiddenBuka='<div class="facedHidden" >';
                                $divHiddenTutup=(sizeof($dataFacedAuthor)>$FacedAuthorMin ? '</div>' : '');
                                for ($i = 0; $i < sizeof($dataFacedAuthor); $i++) {
                                    if ($dataFacedAuthor[$i]['Author'] == NULL || $dataFacedAuthor[$i]['Author'] == '')
                                        $dataFacedAuthor[$i]['Author'] = '-';
                                      if($i==$FacedAuthorMin){echo$divHiddenBuka;}
                                    echo"
					
                    					<a style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item \" href='pencarian-lanjut?" . $urls . "&fAuthor=" . $dataFacedAuthor[$i]['Author'] . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>" . $dataFacedAuthor[$i]['Author'] . "<span class=\"badge\">" . $dataFacedAuthor[$i]['jml'] . "</span></a>
                    					
                    			    ";
                                    }


                                  echo$divHiddenTutup;
                                  if(sizeof($dataFacedAuthor)>$FacedAuthorMin){
                                    echo"<a  href=\"#\" style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item faced\"  >Show More</a>";
                                    }
                                ?>

                            </div>

                        </div>
                        <div class="list-group facet" id="side-panel-publisherStr">
                            <div class="list-group-item title" >
                                <a data-toggle="collapse"  href="#side-collapse-publisherStr">Penerbit </a> 
                                <?php
                                if ($fPublisher != '')
                                    echo"
                                        <span style=\"background-color:#c5d4ff;\" class=\"badge\">
                                           <a href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>Clear </a>
                                        </span>					
					";
                                ?>

                            </div>
                            <div id="side-collapse-publisherStr" class="collapse in">

                                <?php
                                $divHiddenBuka='<div class="facedHidden" >';
                                $divHiddenTutup=(sizeof($dataFacedPublisher)>$FacedPublisherMin ? '</div>' : '');
                                for ($i = 0; $i < sizeof($dataFacedPublisher); $i++) {
                                    if ($dataFacedPublisher[$i]['Publisher'] == NULL || $dataFacedPublisher[$i]['Publisher'] == '')
                                        $dataFacedPublisher[$i]['Publisher'] = '-';
                                    if($i==$FacedPublisherMin){echo$divHiddenBuka;}
                                    echo"						
                					<a style=\"padding: 8px 40px 8px 8px;\"class=\"list-group-item \"href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $dataFacedPublisher[$i]['Publisher'] . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>" . $dataFacedPublisher[$i]['Publisher'] . "<span class=\"badge\">" . $dataFacedPublisher[$i]['jml'] . "</span></a>
                						
                					";
                                    }


                                    echo$divHiddenTutup;
                                    if(sizeof($dataFacedPublisher)>$FacedPublisherMin){
                                        echo"<a  href=\"#\" style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item faced\"  >Show More</a>";
                                        }
                                ?>

                            </div>

                        </div> 

                        <div class="list-group facet" id="side-panel-publislocationStr">
                            <div class="list-group-item title" >
                                <a data-toggle="collapse"  href="#side-collapse-publislocationStr">Lokasi Terbitan </a> 
                                <?php
                                if ($fPublishLoc != '')
                                    echo"
                                        <span style=\"background-color:#c5d4ff;\" class=\"badge\">
                                            <a href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>Clear </a>
                                        </span>					
                                        ";
                                ?>

                            </div>
                            <div id="side-collapse-publislocationStr" class="collapse in">

                                <?php
                                $divHiddenBuka='<div class="facedHidden" >';
                                $divHiddenTutup=(sizeof($dataFacedPublishLocation)>$FacedPublishLocationMin ? '</div>' : '');
                                for ($i = 0; $i < sizeof($dataFacedPublishLocation); $i++) {
                                    if ($dataFacedPublishLocation[$i]['PublishLocation'] == NULL || $dataFacedPublishLocation[$i]['PublishLocation'] == '')
                                        $dataFacedPublishLocation[$i]['PublishLocation'] = '-';
                                    if($i==$FacedPublishLocationMin){echo$divHiddenBuka;}

                                    echo"
					
                                        <a style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item \" href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $dataFacedPublishLocation[$i]['PublishLocation'] . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $fSubject . "     '>" . $dataFacedPublishLocation[$i]['PublishLocation'] . "<span class=\"badge\">" . $dataFacedPublishLocation[$i]['jml'] . "</span></a>
					
                                        ";
                                }
                                echo$divHiddenTutup;
                                if(sizeof($dataFacedPublishLocation)>$FacedPublishLocationMin){
                                    echo"<a  href=\"#\" style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item faced\"  >Show More</a>";
                                }
                                ?>

                            </div>

                        </div>
                        <div class="list-group facet" id="side-panel-publisyearStr">
                            <div class="list-group-item title" >
                                <a data-toggle="collapse"  href="#side-collapse-publisyearStr">Tahun Terbit </a> 
                                <?php
                                if ($fPublishYear != '')
                                    echo"
                                        <span style=\"background-color:#c5d4ff;\" class=\"badge\">
                                            <a href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=&fSubject=" . $fSubject . "     '>Clear </a>
                                        </span>					
                                        ";
                                ?>

                            </div>
                            <div id="side-collapse-publisyearStr" class="collapse in">

                                <?php
                                $divHiddenBuka='<div class="facedHidden" >';
                                $divHiddenTutup=(sizeof($dataFacedPublishYear)>$FacedPublishYearMin ? '</div>' : '');
                                for ($i = 0; $i < sizeof($dataFacedPublishYear); $i++) {
                                    if ($dataFacedPublishYear[$i]['PublishYear'] == NULL || $dataFacedPublishYear[$i]['PublishYear'] == '')
                                        $dataFacedPublishYear[$i]['PublishYear'] = '-';
                                if($i==$FacedPublishYearMin){echo$divHiddenBuka;}
                                    echo"
					
                                        <a style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item \" href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $dataFacedPublishYear[$i]['PublishYear'] . "&fSubject=" . $fSubject . "     '>" . $dataFacedPublishYear[$i]['PublishYear'] . "<span class=\"badge\">" . $dataFacedPublishYear[$i]['jml'] . "</span></a>
					
                                        ";
                                }
                                echo$divHiddenTutup;
                                if(sizeof($dataFacedPublishYear)>$FacedPublishYearMin){
                                    echo"<a  href=\"#\" style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item faced\"  >Show More</a>";
                                }
                                ?>

                            </div>

                        </div>
                        <div class="list-group facet" id="side-panel-subjectStr">
                            <div class="list-group-item title" >
                                <a data-toggle="collapse"  href="#side-collapse-subjectStr">Subyek </a> 
                                <?php
                                if ($fSubject != '')
                                    echo"
                                        <span style=\"background-color:#c5d4ff;\" class=\"badge\">
                                            <a href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=     '>Clear </a>
                                        </span>					
                                        ";
                                ?>

                            </div>
                            <div id="side-collapse-subjectStr" class="collapse in">

                                <?php
                                $divHiddenBuka='<div class="facedHidden" >';
                                $divHiddenTutup=(sizeof($dataFacedSubject)>$FacedSubjectMin ? '</div>' : '');
                                for ($i = 0; $i < sizeof($dataFacedSubject); $i++) {
                                    if ($dataFacedSubject[$i]['Subject'] == NULL || $dataFacedSubject[$i]['Subject'] == '')
                                        $dataFacedSubject[$i]['Subject'] = '-';
                                if($i==$FacedSubjectMin){echo$divHiddenBuka;}
                                    echo"
					
                                        <a style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item \" href='pencarian-lanjut?" . $urls . "&fAuthor=" . $fAuthor . "&fPublisher=" . $fPublisher . "&fPublishLoc=" . $fPublishLoc . "&fPublishYear=" . $fPublishYear . "&fSubject=" . $dataFacedSubject[$i]['Subject'] . "     '>" . $dataFacedSubject[$i]['Subject'] . "<span class=\"badge\">" . $dataFacedSubject[$i]['jml'] . "</span></a>
					
                                        ";
                                }
                                echo$divHiddenTutup;
                                if(sizeof($dataFacedSubject)>$FacedSubjectMin){
                                    echo"<a  href=\"#\" style=\"padding: 8px 40px 8px 8px;\" class=\"list-group-item faced\"  >Show More</a>";
                                }
                                ?>

                            </div>

                        </div>                                 
                        
                        <?php
                        $this->registerJS('
                        $(\'.facedHidden\').hide();

                        // Make sure all the elements with a class of "clickme" are visible and bound
                        // with a click event to toggle the "box" state
                        $(\'.faced\').each(function() {
                            $(this).show(0).on(\'click\', function(e) {
                                // This is only needed if your using an anchor to target the "box" elements
                                e.preventDefault();
                                
                                // Find the next "box" element in the DOM
                                $(this).prev(\'.facedHidden\').slideToggle(\'fast\');
                                if ( $(this).text() == "Show More") {
                                $(this).text("Show Less")

                                } else
                                {
                                $(this).text("Show More");
                                }   
                            });
                        });
        

                            $(document).ready(function(){

                                    $(".toggler1").click(function(e){
                                            e.preventDefault();
                                            $(\'.auth\'+$(this).attr(\'facedAuthor\')).toggle();
                                    });
                                    $(".toggler2").click(function(e){
                                            e.preventDefault();
                                            $(\'.pub\'+$(this).attr(\'facedPublisher\')).toggle();
                                    });
                                    $(".toggler3").click(function(e){
                                            e.preventDefault();
                                            $(\'.publoc\'+$(this).attr(\'facedPublishLocation\')).toggle();
                                    });
                                    $(".toggler4").click(function(e){
                                            e.preventDefault();
                                            $(\'.pubyear\'+$(this).attr(\'facedPublishYear\')).toggle();
                                    });


                            });
					');
                        ?>                                                               
                    </div>
                </div>
<?php } ?>
        </div>
    </div>
    <div class="row">&nbsp;</div>                    
</section><!-- /.content -->