<?php



use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\Memberguesses $model
 */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Memberguesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberguesses-view">
   <p> <a class="btn btn-warning" href="/inlislite3/backend/gii">Kembali</a>        <a class="btn btn-primary" href="/inlislite3/backend/gii/default/update?id=%24model-%3Eid">Koreksi</a>        <a class="btn btn-danger" href="/inlislite3/backend/gii/default/delete?id=%24model-%3Eid" data-confirm="Apakah Anda yakin ingin menghapus item ini?" data-method="post">Hapus</a>    </p>



    <?= DetailView::widget([
            'model' => $model,
            
        'attributes' => [
            'NoAnggota',
            'Nama',
            'Status_id',
            'MasaBerlaku_id',
            'Profesi_id',
            'PendidikanTerakhir_id',
            'JenisKelamin_id',
            'Alamat',
            'Deskripsi',
            'LOCATIONLOANS_ID',
            'Location_Id',
            'TujuanKunjungan_Id',
            'Information',
            'NoPengunjung',
        ],
       
    ]) ?>

</div>
