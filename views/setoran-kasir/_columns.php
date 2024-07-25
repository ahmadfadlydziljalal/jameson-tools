<?php

/* @var $this yii\web\View */
/** @var app\models\SetoranKasir $model */

use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;

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
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'reference_number',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tanggal_setoran',
        'format'=>'date',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cashier_id',
        'format'=>'text',
        'value'=> 'cashier.name',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => \app\models\Cashier::find()->map(),
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'allowClear' => true,
                'width' => '100%',
            ]
        ]
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'staff_name',
        'format'=>'text',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'buktiPenerimaanBukuBankReferenceNumber',
        'format' => 'html',
        'header' => 'Bukti Penerimaan',
        'value' => fn($model) => !$model->buktiPenerimaanBukuBank ? Html::tag('span', 'Belum ada', ['class' => 'badge bg-danger']) :
            $model->buktiPenerimaanBukuBank->reference_number
        ,
        'contentOptions' => [
            'class' => 'small'
        ]
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'total',
        'format'=>['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end font-monospace'
        ]
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
    ],
];   