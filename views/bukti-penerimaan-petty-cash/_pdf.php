<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPenerimaanPettyCash */

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

</div>
