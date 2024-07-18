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
        'attribute' => 'nomorVoucher',
        'format' => 'text',
        'value' => 'bukuBank.nomor_voucher'
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
                $string = $element['jobOrder'];
                if(isset($element['reference_number']) AND $element['reference_number']){
                    $string .= ' / ' . $element['reference_number'];
                }
                return Html::tag('span', $string, ['class' => 'badge rounded-pill text-bg-primary']);
            } , $model->referensiPembayaran['data']);

            return implode(' ', $map);
        },
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
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'referensiPembayaran',
        'format' => 'raw',
        'value' => function ($model) {
           return Html::tag('pre', \yii\helpers\VarDumper::dumpAsString($model->referensiPembayaran));
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
    ],*/
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
        'class' => 'kartik\grid\ActionColumn',
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

                if($model->jobOrderDetailPettyCash){
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-buku-bank/update-by-petty-cash', 'id' => $model->id]);
                }
                return '';
            },
            'delete' => function ($url, $model) {
                if ($model->jobOrderDetailCashAdvances) {
                    return Html::a('<i class="bi bi-trash"></i>', ['bukti-pengeluaran-buku-bank/delete-by-cash-advance', 'id' => $model->id],[
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'class'=>'text-danger',
                    ]);
                }

                return Html::a('<i class="bi bi-trash"></i>', ['bukti-pengeluaran-buku-bank/delete', 'id' => $model->id],[
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'class'=>'text-danger',
                ]);
            }
        ]
    ],
];   