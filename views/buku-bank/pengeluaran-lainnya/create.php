<?php

/* @var $this yii\web\View */
/* @var $kodeVoucher app\models\KodeVoucher */
/* @var $model app\models\BukuBank */
/* @see \app\controllers\BukuBankController::actionCreateByPengeluaranLainnya() */
/* @var $modelTransaksiLainnya \app\models\TransaksiBukuBankLainnya */

use yii\helpers\Html;

$this->title = 'Tambah Buku Bank Pengeluaran Lainnya: ' . $kodeVoucher->singkatan;
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="buku-bank-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'modelTransaksiLainnya' => $modelTransaksiLainnya,
    ]) ?>
</div>
