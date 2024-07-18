<?php

/* @var $this yii\web\View */

/* @var $model app\models\BukuBank */

use app\models\BukuBank;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'options' => [
        'class' => 'table table-bordered table-detail-view'
    ],
    'attributes' => [
        [
            'attribute' => 'kode_voucher_id',
            'value' => $model->kodeVoucher->singkatan . ' ' . $model->kodeVoucher->name
        ],
        [
            'attribute' => 'bukti_penerimaan_buku_bank_id',
            'value' => function ($model) {

                if($model->buktiPenerimaanBukuBank){
                    return  $model->buktiPenerimaanBukuBank->reference_number;
                }

                if($model->transaksiBukuBankLainnya and $model->transaksiBukuBankLainnya->jenis_pendapatan_id){
                    return 'Transaksi lainnya';
                }
                return '';
            }
        ],
        [
            'attribute' => 'bukti_pengeluaran_buku_bank_id',
            /*'value' => $model->buktiPengeluaranBukuBank?->reference_number*/
            'value' => function ($model) {

                if($model->buktiPengeluaranBukuBank){
                    return  $model->buktiPengeluaranBukuBank->reference_number;
                }

                if($model->transaksiBukuBankLainnya and $model->transaksiBukuBankLainnya->jenis_biaya_id){
                    return 'Transaksi lainnya';
                }
                return '';
            }
        ],
        [
            'attribute' => 'mutasiKas',
            'value' => $model->buktiPenerimaanPettyCash?->mutasiKasPettyCash?->nomor_voucher
        ],
        'nomor_voucher',
        'tanggal_transaksi:date',
        'keterangan:ntext',
    ],
]);
