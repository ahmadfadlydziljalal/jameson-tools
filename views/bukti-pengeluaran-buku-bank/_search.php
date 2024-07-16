<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\BuktiPengeluaranBukuBankSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bukti-pengeluaran-buku-bank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reference_number') ?>

    <?= $form->field($model, 'rekening_saya_id') ?>

    <?= $form->field($model, 'jenis_transaksi_id') ?>

    <?= $form->field($model, 'vendor_id') ?>

    <?php // echo $form->field($model, 'vendor_rekening_id') ?>

    <?php // echo $form->field($model, 'nomor_bukti_transaksi') ?>

    <?php // echo $form->field($model, 'tanggal_transaksi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>