<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPenerimaanPettyCash */
/* @see \app\controllers\BuktiPenerimaanPettyCashController::actionExportToPdf() */
?>

<div class="content-section">
    <h1 class="text-center">Bukti Penerimaan Petty Cash</h1>
    <span>Reference: <?= $model->reference_number ?></span>

    <!-- Pengembalian / realisasi kasbon dari bukti pengeluaran -->
    <?php if ($model->buktiPengeluaranPettyCashCashAdvance) : ?>
        <?= $this->render('_view_bukti_pengeluaran_cash_cash_advance', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <!-- Mutasi Bank -->
    <?php if ($model->bukuBank) : ?>
        <?= $this->render('_view_mutasi_kas_bank', [
            'model' => $model
        ]) ?>
    <?php endif ?>


</div>
