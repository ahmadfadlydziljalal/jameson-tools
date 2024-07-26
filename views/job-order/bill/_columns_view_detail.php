<?php

/* @var $this View */

use app\models\JobOrderBillDetail;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\web\View;

return [
    [
        'class' => SerialColumn::class,
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'quantity',
        'contentOptions' => [
            'class' => 'text-end'
        ],
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'satuan_id',
        'value' => 'satuan.nama',
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'name',
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'price',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end'
        ],
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'total',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end'
        ],
        'pageSummary' => true,
        'pageSummaryOptions' => [
            'class' => 'text-end',
        ],
        'value' => function ($model) {
            /** @var JobOrderBillDetail $model */
            return $model->getTotal();
        },
    ],
];