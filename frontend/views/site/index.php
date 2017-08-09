<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Portal Aplikasi Inlis Lite';
?>

<div class="container">
    <div class="row">

    <center>
        <?= yii\helpers\Html::img(Url::base().'/'.Url::to('uploaded_files/aplikasi/inlislite.png'), ['alt'=>'Portal Aplikasi Inlis Lite', 'class'=>'thing', 'style' => 'width:45%;']) ?>

        <p>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('backend')?>"> Back Office</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('bacaditempat')?>"> Baca ditempat</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('guestbook')?>"> Buku Tamu</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('keanggotaan')?>"> Keanggotaan Online</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('digitalcollection')?>"> Layanan Koleksi Digital</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('opac')?>"> OPAC</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('pendaftaran')?>"> Pendaftaran Anggota</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('statistik-perkembangan-perpustakaan')?>"> Statistik</a>
            <a class="btn btn-primary btn3d" target="_blank" href="<?=Url::to('survey')?>"> Survey</a>
        </p>

     </center>
    </div>
</div>

<div class="site-index">
    <center>
        <div class="mediumtron">
             <p>
               
             </p>

        </div>
    </center>
    <div class="body-content">
    </div>
</div>
