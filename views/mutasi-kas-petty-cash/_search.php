<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\MutasiKasPettyCashSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mutasi-kas-petty-cash-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_voucher_id') ?>

    <?= $form->field($model, 'bukti_penerimaan_petty_cash_id') ?>

    <?= $form->field($model, 'bukti_pengeluaran_petty_cash_id') ?>

    <?= $form->field($model, 'nomor_voucher') ?>

    <?php // echo $form->field($model, 'tanggal_mutasi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>