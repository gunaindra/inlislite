<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Requestcatalog $model
 */

$this->title = Yii::t('app', 'Create Requestcatalog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requestcatalogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requestcatalog-create">
    <div class="page-header">
        <h3>Usulan Koleksi</h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
