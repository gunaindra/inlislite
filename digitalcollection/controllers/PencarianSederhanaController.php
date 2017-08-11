<?php

namespace digitalcollection\controllers;

use Yii;
use common\models\Opaclogs;
use common\models\OpaclogsKeyword;
use common\models\Worksheets;
use common\models\Bookinglogs;
use common\models\Favorite;
use common\models\Collections;
use common\models\Catalogs;
use common\models\Requestcatalog;
use common\models\CollectionSearchKardeks;
use common\models\Members;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\web\Session;
use yii\web\Request;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use common\components\OpacHelpers;
$session = Yii::$app->session;
$session->open();

class PencarianSederhanaController extends \yii\web\Controller {


    public function actionIndex() {
        $jmlBookMaks = Yii::$app->config->get('JumlahBookingMaksimal');
        $bookExp = Yii::$app->config->get('BookingExpired');
        $UsulanKoleksi = Yii::$app->config->get('UsulanKoleksi');
        $dateNow = new \DateTime("now");
        $noAnggota= (Yii::$app->user->isGuest ? null : \Yii::$app->user->identity->NoAnggota );
        $booking = OpacHelpers::jumlahBooking($noAnggota);

        $alert = false;
        $session = Yii::$app->session;
        $datas = $session->get('catIDmerge');
        $request = Yii::$app->request;
        $connection = Yii::$app->db;
        $url = Yii::$app->request->absoluteUrl;
        $waktu = date('m-d-Y H:i:s');
       

        $request = Yii::$app->request;
        if ($request->isAjax && $_GET['action'] === "favourite") {
            if (Yii::$app->user->isGuest) {
                return $this->redirect('../keanggotaan/site/login');
            }
            $model = new favorite;
            (int) $count = favorite::find()
                    ->where(['Member_Id' => \Yii::$app->user->identity->NoAnggota, 'Catalog_Id' => addslashes($_GET['catID'])])
                    ->count();


            if ($count == 0) {
                $model->Member_Id = \Yii::$app->user->identity->NoAnggota;
                $model->Catalog_Id = addslashes($_GET['catID']);
                //$model->CreateDate = new Expression('NOW()');
                $model->save();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 2500,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => Yii::t('app', '  Telah Di Simpan ke-dalam daftar Favorite'),
                    'title' => 'success',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
            } else {
                Yii::$app->getSession()->setFlash('error', [
                    'type' => 'danger',
                    'delay' => 2500,
                    'icon' => 'glyphicon glyphicon-remove',
                    'message' => Yii::t('app', ' Katalog ini sudah ada di dalam daftar Favorite anda'),
                    'title' => 'Gagal',
                    'body' => 'This is a successful growling alert.',
                    'positonY' => Yii::$app->params['flashMessagePositionY'],
                    'positonX' => Yii::$app->params['flashMessagePositionX']
                ]);
            }



            return $this->renderAjax('_favorite', [
                        'catID' => addslashes($_GET['catID']),
            ]);
        }
        if ($request->isAjax && $_GET['action'] === "requestCatalog") {
            $model = new requestcatalog;
            $model->MemberID = 1;
            $model->WorksheetID = 1;
            $model->Title = 1;
            $model->Author = 1;
            $model->PublishLocation = 1;
            $model->PublishYear = 1;
            $model->Comments = 1;
            $model->save();
        }

        if (Yii::$app->request->get() && $_GET['action'] === "pencarianSederhana") {              
            $bahan = addslashes($_GET['bahan']);
            $bahan1 = $bahan;

   
            $Keyword = urldecode($_GET['katakunci']);
            $ruas = addslashes($_GET['ruas']);
            $dariTGL = ( isset($_GET['dariTGL']) ) ? addslashes($_GET['dariTGL']) : '';
            $sampaiTGL = ( isset($_GET['sampaiTGL']) ) ? addslashes($_GET['sampaiTGL']) : '';
            $ip = OpacHelpers::getIP();
            if (isset($_SESSION['RiwayatPencarian'])) {
                $temp = $_SESSION['RiwayatPencarian'];
                $_SESSION['RiwayatPencarian'] = array_merge($temp, array(
                    array(
                        "ip" =>  $ip,
                        "url" => $url,
                        "action" => addslashes($_GET['action']),
                        "keyword" => $ruas . " = " . $Keyword,
                        //"ruas" => $ruas,
                        "bahan" => $bahan,
                        "time" => $waktu,
                    )
                ));
            } else {
                $temp = array(
                    array(
                        "ip" =>  $ip,
                        "url" => $url,
                        "action" => addslashes($_GET['action']),
                        "keyword" => $ruas . " = " . $Keyword,
                        //"ruas" => $ruas,
                        "bahan" => $bahan,
                        "time" => $waktu,
                    )
                );
                $_SESSION['RiwayatPencarian'] = $temp;
            }



            $logs=[

                'user_id' => $noAnggota,
                'ip'      => $ip,
                'jenis_pencarian' => addslashes($_GET['action']),
                'keyword' => $ruas . " = " . $Keyword,
                'jenis_bahan' => $bahan,
                'url' => $url,
                'isLKD' => 0,
                'Field' => $ruas,
            ];
            OpacHelpers::opacLogs($logs);

            $page = ( isset($_GET['page']) ) ? addslashes($_GET['page']) : 1;
            $limit = ( isset($_GET['limit']) ) ? addslashes($_GET['limit']) : 10;
            $fAuthor = ( isset($_GET['fAuthor']) ) ? addslashes(urldecode($_GET['fAuthor'])) : '';
            $fPublisher = ( isset($_GET['fPublisher']) ) ? addslashes(urldecode($_GET['fPublisher'])) : '';
            $fPublishLoc = ( isset($_GET['fPublishLoc']) ) ? addslashes(urldecode($_GET['fPublishLoc'])) : '';
            $fPublishYear = ( isset($_GET['fPublishYear']) ) ? addslashes(urldecode($_GET['fPublishYear'])) : '';
            $fSubject = ( isset($_GET['fSubject']) ) ? addslashes(urldecode($_GET['fSubject'])) : '';

            $limitAwal = ($page - 1) * $limit;



            $Keyword = "%" . $Keyword . "%";
            $params = [':keyword' => $Keyword, ':ruas' => $ruas, ':bahan1' => $bahan1, ':fAuthor' => $fAuthor, ':fPublisher' => $fPublisher, ':fPublishLoc' => $fPublishLoc, ':fPublishYear' => $fPublishYear, ':fSubject' => $fSubject, ':dariTGL' => $dariTGL, ':sampaiTGL' => $sampaiTGL ];
            $params2 = [':keyword' => $Keyword, ':ruas' => $ruas, ':bahan1' => $bahan1, ':fAuthor' => $fAuthor, ':fPublisher' => $fPublisher, ':fPublishLoc' => $fPublishLoc, ':fPublishYear' => $fPublishYear, ':fSubject' => $fSubject, ':dariTGL' => $dariTGL, ':sampaiTGL' => $sampaiTGL, ':limitAwal' => $limitAwal, ':limit' => $limit ];
            
            //biar kalo pagging ga panggil insertTempOpacSederhana langsung nyari ke temporari
            if (!isset($_GET['page']) || (!isset($_SESSION['countSearch']))) {
                $command = Yii::$app->db->createCommand("CALL insertTempSederhanaOpac(:keyword,:ruas,:bahan1,:fAuthor,:fPublisher,:fPublishLoc,:fPublishYear,:fSubject,:dariTGL,:sampaiTGL,'1' );");
                 $command->bindValues($params);
                $command->execute();                
            } else {
                $command = Yii::$app->db->createCommand("CALL insertTempSederhanaOpac0(:keyword,:ruas,:bahan1,:limitAwal,:limit,:fAuthor,:fPublisher,:fPublishLoc,:fPublishYear,:fSubject,:dariTGL,:sampaiTGL,'1' );");
                 $command->bindValues($params2);
                $command->execute();
            }

            $count = Yii::$app->db->createCommand("CALL countPencarianSederhanaOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "');")->queryScalar();

            $sqlSearch = "CALL pencarianSederhanaOpacLimit1('0','" . $limit . "','" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "');";
            $dataProviderSearch = new SqlDataProvider([
                'sql' => $sqlSearch,
                'pagination' => false,
            ]);

            $modelSearch = $dataProviderSearch->getModels();
            $countSearch = $dataProviderSearch->getCount();


            $FacedAuthorMax = Yii::$app->config->get('FacedAuthorMaxLKD');
            $FacedPublisherMax = Yii::$app->config->get('FacedPublisherMaxLKD');
            $FacedPublishLocationMax = Yii::$app->config->get('FacedPublishLocationMaxLKD');
            $FacedPublishYearMax = Yii::$app->config->get('FacedPublishYearMaxLKD');
            $FacedSubjectMax = Yii::$app->config->get('FacedSubjectMaxLKD');


            $dataFacedAuthor = Yii::$app->db->createCommand("CALL facedAuthorOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedAuthorMax . "');")->queryAll();
            $dataFacedPublisher = Yii::$app->db->createCommand("CALL facedPublisherOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublisherMax . "');")->queryAll();
            $dataFacedPublishLocation = Yii::$app->db->createCommand("CALL facedPublishLocationOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublishLocationMax . "');")->queryAll();
            $dataFacedPublishYear = Yii::$app->db->createCommand("CALL facedPublishYearOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublishYearMax . "');")->queryAll();
            $dataFacedSubject = Yii::$app->db->createCommand("CALL facedSubjectOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedSubjectMax . "');")->queryAll();
            //$totalCountSearch=$dataProviderSearch->getTotalCount();

            if (!isset($_GET['page']) || (!isset($_SESSION['countSearch']))) {
                $_SESSION['dataFacedAuthor'] = $dataFacedAuthor;
                $_SESSION['dataFacedPublisher'] = $dataFacedPublisher;
                $_SESSION['dataFacedPublishLocation'] = $dataFacedPublishLocation;
                $_SESSION['dataFacedPublishYear'] = $dataFacedPublishYear;
                $_SESSION['dataFacedSubject'] = $dataFacedSubject;
            } else {

                $dataFacedAuthor = $_SESSION['dataFacedAuthor'];
                $dataFacedPublisher = $_SESSION['dataFacedPublisher'];
                $dataFacedPublishLocation = $_SESSION['dataFacedPublishLocation'];
                $dataFacedPublishYear = $_SESSION['dataFacedPublishYear'];
                $dataFacedSubject = $_SESSION['dataFacedSubject'];
            }

            //buat nyimpen total record yg dicari setiap pencarian
            //#temporary table problems fixed

            if (!isset($_GET['page']) || (!isset($_SESSION['countSearch']))) {
                $_SESSION['countSearch'] = $count;
            } else {

                $count = $_SESSION['countSearch'];
            }

            $temp = 1;
            foreach ($modelSearch as $value) {
                $dataSearch[$temp] = $value;
                $temp++;
            }
            //buat nyimpen session keranjang
            if (!isset($_SESSION['catID']) || $_SESSION['catID'] == '') {
                $_SESSION['catID'] = NULL;
            };
            if (!isset($_SESSION['catIDmerge']) || $_SESSION['catIDmerge'] == '') {
                $_SESSION['catIDmerge'] = NULL;
            };
            if (!isset($_POST['catID']) || $_POST['catID'] == '') {
                $_POST['catID'] = NULL;
            };
            if (!isset($_SESSION['catID']) || $_SESSION['catID'] == '') {
                $_SESSION['catID'] = NULL;
            };
            if (!isset($_SESSION['catIDmerge']) || $_SESSION['catIDmerge'] == '') {
                $_SESSION['catIDmerge'] = NULL;
            };
            if (!isset($_POST['catID']) || $_POST['catID'] == '') {
                $_POST['catID'] = NULL;
            };

            if (isset($_POST['action']) && $_POST['action'] == "keranjang" && isset($_POST['catID'])) {
                if (isset($_SESSION['catID'])) {

                    $temp = (is_array($_SESSION['catID']) ? $_SESSION['catID'] : array($_SESSION['catID']));
                    $duplicated = 0;
                    for ($i = 0; $i < sizeof($_POST['catID']); $i++) {
                        if (in_array($_POST['catID'][$i], $temp)) {
                            $duplicated+=1;
                        }
                    }
                    //menggabungkan catID di session dengan catID dari post//
                    $_SESSION['catID'] = array_unique(array_merge($temp, $_POST['catID']));

                    //pesan  ketika semua catalogID gagal dimasukkan ke keranjang
                    if (sizeof($_POST['catID']) == $duplicated) {
                        Yii::$app->getSession()->setFlash('error', [
                            'type' => 'danger',
                            'duration' => 3500,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app', ' Katalog Gagal disimpan, Katalog sudah ada di dalam keranjang'),
                            'title' => 'Error',
                            'positonY' => Yii::$app->params['flashMessagePositionY'],
                            'positonX' => Yii::$app->params['flashMessagePositionX']
                        ]);
                        $alert = TRUE;
                    } else
                    //pesan  ketika sebagian catalogID gagal dimasukkan ke keranjang
                    if ($duplicated != 0) {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'info',
                            'duration' => 2500,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app', (sizeof($_POST['catID']) - $duplicated) . ' Katalog berhasil disimpan di dalam keranjang ' . $duplicated . ' Katalog gagal disimpan'),
                            'title' => 'success',
                            'positonY' => Yii::$app->params['flashMessagePositionY'],
                            'positonX' => Yii::$app->params['flashMessagePositionX']
                        ]);
                        $alert = TRUE;
                    }
                    //pesan ketika semua catalogID berhasil di masukkan ke keranjang
                    else {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'info',
                            'duration' => 2500,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app', sizeof($_POST['catID']) . ' Katalog berhasil disimpan di dalam keranjang'),
                            'title' => 'success',
                            'positonY' => Yii::$app->params['flashMessagePositionY'],
                            'positonX' => Yii::$app->params['flashMessagePositionX']
                        ]);
                        $alert = TRUE;
                    }
                } else {
                    $_SESSION['catID'] = $_POST['catID'];
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'info',
                        'duration' => 2500,
                        'icon' => 'glyphicon glyphicon-ok-sign',
                        'message' => Yii::t('app', sizeof($_POST['catID']) . ' Katalog berhasil disimpan di dalam keranjang'),
                        'title' => 'success',
                        'positonY' => Yii::$app->params['flashMessagePositionY'],
                        'positonX' => Yii::$app->params['flashMessagePositionX']
                    ]);
                    $alert = TRUE;
                }
                $gabung = implode(",", $_SESSION['catID']);
                $_SESSION['catIDmerge'] = $gabung;
            }


            if (!isset($dataSearch)) {
                $dataSearch = "";
            }
            return $this->render('resultListOpac', [

                        'dataProviderResult' => $dataProviderSearch,
                        'countResult' => $countSearch,
                        'dataResult' => $dataSearch,
                        'totalCountResult' => $count,
                        'dataFacedAuthor' => $dataFacedAuthor,
                        'dataFacedPublisher' => $dataFacedPublisher,
                        'dataFacedPublishYear' => $dataFacedPublishYear,
                        'dataFacedPublishLocation' => $dataFacedPublishLocation,
                        'dataFacedSubject' => $dataFacedSubject,
                        'noAnggota' => $noAnggota,
                        'alert' => $alert,
                        'UsulanKoleksi' => $UsulanKoleksi,
                        'booking' => $booking,
            ]);
        }
        
        if (!isset($_SESSION['catID']) || $_SESSION['catID'] == '') {
            $_SESSION['catID'] = NULL;
        };
        if (!isset($_SESSION['catIDmerge']) || $_SESSION['catIDmerge'] == '') {
            $_SESSION['catIDmerge'] = NULL;
        };
        if (!isset($_POST['catID']) || $_POST['catID'] == '') {
            $_POST['catID'] = NULL;
        };

        if (isset($_POST['catID'])) {
            if (isset($_SESSION['catID'])) {
                $temp = $_SESSION['catID'];
                //menggabungkan catID di session dengan catID dari post//
                $_SESSION['catID'] = array_unique(array_merge($temp, $_POST['catID']));
            } else {
                $_SESSION['catID'] = $_POST['catID'];
            }

            $gabung = implode(",", $_SESSION['catID']);
            $_SESSION['catIDmerge'] = $gabung;
        }
        
        if ($request->isAjax && $_GET['action'] === "showCollection") {


            if ($_GET['serial'] == 'true') {
                $searchModel = new CollectionSearchKardeks;
                $params['CatalogId'] = $_GET['catID'];
                $dataProvider = $searchModel->search2($params);
                return $this->renderAjax('_serial', [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                ]);
            }

            $catID = $_GET['catID'];
            $sqlCollectionList = "CALL showCollectionOpac(" . $catID . ");";

            $dataProviderCollectionList = new SqlDataProvider([
                'sql' => $sqlCollectionList,
                'pagination' => false,
                    //'pagination' => [ 'pageSize' => 20,],
            ]);

            $modelCollectionList = $dataProviderCollectionList->getModels();
            $countCollectionList = $dataProviderCollectionList->getCount();
            $temp = 1;
            foreach ($modelCollectionList as $value) {
                $dataCollectionList[$temp] = $value;
                $temp++;
            }
            if (!isset($dataCollectionList)) {
                $dataCollectionList = "";
            }


            return $this->renderAjax('_collectionlist', [

                        'dataProviderCollectionList' => $dataProviderCollectionList,
                        'countCollectionList' => $countCollectionList,
                        'dataCollectionList' => $dataCollectionList,
                        'noAnggota' => $noAnggota,
                        'catID' => $catID
            ]);
        }
        if ($request->isAjax && $_GET['action'] === "logDownload") {
            OpacHelpers::logsDownload($_GET['ID'],$noAnggota,'1');          
        }

        if ($request->isAjax && $_GET['action'] === "showKontenDigital") {
            $catID = $_GET['catID'];
            $sqlCollectionList = "CALL showKontenDigital(" . $catID . "); ";

            $dataProviderCollectionList = new SqlDataProvider([
                'sql' => $sqlCollectionList,
                //'pagination'=> false,
                'pagination' => [ 'pageSize' => 1,],
            ]);

            $modelCollectionList = $dataProviderCollectionList->getModels();
            $countCollectionList = $dataProviderCollectionList->getCount();
            $temp = 1;
            foreach ($modelCollectionList as $value) {
                $dataCollectionList[$temp] = $value;
                $temp++;
            }
            if (!isset($dataCollectionList)) {
                $dataCollectionList = "";
            }

            return $this->renderAjax('_kontendigitallist', [

                        'dataProviderCollectionList' => $dataProviderCollectionList,
                        'countCollectionList' => $countCollectionList,
                        'dataCollectionList' => $dataCollectionList,
                        'noAnggota' => $noAnggota,
                        'catID' => $catID,
            ]);
        }
        if ($request->isAjax && $_GET['action'] === "boooking") {

            if (Yii::$app->user->isGuest) {
                return $this->redirect('../keanggotaan/site/login');
            }
            $colID = $_GET['colID'];
            $cekBooking = OpacHelpers::cekBooking($noAnggota,$colID);       
            $noAnggota = \Yii::$app->user->identity->NoAnggota;
            $dateNow = new \DateTime("now");
            $dateAdd = new \DateTime("now");
            $bookingTime=OpacHelpers::SetBookingTime($bookExp);
            /*$tambahJam= explode(":",$bookExp);


            $dateAdd->modify("+".$tambahJam[0]." hours +".$tambahJam[1]." minutes +".$tambahJam[2]." seconds");*/

            if (!$cekBooking) {
                
                    $modelLogs = new Bookinglogs;
                    $modelLogs->memberId = $noAnggota;
                    $modelLogs->collectionId = $colID;
                    $modelLogs->bookingDate = $dateNow->format("Y-m-d H:i:sO");
                    $modelLogs->bookingExpired = $bookingTime->format("Y-m-d H:i:sO");
                    $modelLogs->save();
                    
                    $params2 = [':ID' => $colID, ':BookingMemberID' => $noAnggota, ':BookingExpiredDate' => $bookingTime->format("Y-m-d H:i:sO")];
                    $command = Yii::$app->db->createCommand("UPDATE collections SET BookingMemberID=:BookingMemberID, BookingExpiredDate=:BookingExpiredDate WHERE ID=:ID;");
                    $command->bindValues($params2);
                    $command->execute();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'info',
                        'duration' => 2500,
                        'icon' => 'glyphicon glyphicon-ok-sign',
                        'message' => Yii::t('app', 'Berhasil Booking'),
                        'title' => 'success',
                        'positonY' => Yii::$app->params['flashMessagePositionY'],
                        'positonX' => Yii::$app->params['flashMessagePositionX']
                    ]);
            } else {
                $pesan=implode(",", $cekBooking);
                    Yii::$app->getSession()->setFlash('error', [
                    'type' => 'danger',
                    'delay' => 3500,
                    'icon' => 'glyphicon glyphicon-remove',
                    'message' => Yii::t('app', '  Gagal Booking, '.$pesan),
                    'title' => 'Gagal',
                    'body' => 'This is a successful growling alert.',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
                
            }

            
            return $this->renderAjax('alert', [
                        'booking' => $booking,

            ]);
        }
        if ($request->isAjax && $_GET['action'] === "search") {
            $catID = $_GET['catID'];
            $pos  = $_GET['pos'];
            $sqlSearch = "
                SELECT CAT.id CatalogId,CAT.title kalimat2,CAT.author,CAT.publisher,CAT.PublishLocation,CAT.PublishYear,CAT.subject,CAT.CoverURL ,CAT.Worksheet_id, 
                (SELECT NAME FROM worksheets WHERE id=CAT.Worksheet_id) worksheet,
                (SELECT COUNT(1) FROM collections WHERE CATALOG_ID=CAT.ID AND STATUS_ID=1 AND (BookingExpiredDate < now() || BookingExpiredDate is null)) JML_BUKU,
                (SELECT COUNT(1) FROM collections WHERE CATALOG_ID=CAT.ID) ALL_BUKU,
                (SELECT GROUP_CONCAT(DISTINCT SUBSTR(fileURL,INSTR(fileURL, '.')+1) SEPARATOR ', ') 
                FROM catalogfiles WHERE Catalog_id = CAT.ID) KONTEN_DIGITAL
                
                FROM catalogs CAT JOIN collections col ON col.Catalog_id = CAT.ID
                 WHERE 
                   CAT.isopac=1 AND
                    CAT.ID=" . $catID . ";


                ";
            
            $dataProviderSearch = new SqlDataProvider([
                'sql' => $sqlSearch,
                'pagination' => false,
            ]);

            $modelSearch = $dataProviderSearch->getModels();
            $countSearch = $dataProviderSearch->getCount();

            $temp = 1;
            foreach ($modelSearch as $value) {
                $dataSearch[$temp] = $value;
                $temp++;
            }

            $dateNow = new \DateTime("now");

            return $this->renderAjax('_search', [
                        'dataResult' => $dataSearch,
                        'booking' => $booking,
                        'i' => $pos,
            ]);
        }

        return $this->render('index');
    }

    public function actionUsulan() {
        if (Yii::$app->user->isGuest) {
            $noAnggota = $_POST['formData']['NomorAnggota'];
        } else {
            $noAnggota = \Yii::$app->user->identity->NoAnggota;
        }


        $model = new requestcatalog;
        //$model->MemberID = $noAnggota;
        //$model->WorksheetID = 1;
        $model->WorksheetID = $_POST['formData']['JenisBahan'];
        $model->Title = $_POST['formData']['Judul'];
        $model->Author = $_POST['formData']['Pengarang'];
        $model->PublishLocation = $_POST['formData']['KotaTerbit'];
        $model->Publisher = $_POST['formData']['Penerbit'];
        $model->PublishYear = $_POST['formData']['TahunTerbit'];
        $model->Comments = $_POST['formData']['Keterangan'];
        $model->save(false);


        Yii::$app->getSession()->setFlash('success', [
            'type' => 'info',
            'delay' => 2500,
            'icon' => 'glyphicon glyphicon-remove',
            'message' => Yii::t('app', '  Data Berhasil Disimpan '),
            'title' => 'Sukses',
            'body' => 'This is a successful growling alert.',
            'positonY' => Yii::$app->params['flashMessagePositionY'],
            'positonX' => Yii::$app->params['flashMessagePositionX']
        ]);
        return $this->renderAjax('_usulan', [
                        
        ]);
    }

}
