<?php

/**
 * @copyright Copyright &copy; Perpustakaan Nasional RI, 2015
 * @package helpers
 * @version 1.0.0
 * @author Rico <rico.ulul@gmail.com>
 */

namespace common\components;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Collections;
use common\models\Logsdownload;
use common\models\Collectionloanitems;
use common\components\SirkulasiHelpers;
use yii\db\Expression;
use common\models\Opaclogs;
use common\models\OpaclogsKeyword;
use \DateTime;

class OpacHelpers 
{
    
    public static function getIP(){
        $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
        return $ip;
    }
    public static function jumlahBooking($noAnggota){
        $dateNow = new DateTime("now");
        $time=$dateNow->format("Y-m-d H:i:s");
        if (is_null($noAnggota)) {
            return 0;
        } else
        {
            $sql = "select count(1)  " .
                   " FROM collections col " .
                   " LEFT JOIN catalogs cat on cat.id= col.Catalog_id" .
                   " where col.BookingMemberID = '" . $noAnggota . "' and BookingExpiredDate  > '".$time."' ";

            $result = Yii::$app->db->createCommand($sql)->queryScalar();

            return $result;

        }
    }

    public static function cekBooking($noAnggota,$colID){
        $err=[];
        $locationLoan=[];
        $colCat=[];
        $jmlBookMaks = Yii::$app->config->get('JumlahBookingMaksimal');
        $bookExp = Yii::$app->config->get('BookingExpired');
        $sqlCol="select Location_Library_id from collections where ID='".$colID."'";
        $Location_Library_id = Yii::$app->db->createCommand($sqlCol)->queryScalar();
        $sql_col="select * from collections where id = '".$colID."'";
        $collections = Yii::$app->db->createCommand($sql_col)->queryAll();
        $sql_collectionCategory="SELECT CategoryLoan_id FROM memberloanauthorizecategory ml left join members m on ml.Member_id = m.id where m.MemberNo ='".$noAnggota."'";
        $collectionsCategory=Yii::$app->db->createCommand($sql_collectionCategory)->queryAll();
         foreach ($collectionsCategory as $key => $tmp) {
            array_push($colCat, $tmp['CategoryLoan_id']);
        }



        //cek jumlahBooking
        $jmlBooking=self::jumlahBooking($noAnggota);
        //status member
        $sql = "select StatusAnggota_id,EndDate " .
            " FROM members  " .
            " where MemberNo = '" . $noAnggota."'";
        $statusMember = Yii::$app->db->createCommand($sql)->queryAll();
        $dateNow=new \DateTime("now");
        $dateBook=new \DateTime($statusMember[0]['EndDate']);


        //cek pinjam
        $sqlLoanLoc="SELECT LocationLoan_id FROM memberloanauthorizelocation
                    left join members on members.ID = memberloanauthorizelocation.Member_id
                    where members.MemberNo = '".$noAnggota."'";
        $loanLoc=Yii::$app->db->createCommand($sqlLoanLoc)->queryAll();

        foreach ($loanLoc as $key => $loclib) {
            array_push($locationLoan, $loclib['LocationLoan_id']);
        }

        if($jmlBooking>=$jmlBookMaks)array_push($err, 'Jumlah Booking Lebih Dari '.$jmlBookMaks.' item');
        if($statusMember[0]['StatusAnggota_id']!=3)array_push($err, 'Anggota Belum Aktif');
        if(!in_array($Location_Library_id,$locationLoan))array_push($err, 'Anda Tidak Mempunyai Akses Peminjaman Di Lokasi Ini');
        if($dateNow>$dateBook)array_push($err, 'Status Keanggotaan Anda Sudah Kadalaursa');
        if(!in_array($collections[0]['Category_id'], $colCat))array_push($err, 'Anda Tidak Mempunyai Akses Peminjaman Koleksi Ini');

        return $err;
    }

    public static function isHoliday($date){
        $isSaturdayHoliday = Yii::$app->config->get('IsSaturdayHoliday'); 
        $isSundayHoliday = Yii::$app->config->get('IsSundayHoliday');

        if (date('l', strtotime($date))==="Saturday" && $isSaturdayHoliday==="True") return true;
        if (date('l', strtotime($date))==="Sunday" && $isSundayHoliday==="True") return true;

        $sql = "SELECT count(Dates) FROM holidays WHERE Dates = '" . $date . "'";
        $result = Yii::$app->db->createCommand($sql)->queryScalar();

        if ($result)
        {
            return true;
        }
        
        return false;
    }

    public static function getIndonesianDays($tgl="now"){   
        $date = new DateTime($tgl);
        $week = $date->format("w");
        $days = Array ("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");

        return $days[$week];
    }

    public static function SetBookingTime($date){

        $hariini=self::getIndonesianDays();
        $sqlJambuka = "select jam_buka from master_jam_buka where hari =  '" . $hariini . "'";
        $sqlJamtutup = "select jam_tutup from master_jam_buka where hari = '" . $hariini . "'";
        $jambuka = Yii::$app->db->createCommand($sqlJambuka)->queryScalar();
        $jamtutup = Yii::$app->db->createCommand($sqlJamtutup)->queryScalar();
        $tambahJam= explode(":",$date);
        $jamTutup1= explode(":",$jamtutup);
        $jamBuka1= explode(":",$jambuka);
        $dateBook = new \DateTime('now');
        $datetutup = new \DateTime('now');
        $dateBuka = new \DateTime('now');
        $dateNow= new \DateTime('now');
        $dateBuka->setTime($jamBuka1[0], $jamBuka1[1],$jamBuka1[2]);
        $datetutup->setTime($jamTutup1[0], $jamTutup1[1],$jamTutup1[2]);
        $dateBook->modify("+".$tambahJam[0]." hours +".$tambahJam[1]." minutes +".$tambahJam[2]." seconds");
        $intervalJambukaTutup=$datetutup->getTimestamp() - $dateBuka->getTimestamp();
        $intervalBooking= $dateBook ->getTimestamp() - $dateNow->getTimestamp();

        $interval='';
        //belum jam buka
        if ( $dateNow < $dateBuka) {
            $interval='';
            $next=true;
            
            $hariSelanjutnya=$dateBuka;
            $hariSelanjutnya=self::nextOperationalDay();
            if ($intervalJambukaTutup > $intervalBooking) {
                $hariSelanjutnya->modify("+".$tambahJam[0]." hours +".$tambahJam[1]." minutes +".$tambahJam[2]." seconds");
            } else {
                while ($next == true) {
                    if ($intervalJambukaTutup < $intervalBooking) {
                        $hariSelanjutnya=self::nextOperationalDay($hariSelanjutnya->modify("+ 1 days ")->format("d-m-Y H:i:s"));
                        $intervalBooking -= $intervalJambukaTutup;
                    } else {
                        $hariSelanjutnya->modify("+ ".$intervalBooking." seconds ")->format("d-m-Y H:i:s");
                        $next=false;
                    }
                }
            }
            return $hariSelanjutnya;

        } elseif ($dateNow > $datetutup) {
            //echo "udah jam tutup";
            $hariSelanjutnya=self::nextOperationalDay();
            $interval='';
            $next=true;
            $nextBookingTime=$dateBuka;
            $nextBookingTime->modify("+".$tambahJam[0]." hours +".$tambahJam[1]." minutes +".$tambahJam[2]." seconds");
            $hariSelanjutnya=$dateBuka;
            while ($next == true) {
                if ($intervalJambukaTutup < $intervalBooking) {
                    $hariSelanjutnya=self::nextOperationalDay($hariSelanjutnya->modify("+ 1 days ")->format("d-m-Y H:i:s"));
                    $intervalBooking -= $intervalJambukaTutup;
                } else {
                    $hariSelanjutnya->modify("+ ".$intervalBooking." seconds ")->format("d-m-Y H:i:s");
                    $next=false;
                }                
            }

            return $hariSelanjutnya;
        } else
        {
          if ($dateBook > $datetutup) {
                $interval = $datetutup->diff($dateBook);
                $hariSelanjutnya=self::nextOperationalDay();
                $nextBookingTime=$hariSelanjutnya;
                $nextBookingTime->modify("+".$interval->format('%H')." hours +".$interval->format('%i')." minutes +".$interval->format('%s')." seconds");

                return $nextBookingTime;                
            } else {
                //echo "waktu akhir booking aman";
                $isHoliday=self::isHoliday($dateBook->format("Y-m-d"));
                if ($isHoliday) {

                    $dateBook=self::nextOperationalDay();
                    $dateBook->modify("+".$tambahJam[0]." hours +".$tambahJam[1]." minutes +".$tambahJam[2]." seconds");
                }
                return $dateBook;
            }   
        }
    }

    public static function nextOperationalDay($date = 'now'){
        $i=1;
        $date=new \DateTime($date);
        $nextDay=  $date;
        $isHoliday = true;
        $isSaturdayHoliday = Yii::$app->config->get('IsSaturdayHoliday'); 
        $isSundayHoliday = Yii::$app->config->get('IsSundayHoliday');
        $hariini=self::getIndonesianDays();
        $sqlJambuka = "select jam_buka from master_jam_buka where hari =  '" . $hariini . "'";
        $jambuka = Yii::$app->db->createCommand($sqlJambuka)->queryScalar();
        $jamBuka1= explode(":",$jambuka);
        //buat cek ada hari libur ga, kalau ada hari libur +1 hari
        while ($isHoliday) {
            if ($i != 1) {
                $nextDay->modify("+1 days");
            }
            $isHoliday=self::isHoliday($nextDay->format("Y-m-d"));
            $i++;
        }
        //buat cek jam buka pada hari operational selanjutnya
        $hariNextOperationalDay=self::getIndonesianDays($nextDay->format("Y-m-d"));
        $sqlJambuka = "select jam_buka from master_jam_buka where hari =  '" . $hariNextOperationalDay . "'";
        $jambuka = Yii::$app->db->createCommand($sqlJambuka)->queryScalar();
        $jamBuka1= explode(":",$jambuka);
        $nextDay->setTime($jamBuka1[0], $jamBuka1[1],$jamBuka1[2]);
        return $nextDay;

    }

    public static function logsDownload($id,$userid,$isLKD='0'){
        $model = new Logsdownload;
        $model->User_id = $userid;
        $model->ip = self::getIP();
        $model->catalogfilesID = $id;
        $model->isLKD = $isLKD;
        $model->waktu = new Expression('NOW()');
        $model->save(false);
    }
    public static function opacLogs($logs){

        switch ($logs['jenis_pencarian']) {
            case 'pencarianSederhana':
                    $model = new Opaclogs;
                    $model->User_id = $logs['User_id'];
                    $model->ip = $logs['ip'];
                    $model->jenis_pencarian = 'pencarianSederhana';
                    $model->keyword =$logs['keyword'];
                    $model->jenis_bahan = $logs['jenis_bahan'];
                    $model->waktu = new Expression('NOW()');
                    $model->url = $logs['url'];
                    $model->isLKD = $logs['isLKD'];
                    $model->save();
                    $opaclogsID = $model->getPrimaryKey();

                    $modellogs = new OpaclogsKeyword;
                    $modellogs->OpaclogsId = $opaclogsID;
                    $modellogs->Field = $logs['Field'];
                    $modellogs->Keyword =  $logs['keyword'];
                    $modellogs->save();
                break;
            case 'pencarianLanjut':

                    $model = new Opaclogs;
                    $model->User_id = $logs['User_id'];
                    $model->ip = $logs['ip'];
                    $model->jenis_pencarian = "pencarianLanjut";
                    $model->keyword = $logs['keyword'];
                    $model->Target_Pembaca =$logs['Target_Pembaca'];
                    $model->Bahasa = $logs['Bahasa'];
                    $model->Bentuk_Karya = $logs['Bentuk_Karya'];
                    $model->jenis_bahan = $logs['jenis_bahan'];
                    $model->waktu = new Expression('NOW()');
                    $model->url = $logs['url'];
                    $model->isLKD = $logs['isLKD'];
                    $model->save();
                    $opaclogsID = $model->getPrimaryKey();


                    for ($i = 0; $i < sizeof($katakunci2); $i++) {
                    $modellogs = new OpaclogsKeyword;
                    $modellogs->OpaclogsId = $opaclogsID;
                    $modellogs->Field = $logs['tag'][$i];
                    $modellogs->Keyword =  $logs['katakunci2'][$i];
                    $modellogs->save();

                    }  
                break;
            case 'browse':
                    $model = new Opaclogs;
                    $model->User_id = $logs['User_id'];
                    $model->ip = $logs['ip'];
                    $model->jenis_pencarian = 'browse';
                    $model->keyword = $logs['keyword'];
                    $model->waktu = new Expression('NOW()');
                    $model->isLKD = $logs['isLKD'];
                    $model->url = $logs['url'];
                    $model->save();


                    $opaclogsID = $model->getPrimaryKey();
                    $modellogs = new OpaclogsKeyword;
                    $modellogs->OpaclogsId = $opaclogsID;
                    $modellogs->Field = $logs['findByID'];
                    $modellogs->Keyword =  $logs['query'];
                    $modellogs->save();

                    $modellogs = new OpaclogsKeyword;
                    $modellogs->OpaclogsId = $opaclogsID;
                    $modellogs->Field = $logs['tagID'];
                    $modellogs->Keyword =  $logs['query2'];
                    $modellogs->save();
                break;
        }
    }

    public static function clearTemp(){
        $lastClear = Yii::$app->config->get('lastClearTemporary');
        return $lastClear;
    }

    public static function sortWorksheets($array){
        
        usort($array, function($a, $b) {
            return $a['NoUrut'] - $b['NoUrut'];
        });

        return $array;

    }

    public static function getDigitalCollectionDir($id){

    $sqlKontendigital = "CALL showKontenDigital(" . $id . "); ";
    $KontenDigital = Yii::$app->db->createCommand( $sqlKontendigital)->queryall();


        foreach ($KontenDigital as $key => $value) {
    $datas = Yii::$app->db->createCommand("SELECT `catalogfiles`.`id`, `catalogfiles`.`FileURL`, `catalogfiles`.`FileFlash`, `catalogfiles`.`isPublish`, `worksheets`.`id`, `worksheets`.`name`,(SELECT  SUBSTRING(FileURL,(LENGTH(FileURL)-LOCATE('.',REVERSE(FileURL)))+2))  as FormatFile,       (SELECT  SUBSTRING(FileFlash,(LENGTH(FileFlash)-LOCATE('.',REVERSE(FileURL)))+2))  as FormatFileFlash FROM `catalogfiles` LEFT JOIN `catalogs` ON `catalogs`.`ID` = `catalogfiles`.`Catalog_id` LEFT JOIN `worksheets` ON `worksheets`.`ID` = `catalogs`.`Worksheet_id` WHERE `catalogfiles`.`id`=".$value['ID'].";")->queryAll();
            if($value['FileFlash']!='' && $value['FileFlash'] != NULL){
             $wName=$datas[0]['name'];
             $file=$datas[0]['FileFlash'];
             $format=$datas[0]['FormatFileFlash'];
             $addPath=$wName.'/'.str_replace(".rar","",str_replace(".zip","",$datas[0]['FileURL']));
             $realpath =  'dokumen_isi/'.$addPath.'/'.$file;;
             $KontenDigital[$key]['path']=$realpath;
            } else
            {
             $wName=$datas[0]['name'];
             $file=$datas[0]['FileURL'];
             $format=$datas[0]['FormatFile'];
             $addPath=$wName.'/'.$datas[0]['FileURL'];
             $realpath = 'dokumen_isi/'.$addPath;;
             $KontenDigital[$key]['path']=$realpath;
            }


        }
    return $KontenDigital;
    }
    
}
