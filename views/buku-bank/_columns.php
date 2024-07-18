<?php

/* @var $this View */

use yii\bootstrap5\Html;
use yii\helpers\VarDumper;
use yii\web\View;

?>
<?php
return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
        // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'id',
        // 'format'=>'text',
    // ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'nomor_voucher',
        'format'=>'text',
    ],
    /*[
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'kode_voucher_id',
        'format'=>'text',
    ],*/
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_transaksi',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_penerimaan_buku_bank_id',
        'value'=>'buktiPenerimaanBukuBank.reference_number',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_pengeluaran_buku_bank_id',
        'value'=>'buktiPengeluaranBukuBank.reference_number',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'mutasiKas',
        'value'=>'buktiPenerimaanPettyCash.mutasiKasPettyCash.nomor_voucher',
    ],

    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'businessProcess',
        'contentOptions'=>[
            'class' => 'small'
        ],
        'format'=>'raw',
        'value' => function ($model, $key, $index, $column) {
            return \yii\helpers\Html::tag('pre', VarDumper::dumpAsString($model->businessProcess));
        }
    ],


    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'keterangan',
        // 'format'=>'ntext',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url,[
                   'target'=>'_blank',
                ]);
            },
            'update' => function ($url, $model) {
                /** @var app\models\BukuBank $model */

                # Dengan bukti penerimaan buku bank
                if($model->bukti_penerimaan_buku_bank_id){
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-penerimaan-buku-bank', 'id' => $model->id]);
                }

                # Dengan penerimaan lainnya
                if($model->transaksiBukuBankLainnya and $model->transaksiBukuBankLainnya->jenis_pendapatan_id){
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-penerimaan-lainnya', 'id' => $model->id]);
                }

                # Dengan bukti pengeluaran buku bank
                if($model->bukti_pengeluaran_buku_bank_id){

                    # With mutasi kas
                    if($model->buktiPengeluaranBukuBank->jobOrderDetailPettyCash){
                        return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-pengeluaran-buku-bank-to-mutasi-kas', 'id' => $model->id]);
                    }
                    # otherwise Without mutasi kas
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-pengeluaran-buku-bank', 'id' => $model->id]);
                }

                # TODO dengan pengeluaran lainnya

                return '';
            }
        ]
    ],
];   