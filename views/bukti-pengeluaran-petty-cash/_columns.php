<?php

/* @var $this View */

use app\models\base\BuktiPengeluaranPettyCash;
use yii\helpers\Html;
use yii\web\View;

?>
<?php

/* @var $this View */
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
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'reference_number',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'voucher',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Nomor JO',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if($model->jobOrderDetailCashAdvance){
                return $model->jobOrderDetailCashAdvance->jobOrder?->reference_number;
            }
            return $model->jobOrderBill->jobOrder->reference_number;

        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Vendor',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if($model->jobOrderDetailCashAdvance){
                return $model->jobOrderDetailCashAdvance?->vendor?->nama;
            }
            return $model->jobOrderBill->vendor->nama;

        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Kasbon',
        'contentOptions' => ['class' => 'text-end'],
        'format' => 'raw',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            if($model->jobOrderDetailCashAdvance){
                return $model->getStatusCashAdvance();
            }
            return '';
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Bill Payment',
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */
            return $model->jobOrderBill?->reference_number;
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'header' => 'Nominal',
        'contentOptions' => ['class' => 'text-end'],
        'format' => ['decimal', 2],
        'value' => function ($model) {
            /** @var app\models\BuktiPengeluaranPettyCash $model */

            if($model->jobOrderDetailCashAdvance){
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
                if($model->jobOrderDetailCashAdvance){
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-petty-cash/update-by-cash-advance', 'id' => $model->id]);
                }

                # Bill Payment
                return Html::a('<i class="bi bi-pencil"></i>', ['bukti-pengeluaran-petty-cash/update-by-bill', 'id' => $model->id]);
            },
            'delete' => function ($url, $model) {
                /* @var BuktiPengeluaranPettyCash $model */
                /* @see \app\controllers\BuktiPengeluaranPettyCashController::actionDeleteByCashAdvance() */

                # Kasbon / Cash Advance
                if($model->jobOrderDetailCashAdvance){
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
                return Html::a('<i class="bi bi-printer"></i>', $url,[
                    'target' => '_blank',
                    'data-pjax' => '0',
                ]);
            }

        ]
    ],
];   