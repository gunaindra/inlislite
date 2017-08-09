<?php

namespace common\components;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Collections;
use common\models\Collectionloanitems;


use \DateTime;

class SirkulasiHelpers 
{
    

   /**
    * [loadModelKoleksi description]
    * @param  [type] $nomorBarcode [description]
    * @return [type]               [description]
    */
   public static function loadModelKoleksi($nomorBarcode) {

            $model = \common\models\Collections::findOne(['NomorBarcode' => $nomorBarcode]);
            if ($model === null)
                throw new \yii\web\HttpException(404, 'Koleksi tersebut tidak terdapat dalam database.');
            else{
                if ($model->Status_id != "1") 
                throw new \yii\web\HttpException(404, 'Koleksi sedang tidak tersedia, periksa kembali nomor barcode.');
            }
            return $model;

    }


    /**
    * [loadModelKoleksi description]
    * @param  [type] $nomorBarcode [description]
    * @return [type]               [description]
    */
   public static function loadModelKoleksiByBarcode($nomorBarcode) {

            $model = \common\models\Collections::findOne(['NomorBarcode' => $nomorBarcode]);
            if ($model === null){
                throw new \yii\web\HttpException(404, 'Koleksi tersebut tidak terdapat dalam database.');
            }
            

            return $model;

    }

    /**
     * [validatePelanggaran description]
     * @param  [string] $noAnggota [description]
     * @return [date]            [description]
     */
    public static function validatePelanggaran($noAnggota)
    {
        // JenisDenda_id = 5 (SUSPEND)
        $sql = "SELECT DATE_FORMAT(DATE_ADD(pelanggaran.CreateDate,INTERVAL JumlahSuspend DAY) ,'%Y-%m-%d')AS BolehPinjam " .
            " FROM pelanggaran" .
            " INNER JOIN members ON pelanggaran.Member_id = members.id" .
            " WHERE members.MemberNo = '" . $noAnggota . "' AND jumlahsuspend > 0".
            " ORDER BY BolehPinjam DESC";

        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        if (!$result)
        { 
            // Tidak ada pelanggaran yang di suspend.
            $result = date('Y-m-d');
        }
        return $result;
    }

    /**
     * [isMemberStatus description]
     * @param  [type]  $noAnggota [description]
     * @param  [type]  $status    [description]
     * @return boolean            [description]
     */
    public static function isMemberStatus($noAnggota,$status)
    {
        // 5 Suspend,
        // 3 Active
            $sql = "SELECT StatusAnggota_id FROM members WHERE MemberNo = '" .$noAnggota. "'";
            $result = Yii::$app->db->createCommand($sql)->queryScalar();
            if (!$result)
            { 
                return false;
            }else
            {
                if($result == $status) 
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
    }

 
    public static function isMemberExpired($noAnggota)
    {
        $sql = "SELECT * FROM members WHERE MemberNo = '" .$noAnggota. "' and EndDate >= '" . date('Y-m-d') . "'";
        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        if (!$result)
        { 
                // Tidak ada pelanggaran yang di suspend.
            $result = false;
        }else{
            $result = true;
        }
        return $result;

    }

    public static function isUserHasAccess($userID)
    {
        

        $sql = "SELECT * FROM users INNER JOIN userloclibforloan ON userloclibforloan.User_id=users.ID WHERE ID = " .$userID.  " and IsActive = 1";
        $result = Yii::$app->db->createCommand($sql)->queryScalar();

        return $result;
    }

    public static function isMemberCanLoanOnLocation($memberNo, $userId)
    {
        $sql = "";
        $sql2 = "";
        $locLibUser=array(); //data lokasi yang petugas boleh cek

        // Ambil data lokasi yang petugas boleh cek
        $sql = "SELECT * FROM users" .
        " INNER JOIN userloclibforloan ON userloclibforloan.User_id=users.ID" .
        " WHERE ID = " . $userId ." and IsActive = 1";

        $result = Yii::$app->db->createCommand($sql)->queryAll();
        if(!is_null($result)){
            
            foreach($result as $row )
            {
                array_push($locLibUser,$row["LocLib_id"]); //data lokasi yang petugas boleh cek
            }

            // Ambil data lokasi yang anggota boleh melakukan peminjaman
            $sql2 = "SELECT m.MemberNo as MemberNo, ml.LocationLoan_id as LocationLoan_id" .
            " FROM memberloanauthorizelocation ml INNER JOIN members m ON (ml.Member_id = m.ID) " .
            " WHERE m.MemberNo = '" .$memberNo. "'" .
            " and m.StatusAnggota_id = 3" . //'ACTIVE'
            " and m.EndDate >= '" . date('Y-m-d') . "'";

            $resultSQL2 = Yii::$app->db->createCommand($sql2)->queryAll(); //data lokasi yang anggota boleh melakukan peminjaman
            if(!is_null($resultSQL2)){  // jika ada lokasi anggota yang boleh meminjam 

               foreach($resultSQL2 as $row)
               {
                    if (in_array($row["LocationLoan_id"], $locLibUser) && $row["LocationLoan_id"] == Yii::$app->location->get() )
                    {
                        return true;
                    }
               }
               return false;
                
            }
            else
            {
                return false;
            }
                   
        }
        else
        {
            return false;
        }
    }

    public static function suspendAnggota($jumlah)
    {
        $jml = 0;
        $sql = "select SuspendMember from kelompok_pelanggaran where Jumlah = " . $jumlah;
        
        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        if (!$result)
        {
            $jml = $result;
        }
        else
        {
            $jml = 0;
        }
        return $jml;
    }

    public static function jumlahPelanggaranAnggota($memberNo)
    {
        $jml = 0;
        $sql = "SELECT COUNT(*) AS JumlahPelanggaran FROM collectionloanitems cli" .
        " INNER JOIN pelanggaran p ON (cli.ID = p.CollectionLoanItem_id)" .
        " INNER JOIN collectionloans cl ON (cli.CollectionLoan_id = cl.id)" .
        " INNER JOIN members m ON (cl.Member_id = m.ID)" .
        " WHERE m.MemberNo ='" . $memberNo . "'"; 
        
        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        if (!$result)
        {
            $jml = $result;
        }
        else
        {
            $jml = 0;
        }
        return $jml;
    }

    public static function getWarningLoanDueDay($collectionID, $memberNo)
    {
        //Peraturan Peminjaman (Tanggal)
        $sql = "SELECT DaySuspend,DendaPerTenor,WarningLoanDueDay FROM peraturan_peminjaman_tanggal" .
            " WHERE DATE(SYSDATE()) BETWEEN TanggalAwal AND TanggalAkhir";

        $result = Yii::$app->db->createCommand($sql)->queryAll();
      
        if (!empty($result))
        {
            $daySuspend = $result[0]["DaySuspend"];
            $dendaPerTenor = $result[0]["DendaPerTenor"];
            if ($daySuspend > 0 || $dendaPerTenor > 0)
            {
                return $result[0]["WarningLoanDueDay"];
            }
        }

        //Peraturan Peminjaman (Hari)
       if (!empty($result))
        {
            $sql = "SELECT DaySuspend,DendaPerTenor,WarningLoanDueDay FROM peraturan_peminjaman_hari" .
                " WHERE DayIndex = IF(DAYOFWEEK(SYSDATE()) = 1, 7, DAYOFWEEK(SYSDATE()) - 1)";

           $result = Yii::$app->db->createCommand($sql)->queryAll();

            if (!empty($result))
            {
                $daySuspend = $result[0]["DaySuspend"];
                $dendaPerTenor = $result[0]["DendaPerTenor"];
                if ($daySuspend > 0 || $dendaPerTenor > 0)
                {
                    return $result[0]["WarningLoanDueDay"];
                }
            }
        }

        //Jenis Anggota
        $sqlAnggota = "SELECT DaySuspend,DendaPerTenor,WarningLoanDueDay FROM members" .
            " INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID" .
            " WHERE members.MemberNo = '" . $memberNo . "'";

        $resultAnggota = Yii::$app->db->createCommand($sqlAnggota)->queryAll();
        if (!empty($resultAnggota))
        {
                $daySuspend = $resultAnggota[0]["DaySuspend"];
                $dendaPerTenor = $resultAnggota[0]["DendaPerTenor"];
                if ($daySuspend > 0 || $dendaPerTenor > 0)
                {
                    return $resultAnggota[0]["WarningLoanDueDay"];
                }
        }

        //Jenis Bahan
        $sql = "SELECT DaySuspend,DendaPerTenor,WarningLoanDueDay FROM collections" .
            " INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID" .
            " INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID" .
            " WHERE collections.ID = " . $collectionID;

        $resultJenisBahan = Yii::$app->db->createCommand($sql)->queryAll();

        if (!empty($resultJenisBahan))
        {
                $daySuspend = $resultJenisBahan[0]["DaySuspend"];
                $dendaPerTenor = $resultJenisBahan[0]["DendaPerTenor"];
                if ($daySuspend > 0 || $resultJenisBahan > 0)
                {
                    return $resultJenisBahan[0]["WarningLoanDueDay"];
                }
        }

        return -1;
    }


    public static function lateDays($actualReturn, $dueDate)
    {

        $ts = date_diff(date_create($dueDate),date_create($actualReturn));
        //return  $ts->format("%d");
        return $ts->format("%R%a ");
    }


    public static function IsMemberCanLoanOnItem($memberNo, $nomorBarcode)
    {

        $sql = "SELECT Category_id FROM collections WHERE NomorBarcode = '" . $nomorBarcode . "'";
        $result = Yii::$app->db->createCommand($sql)->queryAll();


        $category = $result[0]["Category_id"];

        $sql2 = "SELECT m.MemberNo as MemberNo, ml.CategoryLoan_id as CategoryLoan_id" .
        " FROM memberloanauthorizecategory ml INNER JOIN members m ON (ml.Member_id = m.ID) " .
        " WHERE m.MemberNo = '" . $memberNo . "'" .
                " and m.StatusAnggota_id = 3" .//'ACTIVE'
                " and m.EndDate >= '" .date('Y-m-d'). "'";

                $result2 = Yii::$app->db->createCommand($sql2)->queryAll();

                if (!is_null($result2))
                {
                    foreach($result2 as $row)
                    {
                        if ($row["CategoryLoan_id"] == $category)
                        {
                            return true;
                        }
                    }
                    return false;
                }
                else
                {
                    return false;
                }
    }

    public static function getMaksJumlahPeminjaman($memberID)
    {
           $countBukuYgDipinjam = 0;
           // $countBukuYgBolehDipinjam = Yii::$app->config->get('MaksJumlahPeminjaman'); 
           $memberDetail = \common\models\Members::findOne($memberID);
           $countBukuYgBolehDipinjam = $memberDetail->jenisAnggota->MaxPinjamKoleksi;

           $sql = "SELECT COUNT(CollectionLoan_id) jumlah FROM collectionloanitems WHERE member_id = '" .trim($memberID). "' AND LoanStatus = 'Loan'";
           $result = Yii::$app->db->createCommand($sql)->queryAll();
           if (!is_null($result))
            {
                    foreach($result as $row)
                    {
                        $countBukuYgDipinjam = $row["jumlah"];
                    }

            }
              
           $maksJumlahPeminjaman = $countBukuYgBolehDipinjam - $countBukuYgDipinjam;

           return $maksJumlahPeminjaman;

    }

    
    


    public static function getTanggalKembali($memberNo, $loanDate, $nomorBarcode)
    {
        $result=date('Y-m-d');
        $sun = 0;
        $sat = 0;

        $collections =  \common\models\Collections::findOne(['NomorBarcode' => $nomorBarcode]);
        $collectionID=$collections->ID;

        $maxLoanDays = self::cekLamaPinjam($collectionID, $memberNo);

        if ($maxLoanDays > 0)
        {

            
            $isSaturdayHoliday = Yii::$app->config->get('IsSaturdayHoliday'); 
            $isSundayHoliday = Yii::$app->config->get('IsSundayHoliday'); 

            $returnDate =  \common\components\Helpers::addDayswithdate($loanDate,$maxLoanDays);
            $checkDate = $returnDate;

            //(int)$sun = 0; 
        
            $d1=new DateTime($checkDate);
            $d2=new DateTime($loanDate);
            $diff=$d2->diff($d1);
            (int)$days = $diff->days;

          

            for($i=1;$i<=$days;$i++)
            {
                
                if (date('l', strtotime($loanDate. ' + '.$i.' days'))=="Saturday" && $isSaturdayHoliday=="True"){
                     $sat++;
                }

                if($sat != 0){
                    $hari = $i + $sat;
                    if (date('l', strtotime($loanDate. ' + '.$hari.' days'))=="Sunday" && $isSundayHoliday=="True")
                                    {
                                        $sun++;
                                    }
                }else{
                   if (date('l', strtotime($loanDate. ' + '.$i.' days'))=="Sunday" && $isSundayHoliday=="True")
                    {
                        $sun++;
                    } 
                }

            }

            $checkDateLibur =  \common\components\Helpers::addDayswithdate($checkDate,$sun + $sat);

            $countJumlahLibur = self::JumlahLiburMasaPinjam($loanDate, $checkDateLibur);

            $totalJumlahLibur = $maxLoanDays + $countJumlahLibur + $sun + $sat;
           
           
            
            $result =  \common\components\Helpers::addDayswithdate($loanDate,$totalJumlahLibur);
            /*$checkDate = $returnDate;
            $result = \common\components\Helpers::addDayswithdate($checkDate,5);*/


        }

        return $result;
    }


    public static function jumlahLiburMasaPinjam($tglPinjam, $tglKembali)
    {
        $sql = "SELECT count(Dates) FROM holidays WHERE DATE_FORMAT(Dates,'%Y-%m-%d') BETWEEN '" . $tglPinjam . "' AND '" . $tglKembali . "'";

        $result = Yii::$app->db->createCommand($sql)->queryScalar();

        if ($result > 0)
        {
            $jml = $result;
        }
        else
        {
            $jml = 0;
        }
        return $jml;
        
    }

    public static function cekLamaPinjam($collectionID, $memberNo)
    {
        $result = 0;
    
        //Peraturan Peminjaman (Tanggal)
        $sqlTgl = "SELECT MaxLoanDays FROM peraturan_peminjaman_tanggal" .
            " WHERE DATE(SYSDATE()) BETWEEN TanggalAwal AND TanggalAkhir";

        $resultTgl = Yii::$app->db->createCommand($sqlTgl)->queryScalar();


        if($resultTgl)
        {
            $result = $resultTgl;
        }

        //Peraturan Peminjaman (Hari)
        $sqlHari = "SELECT MaxLoanDays FROM peraturan_peminjaman_hari" .
                " WHERE DayIndex = IF(DAYOFWEEK(SYSDATE()) = 1, 7, DAYOFWEEK(SYSDATE()) - 1)";

        $resultHari = Yii::$app->db->createCommand($sqlHari)->queryScalar();
        if ($resultHari)
        {
            $result = $resultHari;
        }

        //Jenis Anggota
        
        $sqlJenisAnggota = "SELECT MaxLoanDays FROM members" .
                " INNER JOIN jenis_anggota ON members.JenisAnggota_id = jenis_anggota.ID" .
                " WHERE members.MemberNo = '" . $memberNo ."'";

        $resultJenisAnggota = Yii::$app->db->createCommand($sqlJenisAnggota)->queryScalar();
       
        if ($resultJenisAnggota)
        {
            $result = $resultJenisAnggota;
        }

        //Jenis Bahan
        
            $sqlJenisBahan = "SELECT MaxLoanDays FROM collections" .
                " INNER JOIN catalogs ON collections.Catalog_id = catalogs.ID" .
                " INNER JOIN worksheets ON catalogs.Worksheet_id = worksheets.ID" .
                " WHERE collections.ID = " . $collectionID;

            $resultJenisBahan = Yii::$app->db->createCommand($sqlJenisBahan)->queryScalar();

        if($resultJenisBahan)
        {
            $result =  $resultJenisBahan;
            
        }
       
       return $result;

         
           
    }



    

    /**
     * Generate New ID Sirkulasi
     * @param  datenow $createDate Now date(Y-m-d)
     * @return string  $no           [New Number ID]
     */
    public static function generateNewID($createDate)
    {

        $maxID = self::getMaxID($createDate);
        if (isset($maxID) || $maxID != false) {
                $tambah = ($maxID + 1);
                $rest = substr($tambah, -5);
                $tanggaldepan = date("ymd", strtotime($createDate));
                $potongtanggal = substr($tanggaldepan, -6);
                $batas = 10000;
                $jumlah = ($batas + $rest);
                $jumlahtotal = $potongtanggal . $jumlah;
                $no = substr_replace($jumlahtotal, '0', 6, 1);

            } else {
                $rest = 1;
                $tanggaldepan = date("ymd", strtotime($createDate));
                $potongtanggal = substr($tanggaldepan, -6);
                $batas = 10000;
                $jumlah = ($batas + $rest);
                $jumlahtotal = $potongtanggal . $jumlah;
                $no = substr_replace($jumlahtotal, '0', 6, 1);

            }
        return $no;
    }

    protected static function getMaxID($createDate)
    {
        $sql = "SELECT MAX(id) FROM collectionloans where id LIKE '" . date("ymd", strtotime($createDate)). "%'";
        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        return $result; 
    }


    /**
    * [loadModelKoleksi description]
    * @param  [type] $nomorBarcode [description]
    * @return [type]               [description]
    */
   public static function loadModelCollectionLoanItems($nomorBarcode) {

        $sql = "SELECT cli.ID as CollectionLoanItem_Id, cli.CollectionLoan_id, cli.Collection_id," .
                " c.NomorBarcode, c.RFID, cli.Member_id," .
                " cat.Title, cat.Author, cat.Publisher," .
                " cli.LoanDate, cli.DueDate, cli.ActualReturn, cli.LateDays" .
                " FROM collectionloanitems cli" .
                " LEFT JOIN collections c ON cli.Collection_id = c.ID" .
                " LEFT JOIN catalogs cat ON c.Catalog_id = cat.id" .
                " WHERE c.NomorBarcode ='" .$nomorBarcode. "'".
                " AND cli.LoanStatus = 'Loan' ";

        $result = Yii::$app->db->createCommand($sql)->queryAll();
        if (!empty($result))
        {
              return $result;
        }else{
            throw new \yii\web\HttpException(404, 'Koleksi tersebut tidak terdapat dalam database.');
        }
           
            

    }






    public static function getStokOpnameDetail($noAnggota)
    {
        $sql = "SELECT * FROM members WHERE MemberNo = '" .$noAnggota. "' and EndDate >= '" . date('Y-m-d') . "'";
        $result = Yii::$app->db->createCommand($sql)->queryScalar();
        if (!$result)
        { 
                // Tidak ada pelanggaran yang di suspend.
            $result = false;
        }else{
            $result = true;
        }
        return $result;

    }


	
	

	public static function searchArrayByKeyAndValue($array, $key, $value)
	{	
		$results = array();
		SirkulasiHelpers::search_r($array, $key, $value, $results);
		return $results;
	}

	public function search_r($array, $key, $value, &$results)
	{
		if (!is_array($array)) {
			return;
		}

		if (isset($array[$key]) && $array[$key] == $value) {
			$results[] = $array;
		}

		foreach ($array as $subarray) {
			SirkulasiHelpers::search_r($subarray, $key, $value, $results);
		}
	}


    
}
