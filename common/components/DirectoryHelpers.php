<?php

namespace common\components;

use Yii;
use yii\base\Model;
use common\models\Worksheets;

/**
 * CollectionmediaSearch represents the model behind the search form about `common\models\Collectionmedias`.
 */
class DirectoryHelpers
{
   
    public static function GetBytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }
    
    public static function GetDirWorksheet($worksheetid) {
        
        //jika tidak mempunyai gambar maka akan di set sampul secara default.
        $model = Worksheets::findOne($worksheetid);
           
        return $model->Name;
    }


    public static function CreateZip($dirLevel,$mainPath,$files,$prefixFileDownload,&$pathZip,&$pathReadyDownload)
    {
        $zip = new \ZipArchive();
        $now = date("Ymdhis");
        $userID = (string)Yii::$app->user->identity->ID;
        $dirUserID =  Yii::getAlias('@'.$mainPath).$userID;
        if(!is_dir($dirUserID))
        {
            mkdir($dirUserID , 0777);
        }
        
        $fileZip=$prefixFileDownload.$now.".zip";
        $pathZip= $dirUserID.DIRECTORY_SEPARATOR.$fileZip;
        $pathReadyDownload = $dirLevel.$mainPath.$userID.DIRECTORY_SEPARATOR.$fileZip;
        

        if(file_exists($pathZip)) {
            unlink ($pathZip); 
        }

        if ($zip->open($pathZip,  \ZipArchive::CREATE)) {
           foreach ($files as $file) {
                $filename =  pathinfo(realpath($file), PATHINFO_BASENAME); 
                $zip->addFile($file,$filename);
            }
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    public static function RemoveDirRecursive($dir)
    {
        if (is_dir($dir)) { 
         $objects = scandir($dir); 
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (is_dir($dir."/".$object))
               self::RemoveDirRecursive($dir."/".$object);
             else
               unlink($dir."/".$object); 
           } 
         }
         rmdir($dir); 
       } 
    }
    public static function GetTemporaryFolder($catalogfilesID,$filetype){
    $datas = Yii::$app->db->createCommand("SELECT `catalogfiles`.`id`, `catalogfiles`.`FileURL`, `catalogfiles`.`FileFlash`, `catalogfiles`.`isPublish`, `worksheets`.`id`, `worksheets`.`name`,(SELECT  SUBSTRING(FileURL,(LENGTH(FileURL)-LOCATE('.',REVERSE(FileURL)))+2))  as FormatFile,		(SELECT  SUBSTRING(FileFlash,(LENGTH(FileFlash)-LOCATE('.',REVERSE(FileURL)))+2))  as FormatFileFlash FROM `catalogfiles` LEFT JOIN `catalogs` ON `catalogs`.`ID` = `catalogfiles`.`Catalog_id` LEFT JOIN `worksheets` ON `worksheets`.`ID` = `catalogs`.`Worksheet_id` WHERE `catalogfiles`.`id`=".$catalogfilesID.";")->queryAll();
     switch ($filetype) {
        	case 1:
        		 $wName=$datas[0]['name'];
 			     $file=$datas[0]['FileURL'];
 			     $format=$datas[0]['FormatFile'];
 			     $addPath=$wName.'/'.$datas[0]['FileURL'];
 			     $realpath = Yii::getAlias('@uploaded_files') . '/dokumen_isi/'.$addPath;


 			    $aliasPath=Yii::getAlias('@uploaded_files');
		        //di sha1 biar kalo di base64decode ga keliatan namafile dan folderworksheetnya.
		        //kalo ada yg nyari di hashdatabase keknya juga kemungkinan bisa ditembus kecil
		        $tempPath='/temporary/DigitalCollection/'.base64_encode(urlencode(sha1($addPath))).".".$format;
		        $temp=$aliasPath.$tempPath;

		        if (file_exists($realpath)) {
				copy($realpath, $temp);
				//chown($temp, 'www-data');
				//chmod($temp, 0777);

				}
    
				return $tempPath;


        		break;
 			case 2:
 			    
 			     $wName=$datas[0]['name'];
 			     $file=$datas[0]['FileFlash'];
 			     $format=$datas[0]['FormatFileFlash'];
 			     $addPath=$wName.'/'.str_replace(".rar","",str_replace(".zip","",$datas[0]['FileURL']));
 			     $realpath = Yii::getAlias('@uploaded_files') . '/dokumen_isi/'.$addPath;

 			    $aliasPath=Yii::getAlias('@uploaded_files');
 			    //di sha1 biar kalo di base64decode ga keliatan namafile dan folderworksheetnya.
		        //kalo ada yg nyari di hashdatabase keknya juga kemungkinan bisa ditembus kecil
 			    $tempPath='/temporary/DigitalCollection/'.base64_encode(urlencode(sha1($addPath)));
 			    $returnPath=$tempPath.'/'.$file;
        		$temp=$aliasPath.$tempPath;

		        if (file_exists($realpath) && !file_exists($temp)) {
				$source = $realpath;
				$dest= $temp;
		        mkdir($dest, 0755);
				foreach (
				 $iterator = new \RecursiveIteratorIterator(
				  new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
				  \RecursiveIteratorIterator::SELF_FIRST) as $item
				) {
				  if ($item->isDir()) {
				    mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
				  } else {
				    copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
				  }
				}
				//copy($realpath, $temp);
				//chown($temp, 'www-data');
				//chmod($temp, 0777);
				return $returnPath;
				}
				else{
				return $returnPath;
				}
 			    break;       	
 			return false;	
        }


 

    }
    

    
}
