<?php



use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\base\PeraturanPeminjamanHari $model
 */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peraturan Peminjaman Haris'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peraturan-peminjaman-hari-view">
   <p> <a class="btn btn-warning" href="/inlislite/backend/gii">Kembali</a>        <a class="btn btn-primary" href="/inlislite/backend/gii/default/update?id=%24model-%3Eid">Koreksi</a>        <a class="btn btn-danger" href="/inlislite/backend/gii/default/delete?id=%24model-%3Eid" data-confirm="Apakah Anda yakin ingin menghapus item ini?" data-method="post">Hapus</a>    </p>



    <?= DetailView::widget([
            'model' => $model,
            
        'attributes' => [
            'DayIndex',
            'MaxPinjamKoleksi',
            'MaxLoanDays',
            'DendaTenorJumlah',
            'DendaTenorSatuan',
            'DendaPerTenor',
            'DendaTenorMultiply',
            'SuspendMember:boolean',
            'WarningLoanDueDay',
            'DaySuspend',
            'DayPerpanjang',
            'CountPerpanjang',
        ],
       
    ]) ?>

</div>
