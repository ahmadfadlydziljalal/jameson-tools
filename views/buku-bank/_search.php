<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\BukuBankSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="buku-bank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_voucher_id') ?>

    <?= $form->field($model, 'bukti_penerimaan_buku_bank_id') ?>

    <?= $form->field($model, 'bukti_pengeluaran_buku_bank_id') ?>

    <?= $form->field($model, 'nomor_voucher') ?>

    <?php // echo $form->field($model, 'tanggal_transaksi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>