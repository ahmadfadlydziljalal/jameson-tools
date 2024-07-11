<?php

/* @var $this View */

/*
 * Vendor
 * Reference number
 * Total
 * */

use kartik\grid\ActionColumn;
use kartik\grid\ExpandRowColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
    ],
    [
        'class' => ExpandRowColumn::class,
        'detailUrl' => Url::to(['job-order/view-bill-detail']),
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'header' => 'Bukti Pengeluaran',
        'value' => function($model) {
            /** @var \app\models\JobOrderBill $model */
            return $model->buktiPengeluaranPettyCashBill?->buktiPengeluaranPettyCash?->reference_number;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vendor_id',
        'value'=>'vendor.nama',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'reference_number',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'total',
        'value'=> function($model){
            /** @var app\models\JobOrderBill $model */
            return $model->getTotalPrice();
        },
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
        'class'=> ActionColumn::class,
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<i class="bi bi-pen"></i>', ['job-order/update-bill', 'id' => $model->id]);
            },
            'delete' => function ($url, $model) {

                /** @see \app\controllers\JobOrderController::actionDeleteBill() */
                return Html::a('<i class="bi bi-trash"></i>', ['delete-bill', 'id' => $model->id], [
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                        'pjax' => '0',
                    ],
                    'class'=>'text-danger',
                ]);
            }
        ]
    ]


];