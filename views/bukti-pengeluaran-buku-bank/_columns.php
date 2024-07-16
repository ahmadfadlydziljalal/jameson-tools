<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\StringHelper;

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
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'reference_number',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama',
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'rekening_saya_id',
        'format' => 'text',
        'value' => fn($model) => StringHelper::truncate($model->rekeningSaya?->atas_nama, 20),
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],*/
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tujuanBayar',
        'format' => 'text',
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell text-wrap',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'referensiPembayaran',
        'format' => 'raw',
        'value' => function ($model) {
            $map = array_map(function($element){
                return Html::tag(
                    'span',
                    $element['jobOrder'] . ' - ' . $element['reference_number'],
                    ['class' => 'badge rounded-pill text-bg-primary']
                );
            } , $model->referensiPembayaran);
            return implode(' ', $map);
        },
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'referensiPembayaran',
        'format' => 'raw',
        'value' => fn($model) => Html::tag('pre', \yii\helpers\VarDumper::dumpAsString($model->referensiPembayaran)),
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],*/
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalBayar',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell',
            'style' => 'text-align:right',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jenis_transfer_id',
        'format' => 'text',
    ],

    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_rekening_id',
        'format' => 'text',
    ],*/
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'nomor_bukti_transaksi',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'tanggal_transaksi',
    // 'format'=>'date',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'keterangan',
    // 'format'=>'ntext',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'created_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'created_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return '';
            },
            'update' => function ($url, $model) {

                /** @var app\models\BuktiPengeluaranBukuBank $model */
                if ($model->jobOrderDetailCashAdvances) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-buku-bank/update-by-cash-advance', 'id' => $model->id]);
                }

                if ($model->jobOrderBills) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-buku-bank/update-by-bill', 'id' => $model->id]);
                }
                return $model->id;
            }
        ]
    ],
];   