<?php

namespace opac\controllers;

use Yii;
use common\models\Opaclogs;
use common\models\Bookinglogs;
use common\models\Favorite;
use common\models\Collections;
use common\models\Catalogs;
use common\models\Requestcatalog;
use common\models\CollectionSearchKardeks;
use common\models\Worksheets;
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
use common\components\OpacHelpers;
use common\models\OpaclogsKeyword;
use common\models\Refferenceitems;
$session = Yii::$app->session;
$session->open();

class PencarianLanjutController extends \yii\web\Controller {



    function convertTag($tag,$bahasa) {
        
        if ($bahasa) { 
            switch ($tag) {
                case 'Sembarang Ruas':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.Value";
                    break;
                case 'Judul':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('245','246','440','740','240','246','008') and R.Value";
                    break;
                case 'Pengarang':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('100','110','111','700','710','711',800','810','811','008') and R.Value";
                    break;
                case 'Penerbitan':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('260','264','008') and R.Value";
                    break;
                case 'Edisi':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('250','008') and R.Value";
                    break;
                case 'Deskripsi Fisik':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('300','008') and R.Value";
                    break;
                case 'Jenis Konten':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('336','008') and R.Value";
                    break;
                case 'Jenis Media':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('337','008') and R.Value";
                    break;  
                case 'Media Carrier':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('338','008') and R.Value";
                    break;
                case 'Subyek':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('600','610','611','650','651','008') and R.Value";
                    break;
                case 'ISBN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('020','008') and R.Value";
                    break;
                case 'ISSN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('022','008') and R.Value";
                    break;
                case 'ISMN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('024','008') and R.Value";
                    break;
                case 'Nomor Panggil':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('084','090','008') and R.Value";
                    break;               
                default:
                    # code...
                    break;
            }   
        } else {
            switch ($tag) {
                case 'Sembarang Ruas':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.Value";
                    break;
                case 'Judul':
                    $tag = " EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('245','246','440','740','240','246') and R.Value";
                    break;
                case 'Pengarang':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('100','110','111','700','710','711','800','810','811') and R.Value";
                    break;
                case 'Penerbitan':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('260','264') and R.Value";
                    break;
                case 'Edisi':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('250') and R.Value";
                    break;
                case 'Deskripsi Fisik':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('300') and R.Value";
                    break;
                case 'Jenis Konten':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE  R.CATALOGID=CAT.ID and R.TAG IN ('336') and R.Value";
                    break;
                case 'Jenis Media':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('337') and R.Value";
                    break;  
                case 'Media Carrier':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('338') and R.Value";
                    break;
                case 'Subyek':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('600','610','611','650','651') and R.Value";
                    break;
                case 'ISBN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('020') and R.Value";
                    break;
                case 'ISSN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('022') and R.Value";
                    break;
                case 'ISMN':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('024') and R.Value";
                    break;
                case 'Nomor Panggil':
                    $tag = "EXISTS (SELECT  1 FROM catalog_ruas R  WHERE R.CATALOGID=CAT.ID and R.TAG IN ('084','090') and R.Value";
                    break;               
                default:
                    # code...
                    break;
            }   
        }

        return $tag;
    }

    function tambahKurung($string = NULL, $put = NULL, $put2 = null, $position = false, $position2 = false) {
        $temp = "";
        //echo"isi string kontroller".$string;
        $temp = substr_replace($string, $put, $position, 0);
        $string = substr_replace($temp, $put2, $position2, 0);

        return $string;
    }


    public function actionIndex() {
        $jmlBookMaks = Yii::$app->config->get('JumlahBookingMaksimal');
        $bookExp = Yii::$app->config->get('BookingExpired');
        $isbooking = Yii::$app->config->get('IsBookingActivated');
        $noAnggota= (Yii::$app->user->isGuest ? null : \Yii::$app->user->identity->NoAnggota );
        $booking = OpacHelpers::jumlahBooking($noAnggota);


        $alert = false;
        $request = Yii::$app->request;
        $queryGabungan = "";
        $session = Yii::$app->session;
        $datas = $session->get('catIDmerge');
        $request = Yii::$app->request;
        $connection = Yii::$app->db;
        $url = Yii::$app->request->absoluteUrl;
        $waktu = date('m-d-Y H:i:s');
        $dateNow = new \DateTime("now");


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
                $model->Catalog_Id = $_GET['catID'];
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
                        'catID' => $_GET['catID'],
            ]);
        }

        /////////pencarianLanjut///////
        if (Yii::$app->request->GET() && urldecode($_GET['action']) === "pencarianLanjut") {


             
            $bahan = ( isset($_GET['bahan']) ) ? addslashes(urldecode($_GET['bahan'])) : "";
            $bahasa = ( isset($_GET['bahasa']) ) ? addslashes(urldecode($_GET['bahasa'])) : "";
            $targetPembaca = ( isset($_GET['targetPembaca']) ) ? addslashes(urldecode($_GET['targetPembaca'])) : "";
            $bentukKarya = ( isset($_GET['bentukKarya']) ) ? addslashes(urldecode($_GET['bentukKarya'])) : "";
            $katakunci = ( isset($_GET['katakunci']) ) ? array_map( 'addslashes', $_GET['katakunci']) : "";
            $katakunci2  = $katakunci;
            $jenis = ( isset($_GET['jenis']) ) ?  array_map( 'addslashes', $_GET['jenis']) : "";
            $tag = ( isset($_GET['tag']) ) ? array_map( 'addslashes', $_GET['tag']) : "";
            $danAtau = ( isset($_GET['danAtau']) ) ?  array_map( 'addslashes', $_GET['danAtau']) : "";
            $action = ( isset($_GET['action']) ) ? addslashes(urldecode($_GET['action'])) : "pencarianLanjut";
            $page = ( isset($_GET['page']) ) ? addslashes(urldecode($_GET['page'])) : 1;
            $limit = ( isset($_GET['limit']) ) ? addslashes(urldecode($_GET['limit'])) : 10;
            $fAuthor = ( isset($_GET['fAuthor']) ) ? addslashes(urldecode($_GET['fAuthor'])) : '';
            $fPublisher = ( isset($_GET['fPublisher']) ) ? addslashes(urldecode($_GET['fPublisher'])) : '';
            $fPublishLoc = ( isset($_GET['fPublishLoc']) ) ? addslashes(urldecode($_GET['fPublishLoc'])) : '';
            $fPublishYear = ( isset($_GET['fPublishYear']) ) ? addslashes(urldecode($_GET['fPublishYear'])) : '';
            $fSubject = ( isset($_GET['fSubject']) ) ? addslashes(urldecode($_GET['fSubject'])) : '';


            $bahanIND=$bahan;
            $bahasaIND=$bahasa;
            $targetPembacaIND=$targetPembaca;
            $bentukKaryaIND=$bentukKarya;
            
            if ($bahanIND != 'Semua Jenis Bahan') {
                $tmp = Worksheets::find()
                ->where(['id' => $bahan])
                ->one();
                $bahanIND = $tmp['Name'];  
            }

            $limitAwal = ($page - 1) * $limit;
            $danAtau2 = $danAtau;
            $danAtauIND= $danAtau;

            //urlbuilder
            $urls = "action=" . $action . "&bahan=" . $bahan . "&bahasa=" . $bahasa;
            $his ='';

            for ($i = 0; $i < sizeof($katakunci); $i++) {

                switch ($danAtau[$i]) {
                    case 'and':
                        $danAtauIND[$i]='dan';
                        break;
                    case 'or':
                        $danAtauIND[$i]='atau';
                        break;                    
                }

                if ($i == (sizeof($katakunci) - 1)) {
                    $urls.="&katakunci[]=" . $katakunci[$i] . "&jenis[]=" . $jenis[$i] . "&tag[]=" . $tag[$i];
                    $his.=$tag[$i]." ".$jenis[$i]." = ".$katakunci[$i];                    
                } else {
                    $his.=$tag[$i]." ".$jenis[$i]." = ".$katakunci[$i]." ".$danAtauIND[$i]." ";
                    $urls.="&katakunci[]=" . $katakunci[$i] . "&jenis[]=" . $jenis[$i] . "&tag[]=" . $tag[$i] . "&danAtau[]=" . $danAtau[$i];
                }  
            }        

            $queryGabungan = "";
            $queryRaw = "";
            $queryRaw2 = "";
            $queryRaw3 = "";
            $query = "";
            //perulangan buat query builder advance search
            if (sizeof($tag) > 1) {
                for ($i = 0; $i < sizeof($tag); $i++) {//logic buat perulangan untuk perulangan ke i+1 dan max-1; perulangan 1 dan terakhir tidak memakai clause dan.
                    if ($jenis[$i] == "di dalam") {

                        if ($i != 0) {
                            if ($danAtau[$i - 1] == "selain") {
                                $katakunci[$i] = " NOT LIKE '%" . $katakunci[$i] . "%'";
                            } else {
                                $katakunci[$i] = " LIKE '%" . $katakunci[$i] . "%'";
                            }
                        } else {
                            $katakunci[$i] = " LIKE '%" . $katakunci[$i] . "%'";
                        }
                    } elseif ($jenis[$i] == "di awal") {
                        if ($i != 0) {
                            if ($danAtau[$i - 1] == "selain") {

                                $katakunci[$i] = " NOT LIKE '%" . $katakunci[$i] . "'";
                            } else {
                                $katakunci[$i] = " LIKE '%" . $katakunci[$i] . "'";
                            }
                        } else {
                            $katakunci[$i] = " LIKE '%" . $katakunci[$i] . "'";
                        }
                    } elseif ($jenis[$i] == "di akhir") {
                        if ($i != 0) {
                            if ($danAtau[$i - 1] == "selain") {
                                $katakunci[$i] = " NOT LIKE '" . $katakunci[$i] . "%'";
                            } else {
                                $katakunci[$i] = " LIKE '" . $katakunci[$i] . "%'";
                            }
                        } else {
                            $katakunci[$i] = " LIKE '" . $katakunci[$i] . "%'";
                        }
                    }//end if diawal,didalam,diakhir
                    if ($i < (sizeof($tag)) - 1) {
                        // echo$i;
                        if ($danAtau[$i] == "selain")
                            $danAtau2[$i] = "and"; //untuk mengubah keyword selain menjadi 'and' dan not like pada like query
                        $queryGabungan .="(" . $this->convertTag($tag[$i],$bahasa) . $katakunci[$i] . ")) " . $danAtau2[$i] . " ";
                        $query[$i] = "(" . $this->convertTag($tag[$i],$bahasa) . $katakunci[$i] . ")) " . $danAtau2[$i] . " ";
                        $queryRaw .="(" . $tag[$i] . $katakunci[$i] . ") " . $danAtau2[$i] . " ";
                        $queryRaw2 .=$katakunci2[$i] . "[" . $tag[$i] . "] " . $danAtau[$i] . " ";
                        $queryRaw3 .="[" . $tag[$i] . "] = " . $katakunci2[$i] . " " . $danAtau[$i] . " ";
                        //echo $queryGabungan; die;
                    }
                    else {
                        $queryGabungan .="(" . $this->convertTag($tag[$i],$bahasa) . $katakunci[$i] . "))";
                        $query[$i] = "(" . $this->convertTag($tag[$i],$bahasa) . $katakunci[$i] . "))";
                        $queryRaw .="(" . $tag[$i] . $katakunci2[$i] . ")";
                        $queryRaw2 .=$katakunci2[$i] . "[" . $tag[$i] . "] ";
                        $queryRaw3 .="[" . $tag[$i] . "] = " . $katakunci2[$i];
                    }
                }//end for
            } else { // buat perulangan pertama dan atau terakhir..
                if ($jenis[0] == "di dalam") {
                    $katakunci[0] = " LIKE '%" . $katakunci[0] . "%' )";
                } elseif ($jenis[0] == "di awal") {
                    $katakunci[0] = " LIKE '%" . $katakunci[0] . "' )";
                } elseif ($jenis[0] == "di akhir") {
                    $katakunci[0] = " LIKE '" . $katakunci[0] . "%' )";
                }
                $queryGabungan = $this->convertTag($tag[0],$bahasa) . $katakunci[0];
                $query[0] = $this->convertTag($tag[0],$bahasa) . $katakunci[0];
                $queryRaw = $tag[0] . $katakunci2[0];
                $queryRaw2 = $katakunci2[0] . "[" . $tag[0] . "]";
                $queryRaw3 = "[" . $tag[0] . "] = " . $katakunci2[0];
            }
            //buat nambahin kurungan
            $queryKurung = "";
            $temp = "";
            $temp2 = "";
            //ini buat logic nambahin kurung2nya gan :D
            for ($i = 0; $i < (sizeof($tag)); $i++) {

                $temp.=$query[$i];
                //strlen -4 karena ada clause dan dan spasi yg perlu di lewati buat naruh kurung
                if ($i != 0 && $i != (sizeof($tag) - 1)) {
                    $temp2 = substr_replace($temp, '(', 0, 0);
                    $queryKurung = substr_replace($temp2, ')', (strlen($temp2) - 4), 0);
                    $temp = $queryKurung;
                    //echo"test gan 1<br>";
                
                }
                //nah ini digunain di akhir. strlen tidak di kurang karena query plg belakang sudah tidak ada dan.
                else if ($i == sizeof($tag) - 1) {

                    $temp2 = substr_replace($temp, '(', 0, 0);
                    $queryKurung = substr_replace($temp2, ')', (strlen($temp2)), 0);
                    $temp = $queryKurung;
                }
                /* echo"<br>isi dari temp =".$temp;  
                  echo"<br><br>"; */
            }//end for nambahin kurung
            //print_r($queryRaw2);
            //history        
            
            $ip = OpacHelpers::getIP();

            if (isset($_SESSION['RiwayatPencarian'])) {
                $temps = $_SESSION['RiwayatPencarian'];
                $_SESSION['RiwayatPencarian'] = array_merge($temps, array(
                    array(
                        "ip" => $ip,
                        "url" => $url,
                        "action" => "pencarianLanjut",
                        "keyword" => $his,
                        "bahan" => $bahanIND,
                        "time" => $waktu,
                    )
                ));
            } else {
                $temps = array(
                    array(
                        "ip" => $ip,
                        "url" => $url,
                        "action" => "pencarianLanjut",
                        "keyword" => $his,
                        "bahan" => $bahanIND,
                        "time" => $waktu,
                    )
                );
                $_SESSION['RiwayatPencarian'] = $temps;
            }
            if (isset($_SESSION['__id'])) {
                $userid = $_SESSION['__id'];
            } else {
                $userid = NULL;
            }
            $bahasas = Refferenceitems::find()->where(['Refference_id' => 5,'Code' => $bahasa])->one();
            $targetPembacas = Refferenceitems::find()->where(['Refference_id' => 2,'Code' => $targetPembaca])->one();
            $bentukKaryas = Refferenceitems::find()->where(['Refference_id' => 17,'Code' => $bentukKarya])->one();


            $logs=[

                'user_id' => $noAnggota,
                'ip'      => $ip,
                'jenis_pencarian' => 'pencarianLanjut',
                'keyword' => $his,
                'Target_Pembaca' => isset($targetPembacas['Name']) ? $targetPembacas['Name'] : 'Semua',
                'Bahasa' =>isset($bahasas['Name']) ? $bahasas['Name'] : 'Semua',
                'Bentuk_Karya' => isset($bentukKaryas['Name']) ? $bentukKaryas['Name'] : 'Semua',
                'jenis_bahan' => $bahanIND,
                'url' => $url,
                'katakunci2' => $katakunci2,
                'tag' => $tag,
                'isLKD' => 0,
            ];

            OpacHelpers::opacLogs($logs);

            $connection = Yii::$app->db;


            if (!isset($_GET['page'])) {
                $command = $connection->createCommand("CALL insertTempLanjutOpac('" . $bahan . "','" . $bahasa . "','" . $targetPembaca . "','" . $bentukKarya . "',:temp,'" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "',''); ");
                $command->bindValue(':temp', $temp);
                $command->execute();
            } else {
                $command = $connection->createCommand("CALL insertTempLanjutOpac0('" . $bahan . "','" . $bahasa . "','" . $targetPembaca . "','" . $bentukKarya . "',:temp," . $limitAwal . "," . $limit . ",'" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "',''); ");
                 $command->bindValue(':temp', $temp);
                $command->execute();
            }

            $count = Yii::$app->db->createCommand("CALL countPencarianLanjutOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "');")->queryScalar();

            $sqlSearch = "CALL pencarianLanjutLimitOpac('0','" . $limit . "','" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "');";

            //$sqlSearch="CALL pencarianLanjutLimitOpac('".$limitAwal."','".$limit."','".$fAuthor."','".$fPublisher."','".$fPublishLoc."','".$fPublishYear."');";

            $dataProviderSearch = new SqlDataProvider([
                'sql' => $sqlSearch,
                'pagination' => false,
                    //'pagination' => [ 'pageSize' => 20,],
            ]);

            $modelSearch = $dataProviderSearch->getModels();
            $countSearch = $dataProviderSearch->getCount();

            if (!isset($_GET['page'])) {
                $_SESSION['countSearch'] = $count;
            } else {

                $count = $_SESSION['countSearch'];
            }


            $FacedAuthorMax = Yii::$app->config->get('FacedAuthorMax');
            $FacedPublisherMax = Yii::$app->config->get('FacedPublisherMax');
            $FacedPublishLocationMax = Yii::$app->config->get('FacedPublishLocationMax');
            $FacedPublishYearMax = Yii::$app->config->get('FacedPublishYearMax');
            $FacedSubjectMax = Yii::$app->config->get('FacedSubjectMax');


            $dataFacedAuthor = Yii::$app->db->createCommand("CALL facedAuthorOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedAuthorMax . "');")->queryAll();
            $dataFacedPublisher = Yii::$app->db->createCommand("CALL facedPublisherOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublisherMax . "');")->queryAll();
            $dataFacedPublishLocation = Yii::$app->db->createCommand("CALL facedPublishLocationOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublishLocationMax . "');")->queryAll();
            $dataFacedPublishYear = Yii::$app->db->createCommand("CALL facedPublishYearOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedPublishYearMax . "');")->queryAll();
            $dataFacedSubject = Yii::$app->db->createCommand("CALL facedSubjectOpac1('" . $fAuthor . "','" . $fPublisher . "','" . $fPublishLoc . "','" . $fPublishYear . "','" . $fSubject . "','" . $FacedSubjectMax . "');")->queryAll();
            //$totalCountSearch=$dataProviderSearch->getTotalCount();

            if (!isset($_GET['page'])) {
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

            //ConvertRealPath($test[]['KONTEN_DIGITAL']);
            if (!isset($dataSearch)) {
                $dataSearch = "";
            }

            return $this->render('resultListOpac', [
                        //'model' => $model,
                        'dataProviderResult' => $dataProviderSearch,
                        'countResult' => $countSearch,
                        'dataResult' => $dataSearch,
                        'totalCountResult' => $count,
                        'dataFacedAuthor' => $dataFacedAuthor,
                        'dataFacedPublisher' => $dataFacedPublisher,
                        'dataFacedPublishYear' => $dataFacedPublishYear,
                        'dataFacedPublishLocation' => $dataFacedPublishLocation,
                        'dataFacedSubject' => $dataFacedSubject,
                        'urls' => $urls,
                        'alert' => $alert,
                            //'dataFacedSubject' => $dataFacedSubject,
            ]);




            /* return $this->render('PencarianLanjut', [
              'queryGabungan' => $queryGabungan,
              'query' => $query,
              'queryKurung' => $queryKurung,
              ]); */
        }
        if ($request->isAjax && $_GET['action'] === "showCollection") {
            if (Yii::$app->user->isGuest) {
                $noAnggota = null;
            } else {
                $noAnggota = \Yii::$app->user->identity->NoAnggota;
            }
            if ($_GET['serial'] == 'true') {
                $searchModel = new CollectionSearchKardeks;
                $params['CatalogId'] = $_GET['catID'];
                $dataProvider = $searchModel->search2($params);
                //echo '<pre>'; print_r(Yii::$app->request->getQueryParams()); echo '</pre>';die;
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
                        'catID' => $catID,
            ]);
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

            return $this->renderPartial('_kontendigitallist', [

                        'dataProviderCollectionList' => $dataProviderCollectionList,
                        'countCollectionList' => $countCollectionList,
                        'dataCollectionList' => $dataCollectionList,
            ]);
        }
        if ($request->isAjax && $_GET['action'] === "logDownload") {
        OpacHelpers::logsDownload($_GET['ID'],$noAnggota,'0');          
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
            $sqlSearch = "
                SELECT CAT.id CatalogId,CAT.title kalimat2,CAT.author,CAT.publisher,CAT.PublishLocation,CAT.PublishYear,CAT.subject,CAT.CoverURL ,CAT.Worksheet_id, 
                (SELECT NAME FROM worksheets WHERE id=CAT.Worksheet_id) worksheet,
                (SELECT COUNT(1) FROM collections WHERE CATALOG_ID=CAT.ID AND STATUS_ID=1 AND BookingExpiredDate < now()) JML_BUKU,
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

            return $this->renderAjax('_search', [
                        'dataResult' => $dataSearch,
                        'booking' => $booking,
            ]);
        }
        if ($request->isAjax && $_GET['action'] === "showBookingDetail") {

            if (Yii::$app->user->isGuest) {
                $noAnggota = null;
                return $this->renderPartial('_bookingList', ['noAnggota' => $noAnggota,]);
            } else {
                $dateNow = new \DateTime("now");
                $noAnggota = \Yii::$app->user->identity->NoAnggota;
                /* $booking = Collections::find()
                  ->where(['BookingMemberID' => $noAnggota,'BookingExpiredDate >= '.$dateNow->format("Y-m-d H:i:sO")])
                  ->all(); */



                $booking = Collections::find()
                        ->select([
                            'collections.BookingExpiredDate',
                            'catalogs.Title',
                        ])
                        ->leftJoin('catalogs', '`catalogs`.`ID` = `collections`.`Catalog_id`')
                        ->andWhere('BookingMemberID ="' . $noAnggota.'"')
                        ->andWhere('BookingExpiredDate >  "' . $dateNow->format("Y-m-d H:i:s") . '"')
                        ->all();


                return $this->renderPartial('_bookingList', [

                            'booking' => $booking,
                            'noAnggota' => $noAnggota,
                ]);
            }
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
        //echo Json::encode(['response'=>'success', 'growl' => $growl ]);
        return $this->renderAjax('_usulan', [
                        //'dataResult' => $dataSearch,
        ]);
    }

}