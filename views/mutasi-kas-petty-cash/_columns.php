<?php

/* @var $this View */

use app\models\MutasiKasPettyCash;
use yii\helpers\Html;
use yii\web\View;

?>
<?php
/** @var MutasiKasPettyCash $model */
return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
        // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'id',
        // 'format'=>'text',
    // ],
    /*[
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'kode_voucher_id',
        'format'=>'text',
    ],*/
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'nomor_voucher',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_penerimaan_petty_cash_id',
        'format'=>'text',
        'value'=> 'buktiPenerimaanPettyCash.reference_number'
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_pengeluaran_petty_cash_id',
        'format'=>'text',
        'value'=> 'buktiPengeluaranPettyCash.reference_number'
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_mutasi',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'businessProcess',
        'contentOptions'=>[
            'class' => 'small'
        ],
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'cardName',
        'contentOptions'=>[
            'class' => 'small'
        ],
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'nominal',
        'format'=>['decimal',2],
        'contentOptions'=>['style'=>'text-align:right'],
    ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'keterangan',
        // 'format'=>'ntext',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'update' => function ($url, $model) {
                /** @var app\models\MutasiKasPettyCash $model */

                # 1. Debit penerimaan
                if($model->bukti_penerimaan_petty_cash_id){
                    return Html::a('<i class="bi bi-pencil"></i>', ['mutasi-kas-petty-cash/update-by-bukti-penerimaan-petty-cash', 'id' => $model->id]);
                }

                # 2. Credit pengeluaran
                if($model->bukti_pengeluaran_petty_cash_id){
                    return Html::a('<i class="bi bi-pencil"></i>', ['mutasi-kas-petty-cash/update-by-bukti-pengeluaran-petty-cash', 'id' => $model->id]);
                }

                # 3. Transaksi lainnya
                if($model->transaksiMutasiKasPettyCashLainnya){

                    # 3.1 Debit Penerimaan lainnya
                    if($model->transaksiMutasiKasPettyCashLainnya->jenis_pendapatan_id){
                        return Html::a('<i class="bi bi-pencil"></i>', ['mutasi-kas-petty-cash/update-by-penerimaan-lainnya', 'id' => $model->id]);
                    }

                    # 3.2 Pengeluaran lainnya
                    if($model->transaksiMutasiKasPettyCashLainnya->jenis_biaya_id){
                        return Html::a('<i class="bi bi-pencil"></i>', ['mutasi-kas-petty-cash/update-by-pengeluaran-lainnya', 'id' => $model->id]);
                    }

                }

                return '';
            },
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>' ,['mutasi-kas-petty-cash/export-to-pdf', 'id' => $model->id], [
                    'data-pjax' => '0',
                    'target' => '_blank',
                ]);
            }
        ],
        'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i>',
            'class' => 'text-danger',
            'title' => 'Delete',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
            'data-pjax' => '0'
        ],
    ],
];   