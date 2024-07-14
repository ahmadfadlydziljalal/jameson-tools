<?php

/** @var $this yii\web\View */

/** @var Invoice $model */

use app\models\Invoice;
use yii\bootstrap5\Html;
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
        'attribute' => 'customer_id',
        'format' => 'text',
        'value' => 'customer.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tanggal_invoice',
        'format' => 'date',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomor_rekening_tagihan_id',
        'format' => 'text',
        'value' => fn($model) => StringHelper::truncate($model->nomorRekeningTagihan->atas_nama, 20)
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
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
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'target' => '_blank'
                ]);
            },
        ],
        'viewOptions' => [
            'label' => '<i class="bi bi-eye-fill"></i>',
            'title' => 'View',
        ],
        'updateOptions' => [
            'label' => '<i class="bi bi-pencil-fill"></i>',
            'title' => 'Update',

        ],
        'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i>',
            'class' => 'text-danger',
            'title' => 'Delete',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
        ],
    ],
];   