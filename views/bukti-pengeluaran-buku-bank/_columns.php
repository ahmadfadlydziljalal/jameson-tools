<?php

/* @var $this yii\web\View */

use app\models\Card;
use app\models\JenisTransfer;
use kartik\grid\GridViewInterface;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

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
        'class' => '\kartik\grid\DataColumn',
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
        ],
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->vendor_id)
                ? Card::findOne($searchModel->vendor_id)->nama
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '100%',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to(['card/find-by-id']),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jenis_transfer_id',
        'format' => 'text',
        'value' => 'jenisTransfer.name',
        'filter' => JenisTransfer::find()->map()
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
            'class' => 'd-none d-lg-table-cell font-monospace',
            'style' => 'text-align:right',
        ],
        'headerOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ],
        'filterOptions' => [
            'class' => 'd-none d-lg-table-cell',
        ]
    ],

    /*
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
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'data-pjax' => '0',
                    'target' => '_blank',
                ]);
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