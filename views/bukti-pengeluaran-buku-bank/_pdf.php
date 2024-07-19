<?php

/* @var $this View */

/* @var $model BuktiPengeluaranBukuBank */

use app\models\BuktiPengeluaranBukuBank;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="content-section">
    <h1 class="text-center">Bukti Pengeluaran Buku Bank</h1>
    <p>Reference: <?= $model->reference_number ?></p>

    <div style="width: 100%">

        <div style="width: 48%; float: left">
            <strong><?= $model->jenisTransfer->name ?></strong> dari : <?= nl2br($model->rekeningSaya->atas_nama) ?>
        </div>
        <div style="width: 48%; float: right">
            <strong>Ke: </strong><?= $model->vendor->nama ?>
            <?php if ($model->vendor_rekening_id):
                echo Html::tag('p', nl2br($model->vendorRekening->atas_nama));
            endif; ?>

            <p class="m-0"><strong>Nomor Transaksi</strong>: <?= $model->nomor_bukti_transaksi ?></p>
        </div>

        <div style="clear: both"></div>
    </div>


    <?php echo $this->render('_view_2', [
        'model' => $model,
    ]); ?>




</div>
