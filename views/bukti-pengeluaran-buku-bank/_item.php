<?php

/** @var $model app\models\BuktiPengeluaranBukuBank */

use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

?>

<div class="card bg-transparent">
    <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
        <p class="m-0"><?= $model->reference_number ?></p>
        <div>
            <i class="bi bi-person"></i> Delete
        </div>
    </div>
    <div class="card-body">
        <?= $model->tanggal_transaksi ?>

        <?php

        if ($model->bukuBank) {
            echo $model->bukuBank->nomor_voucher;
        }

        echo Html::a('Register it!', ['bukti-pengeluaran-buku-bank/register-to-buku-bank', 'id' => $model->id], [
            'data-pjax' => '0',
            'data-confirm' => 'Are you sure you want to register ' . $model->reference_number . ' to Buku Bank?',
            'data-method' => 'post',
        ]);

        ?>

        <?= $model->vendor->nama ?>
        <?= $model->jenisTransfer->name ?>
        <?= $model->tujuanBayar ?>
        <?= $model->totalBayar ?>

        <pre>
            <?= VarDumper::dumpAsString($model->referensiPembayaran) ?>
        </pre>
    </div>

</div>
