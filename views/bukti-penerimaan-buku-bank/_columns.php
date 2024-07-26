<?php

/* @var $this View */

use app\models\BuktiPenerimaanBukuBank;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\helpers\Html;
use yii\web\View;

?>
<?php
/** @var BuktiPenerimaanBukuBank $model */
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_transaksi_transfer',
        'format' => 'date',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomorVoucher',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->bukuBank) {
                return $model->bukuBank->nomor_voucher;
            }

            return Html::a('Register it!', ['bukti-penerimaan-buku-bank/register-to-buku-bank', 'id' => $model->id], [
                'data-pjax' => '0',
                'data-confirm' => 'Are you sure you want to register ' . $model->reference_number . ' to Buku Bank?',
                'data-method' => 'post',
            ]);
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'customer_id',
        'value' => 'customer.nama',
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
        'attribute' => 'rekening_saya_id',
        'format' => 'text',
        'value' => fn($model) => $model->rekeningSaya?->nama_bank,
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
    //    [
    //        'class' => '\yii\grid\DataColumn',
    //        'attribute' => 'jenis_transfer_id',
    //        'format' => 'text',
    //        'value' => 'jenisTransfer.name',
    //    ],
    //    [
    //        'class' => '\yii\grid\DataColumn',
    //        'attribute' => 'nomor_transaksi_transfer',
    //        'format' => 'text',
    //    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'tanggal_transaksi_transfer',
    // 'format'=>'date',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'tanggal_jatuh_tempo',
    // 'format'=>'date',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'keterangan',
    // 'format'=>'ntext',
    // ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'sumberDana',
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jumlahSeharusnya',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'contentOptions' => [
            'class' => 'd-none d-lg-table-cell ',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jumlah_setor',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'contentOptions' => [
            'class' => '',
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'balance',
        'format' => 'html',
        'value' => fn($model) => $model->getBalance(true),
    ],


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
            'update' => function ($url, $model) {
                /** @var BuktiPenerimaanBukuBank $model */
                if ($model->invoices) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-penerimaan-buku-bank/update-for-invoices', 'id' => $model->id],);
                }
                if ($model->setoranKasirs) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-penerimaan-buku-bank/update-for-setoran-kasir', 'id' => $model->id],);
                }
                return '';
            },
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'data-pjax' => '0',
                    'target' => '_blank',
                ]);
            }
        ],


    ],
];   