<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPenerimaanBukuBank */

?>

<div class="content-section">
    <h1 class="text-center">Bukti Penerimaan Buku Bank</h1>
    <div>
        Reference: <?= $model->reference_number ?>
        <?php if($model->bukuBank): ?>
            <h2><?= $model->bukuBank->nomor_voucher ?></h2>
        <?php endif ?>
    </div>

    <?php if ($model->invoices) {
        echo $this->render('_view_invoices', [
            'model' => $model,
        ]);
    } ?>

    <?php
    if ($model->setoranKasirs) {
        echo $this->render('_view_setoran_kasir', [
            'model' => $model,
        ]);
    }
    ?>

</div>
