<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @see app\controllers\BukuBankController::actionUpdateByBuktiPengeluaranBukuBankToMutasiKas() */

$this->title = 'Update Buku Bank With Mutasi Kas: ' . $model->nomor_voucher ;
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor_voucher, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="buku-bank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>