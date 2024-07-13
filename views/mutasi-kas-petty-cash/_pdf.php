<?php

/* @var $this yii\web\View */
/* @var $model app\models\MutasiKasPettyCash */
/* @see \app\controllers\MutasiKasPettyCashController::actionExportToPdf() */
?>

<div class="content-section">
    <h1 class="text-center">Voucher Petty Cash</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Voucher</th>
                <th>Tanggal Mutasi</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $model->nomor_voucher ?></td>
                <td><?=Yii::$app->formatter->asDate( $model->tanggal_mutasi )?></td>
                <td style="text-align:right">
                   <span style="font-size:1.25em"><?= Yii::$app->formatter->asDecimal($model->nominal, 2) ?></span>
                </td>
            </tr>
        </tbody>
    </table>

    <p class="mb-0">Keterangan: <?= $model->keterangan ?></p>
    <?php if($model->bukti_penerimaan_petty_cash_id): ?>
        <?= $this->render('bukti-penerimaan/view',[
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if($model->bukti_pengeluaran_petty_cash_id): ?>
        <?= $this->render('bukti-pengeluaran/view',[
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if ($model->transaksiMutasiKasPettyCashLainnya): ?>
        <?php if ($model->transaksiMutasiKasPettyCashLainnya->jenis_pendapatan_id): ?>
            <?= $this->render('penerimaan-lainnya/view', [
                'model' => $model
            ]) ?>
        <?php endif; ?>

        <?php if ($model->transaksiMutasiKasPettyCashLainnya->jenis_biaya_id): ?>
            <?= $this->render('pengeluaran-lainnya/view', [
                'model' => $model
            ]) ?>
        <?php endif; ?>
    <?php endif; ?>

</div>
