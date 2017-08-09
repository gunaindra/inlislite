<?php

/**
 * @author    Henry <alvin_vna@yahoo.com>
 * @copyright Copyright &copy; Perpustakaan Nasional Republik Indonesia, 2016
 * @version   1.0
 */

namespace common\components;

use yii\base\Component;
    
class SirkulasiComponent extends Component{

        // membuat variabel private untuk membuka dan menutup session
        private $session;

        // fungsi init akan dijalankan secara otomatis pada saat component dipanggil
        public function init(){

            // membuat objek yii session 
            $this->session = \Yii::$app->session;

            // cek apakah aplikasi sudah memiliki session sirkulasi atau belum
            if(!$this->session->has('sirkulasi')){
                // jika belum memiliki session sirkulasi, buat session baru dengan nilai awal berupa array
                $this->session->set('sirkulasi',[]);
            }

            if(!$this->session->has('sirkulasi-pengembalian')){
                // jika belum memiliki session sirkulasi, buat session baru dengan nilai awal berupa array
                $this->session->set('sirkulasi-pengembalian',[]);
            }

            if(!$this->session->has('sirkulasi-pengembalian-safe')){
                // jika belum memiliki session sirkulasi, buat session baru dengan nilai awal berupa array
                $this->session->set('sirkulasi-pengembalian-safe',[]);
            }

            if(!$this->session->has('sirkulasi-pelanggaran')){
                // jika belum memiliki session sirkulasi, buat session baru dengan nilai awal berupa array
                $this->session->set('sirkulasi-pelanggaran',[]);
            }


            // session untuk add item koleksi di sumbangan anggota.
            if(!$this->session->has('sumbangan')){
                $this->session->set('sumbangan',[]);
            }

            // buka session
            $this->session->open();  

        }


        // fungsi menambahkan data ke dalam session sumbangan-item
        public function addItemSumbangan($data){

            $temp = [];
            $sumbangan = $this->session->get('sumbangan');
            if (!empty($sumbangan)) {
                // buat variabel temporary untuk menampung data session sebelumnya
              $temp = $this->session->get('sumbangan');
            }

            $temp[count($temp)] = $data;
            // simpan kembali session
            $this->session->set('sumbangan', $temp);
        }

         public function getItemSumbangan(){
            return $this->session->get('sumbangan');
        }

        // fungsi destroy data session 
        public function removeItemSumbangan(){
            return $this->session->remove('sumbangan');  
        }


        public function checkItemSumbangan($ID){
                $item = $this->session->get('sumbangan');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['ID']) == trim($ID)){
                        return true;
                    }
                }
                return false;
            }     
        }




        // fungsi menambahkan data ke dalam session
        public function addItem($data){

            $temp = [];
            $sessionSumbangan = $this->session->get('sirkulasi');
            if (!empty($sessionSumbangan)) {
                // buat variabel temporary untuk menampung data session sebelumnya
              $temp = $this->session->get('sirkulasi');
            }

            $temp[count($temp)] = $data;
            // simpan kembali session
            $this->session->set('sirkulasi', $temp);

        }

        public function addItemPengembalian($data){

            $temp = [];
            $sessionGetPengembalian = $this->session->get('sirkulasi-pengembalian');
            if (!empty($sessionGetPengembalian)) {
                // buat variabel temporary untuk menampung data session sebelumnya
              $temp = $this->session->get('sirkulasi-pengembalian');
            }

            $temp[count($temp)] = $data;
            // simpan kembali session
            $this->session->set('sirkulasi-pengembalian', $temp);

        }

        public function addItemPengembalianSafe($data){

            $temp = [];
            $sessionPengembalianSafe = $this->session->get('sirkulasi-pengembalian-safe');
            if (!empty($sessionPengembalianSafe)) {
                // buat variabel temporary untuk menampung data session sebelumnya
              $temp = $this->session->get('sirkulasi-pengembalian-safe');
            }

            $temp[count($temp)] = $data;
            // simpan kembali session
            $this->session->set('sirkulasi-pengembalian-safe', $temp);

        }


         public function addItemPelanggaran($data){

            $temp = [];
            $pelanggaran = $this->session->get('sirkulasi-pelanggaran');
            if (!empty($pelanggaran)) {
                // buat variabel temporary untuk menampung data session sebelumnya
              $temp = $this->session->get('sirkulasi-pelanggaran');
            }

            $temp[count($temp)] = $data;
            // simpan kembali session
            $this->session->set('sirkulasi-pelanggaran', $temp);

        }




        public function checkItemPengembalian($noBarcode){
                $item = $this->session->get('sirkulasi-pengembalian');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['NomorBarcode']) == trim($noBarcode)){
                        return true;
                    }
                }
                return false;
            }     
        }

        public function checkItemPengembalianSafe($noBarcode){
                $item = $this->session->get('sirkulasi-pengembalian-safe');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['NomorBarcode']) == trim($noBarcode)){
                        return true;
                    }
                }
                return false;
            }     
        }


         public function checkItemPelanggaran($noBarcode){
                $item = $this->session->get('sirkulasi-pelanggaran');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['NomorBarcode']) == trim($noBarcode)){
                        return true;
                    }
                }
                return false;
            }     
        }

        public function checkMemberPengembalian($id){
                $item = $this->session->get('sirkulasi-pengembalian');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['MemberID']) == trim($id)){
                        return true;
                    }
                }
                return false;
            }     
        }

        public function checkItem($noBarcode){
                $item = $this->session->get('sirkulasi');
                if (count($item) > 0) {
                  foreach ($item as $row) {
                    if(trim($row['NomorBarcode']) == trim($noBarcode)){
                        return true;
                    }
                }
                return false;
            }     
        }

        

        // fungsi mendapatkan data session 

        public function getItem(){
            return $this->session->get('sirkulasi');
        }

        public function getItemPengembalian(){
            return $this->session->get('sirkulasi-pengembalian');
        }

        public function getItemPengembalianSafe(){
            return $this->session->get('sirkulasi-pengembalian-safe');
        }

        public function getItemPelanggaran(){
            return $this->session->get('sirkulasi-pelanggaran');
        }

        // fungsi destroy data session 
        public function remove(){
            return $this->session->remove('sirkulasi');  
        }

        public function removePengembalian(){
            return $this->session->remove('sirkulasi-pengembalian');  
        }

        public function removePengembalianSafe(){
            return $this->session->remove('sirkulasi-pengembalian-safe');  
        }

        public function removePelanggaran(){
            return $this->session->remove('sirkulasi-pelanggaran');  
        }

}

?>