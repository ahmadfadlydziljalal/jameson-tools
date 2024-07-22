<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPenerimaanPettyCash|string|\yii\db\ActiveRecord */

use yii\widgets\DetailView;

?>
<div class="">
    <p><strong>Mutasi Buku Bank</strong></p>
    <?= DetailView::widget([
        'model' => $model->bukuBank,
        'attributes' => [
            [
                'attribute' => 'bank',
                'value' => $model->bukuBank->buktiPengeluaranBukuBank->rekeningSaya->nama_bank
            ],
            'nomor_voucher',
            'tanggal_transaksi:date',
            [
                'attribute' => 'bukti_pengeluaran_buku_bank_id',
                'value' => $model->bukuBank->buktiPengeluaranBukuBank->reference_number . ' '
            ],
            [
                'attribute' => 'jobOrder',
                'value' => $model->bukuBank->buktiPengeluaranBukuBank->jobOrderDetailPettyCash->jobOrder->reference_number

            ],

        ]
    ]) ?>
</div>