<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\JenisPerpustakaan $model
 */

$this->title = Yii::t('app', 'Tambah Jenis Perpustakaan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jenis Perpustakaans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-perpustakaan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
