<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KodeVoucher */
/* @see app\controllers\KodeVoucherController::actionUpdate() */

$this->title = 'Update Kode Voucher: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kode Voucher', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="kode-voucher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>