<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Invoice */
/* @see \app\controllers\InvoiceController::actionExportToPdf() */

?>

<div class="content-section">
    <!-- Header -->
    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 69%">
            <p>Kepada Yth.<br/> <?= $model->customer->nama ?><br><?= $model->customer->alamat ?></p>
        </div>
        <div class="mb-1" style=" float: right; width: 30%">
            <p style="text-align: right">Jakarta, <?= Yii::$app->formatter->asDate($model->tanggal_invoice) ?></p>
        </div>
    </div>

    <table class="table table-detail-view table-borderless">
        <tbody>
            <tr>
                <td>Inv No.</td>
                <td>:</td>
                <td><?= $model->reference_number ?></td>
            </tr>
            <tr>
                <td>SO No.</td>
                <td>:</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Qty</th>
            <th>Sat</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var \app\models\InvoiceDetail $invoiceDetail */
            foreach ($model->invoiceDetails as $key => $invoiceDetail):?>
                <tr>
                    <td class="text-end"><?= ($key + 1) ?></td>
                    <td><?= $invoiceDetail->quantity ?></td>
                    <td><?= $invoiceDetail->satuan->nama ?></td>
                    <td><?= $invoiceDetail->barang->nama ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($invoiceDetail->harga, 2) ?></td>
                    <td class="text-end"><?= $invoiceDetail->jumlahHarga(true) ?></td>
                </tr>
            <?php endforeach; ?>
        
            <?php if(count($model->invoiceDetails) < 23): ?>
                <?php for ($i = 0; $i < (23 - count($model->invoiceDetails)); $i++) : ?>
                    <tr>
                        <td style="height:2em"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endfor; ?>
            <?php endif ?>
        </tbody>

        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-end">Total</td>
                <td class="text-end"><?= $model->getTotal(true) ?></td>
            </tr>
        </tfoot>

    </table>

    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 60%">
            <p>Terbilang:<br/><?= $model->spellOutTotal() ?></p>
            <div class="border-1 p-2">
                Mohon di transfer ke: <br>
                <?= nl2br($model->nomorRekeningTagihan->atas_nama )   ?>

            </div>
        </div>
        <div class="mt-3" style=" float: right; width: 30%;">
            <table class="table table-borderless" style="page-break-inside: avoid">
                <thead>
                <tr>
                    <td class="text-center">Hormat Kami</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center" style="height: 8em"></td>
                </tr>

                <tr>
                    <td class="text-center">
                        (
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        )
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
