<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\MemberSearch $searchModel
 */

$this->title = Yii::t('app', 'Profil Anggota');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-2">
<?php

$memberID = $model->ID;

$imgCheck = Yii::getAlias('@uploaded_files') . '/'.Yii::$app->params['pathFotoAnggota'].'/temp/' . $memberID . '.jpg';

if (!file_exists($imgCheck)) {
    // No.Photo
    $image = '../../uploaded_files/'.Yii::$app->params['pathFotoAnggota'].'/temp/nophoto.jpg?timestamp=' . rand();
}else{
    $image = '../../uploaded_files/'.Yii::$app->params['pathFotoAnggota'].'/temp/'. $memberID .'.jpg?timestamp=' . rand();
}

?>
  <img class="img-thumbnail" src="<?=$image?>" alt="User Profile Photo">

</div>
<div class="col-md-10">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td class="col-md-2" style="font-weight: bold">No.Anggota</td>
                <td class="col-md-1">:</td>
                <td><?=$model->MemberNo?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Nama Lengkap</td>
                <td class="col-md-1">:</td>
                <td><?=$model->Fullname?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">No.Identitas</td>
                <td class="col-md-1">:</td>
                <td><?=$model->identityType->Nama?>,<?=$model->IdentityNo?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Nama Ibu Kandung</td>
                <td class="col-md-1">:</td>
                <td><?=$model->MotherMaidenName?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Alamat Email</td>
                <td class="col-md-1">:</td>
                <td><?=$model->Email?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Tempat,Tgl.Lahir</td>
                <td class="col-md-1">:</td>
                <td><?=$model->PlaceOfBirth?>,<?=$model->DateOfBirth?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Alamat Tinggal Sesuai Identitas</td>
                <td class="col-md-1">:</td>
                <td><?=$model->Address?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Alamat Tinggal Saat Ini</td>
                <td class="col-md-1">:</td>
                <td><?=$model->AddressNow?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Nomor HP</td>
                <td class="col-md-1">:</td>
                <td><?=$model->NoHp?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Nomor Telepon Rumah</td>
                <td class="col-md-1">:</td>
                <td><?=$model->Phone?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Jenis Anggota</td>
                <td class="col-md-1">:</td>
                <td><?=$model->jenisAnggota->jenisanggota?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Pendidikan Terakhir</td>
                <td class="col-md-1">:</td>
                <td><?=$model->educationLevel->Nama?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Agama</td>
                <td class="col-md-1">:</td>
                <td><?=$model->agama->Name?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Jenis Kelamin</td>
                <td class="col-md-1">:</td>
                <td><?=$model->sex->Name?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Pekerjaan</td>
                <td class="col-md-1">:</td>
                <td><?=$model->job->Pekerjaan?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Status Perkawinan</td>
                <td class="col-md-1">:</td>
                <td><?=$model->maritalStatus->Nama?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Nama Institusi</td>
                <td class="col-md-1">:</td>
                <td><?=$model->InstitutionName?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Alamat Institusi</td>
                <td class="col-md-1">:</td>
                <td><?=$model->InstitutionAddress?></td>
            </tr>
            <tr>
                <td class="col-md-3" style="font-weight: bold">Telepon Institusi</td>
                <td class="col-md-1">:</td>
                <td><?=$model->InstitutionPhone?></td>
            </tr>
        </tbody>
    </table>
</div>
