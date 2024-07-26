<?php

/* @var $this View */

/** @var BuktiPengeluaranPettyCash $model */

use app\models\base\BuktiPengeluaranPettyCash;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\helpers\Html;
use yii\web\View;

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
        'attribute' => 'tanggal_transaksi',
        'format' => 'date',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomorJobOrder',
        'header' => 'Job Order',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if ($model->jobOrderDetailCashAdvance) {
                return $model->jobOrderDetailCashAdvance?->jobOrder?->reference_number;
            }
            return $model->jobOrderBill?->jobOrder->reference_number;
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomorVoucher',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->mutasiKasPettyCash) {
                return $model->mutasiKasPettyCash->nomor_voucher;
            }
            return Html::a('Register it!', ['bukti-pengeluaran-petty-cash/register-to-mutasi-kas', 'id' => $model->id], [
                'data-pjax' => '0',
                'data-confirm' => 'Are you sure you want to register ' . $model->reference_number . ' to Mutasi Kas?',
                'data-method' => 'post',
            ]);
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Business Process',
        'format' => 'raw',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if ($model->jobOrderDetailCashAdvance) {
                return $model->getStatusCashAdvance();
            }
            return "Bill : " . $model->jobOrderBill?->reference_number;
        }
    ],

    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Vendor',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if ($model->jobOrderDetailCashAdvance) {
                return $model->jobOrderDetailCashAdvance?->vendor?->nama;
            }
            return $model->jobOrderBill->vendor->nama;

        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Nominal',
        'contentOptions' => ['class' => 'text-end'],
        'format' => ['decimal', 2],
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */

            if ($model->jobOrderDetailCashAdvance) {
                return $model->jobOrderDetailCashAdvance?->cash_advance;
            }
            return $model->jobOrderBill?->getTotalPrice();

        },
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
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'update' => function ($url, $model) {
                /* @var BuktiPengeluaranPettyCash $model */
                /* @see \app\controllers\BuktiPengeluaranPettyCashController::actionUpdateByCashAdvance() */
                /* @see \app\controllers\BuktiPengeluaranPettyCashController::actionUpdateByBill() */
                # Kasbon / Cash Advance
                if ($model->jobOrderDetailCashAdvance) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-petty-cash/update-by-cash-advance', 'id' => $model->id]);
                }

                # Bill Payment
                return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-petty-cash/update-by-bill', 'id' => $model->id]);
            },
            'delete' => function ($url, $model) {
                /* @var BuktiPengeluaranPettyCash $model */
                /* @see \app\controllers\BuktiPengeluaranPettyCashController::actionDeleteByCashAdvance() */

                # Kasbon / Cash Advance
                if ($model->jobOrderDetailCashAdvance) {
                    return Html::a('<i class="bi bi-trash"></i>', ['bukti-pengeluaran-petty-cash/delete-by-cash-advance', 'id' => $model->id], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                        'class' => 'text-danger',
                    ]);
                }

                /* @see \app\controllers\BuktiPengeluaranPettyCashController::actionDeleteByBill() */
                return Html::a('<i class="bi bi-trash"></i>', ['bukti-pengeluaran-petty-cash/delete-by-bill', 'id' => $model->id], [
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                    'class' => 'text-danger',
                ]);
            },
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'target' => '_blank',
                    'data-pjax' => '0',
                ]);
            }

        ]
    ],
];   