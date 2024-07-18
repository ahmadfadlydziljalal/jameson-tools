<?php

/* @var $this yii\web\View */
/* @var $kodeVoucher app\models\KodeVoucher */
/* @var $model app\models\MutasiKasPettyCash */
/* @see \app\controllers\BukuBankController::actionUpdateByPenerimaanLainnya() */
/* @var $modelTransaksiLainnya app\models\TransaksiBukuBankLainnya */

use yii\helpers\Html;

$this->title = 'Update Buku Bank Penerimaan Lainnya: ' . $kodeVoucher->singkatan;
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor_voucher, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="buku-bank-penerimaan-lainnya-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'modelTransaksiLainnya' => $modelTransaksiLainnya,
    ]) ?>
</div>
