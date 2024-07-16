<?php

/* @var $this View */

use app\models\JobOrderDetailCashAdvance;
use kartik\grid\ActionColumn;
use yii\bootstrap5\Html;
use yii\web\View;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'vAlign'=>'top',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'header' => 'Bukti Pengeluaran',
        'value' => function($model) {
            /** @var JobOrderDetailCashAdvance $model */
            return $model->buktiPengeluaranPettyCash?->reference_number;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'header' => 'Bukti Penerimaan',
        'value' => function($model) {
            /** @var JobOrderDetailCashAdvance $model */
            return $model->buktiPengeluaranPettyCash?->buktiPenerimaanPettyCash?->reference_number;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'vendor_id',
        'value' => 'vendor.nama',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'jenis_biaya_id',
        'value' => 'jenisBiaya.name',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'mata_uang_id',
        'value' => 'mataUang.kode',
        'contentOptions' => [
            'style' => 'width: 10px;'
        ]
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'kasbon_request',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end',
        ],
        'pageSummary' => true,
        'pageSummaryOptions' => [
            'class' => 'text-end',
        ]
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'cash_advance',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end',
        ],
        'pageSummary' => true,
        'pageSummaryOptions' => [
            'class' => 'text-end',
        ]
    ],

    [
        'class' => ActionColumn::class,
        'dropdown' => false,
        //'template' => '{payment}{update}{divider}{delete}',
        'template' => '{payment} {export-to-pdf} {update} {delete}',
        'contentOptions' => [
            'class' => 'text-nowrap',
        ],
        'buttons' => [
            'divider' => function () {
                return ' <li><hr class="dropdown-divider"></li>';
            },
//            'payment' => function ($url, $model) {
//                /** @var JobOrderDetailCashAdvance $model */
//                if($model->isPanjar()){
//                    return '';
//                }
//                return Html::button('<i class="bi bi-pass-fill"></i>', [
//                    'class' => 'btn btn-link mx-0 p-0',
//                    'data' => [
//                        'id' => $model->id,
//                        'bs-toggle' => 'modal',
//                        'bs-target' => '#modalPaymentKasbonForm'
//                    ]]
//                );
//            },
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', ['export-to-pdf-payment-cash-advance', 'id' => $model->id], [
                    'target' => '_blank',
                ]);
            },
            'update' => function ($url, $model) {
                if($model->isPanjar()){
                    return '';
                }
                return Html::a('<i class="bi bi-pencil"></i>', ['update-cash-advance', 'id' => $model->id], []);
            },
            'delete' => function ($url, $model) {
                if($model->isPanjar()){
                    return '';
                }
                /** @see \app\controllers\JobOrderController::actionDeleteCashAdvance() */
                return Html::a('<i class="bi bi-trash"></i>', ['delete-cash-advance', 'id' => $model->id], [
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                        'pjax' => '0',
                    ],
                    'class'=>'text-danger',
                ]);
            }

        ],
        /*'updateOptions' => [
            'label' => '<i class="bi bi-pencil-fill"></i> Update',
        ],
        'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i> Delete',
            'class' => 'text-danger',
            'title' => 'Delete',
        ],*/
    ]
];