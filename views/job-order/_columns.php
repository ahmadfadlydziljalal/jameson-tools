<?php

/* @var $this \yii\web\View */

use yii\bootstrap5\Html;

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
        'format' => 'raw',
        'value' => function ($model) {
            $string = Html::tag('span', $model->reference_number);
            if ($model->is_for_petty_cash) {
                $string .=  ' ' . Html::tag('span', 'PC', ['class' => 'badge rounded-pill text-bg-info']);
            }
            return $string;
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'main_vendor_id',
        'format' => 'text',
        'value' => 'mainVendor.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'main_customer_id',
        'format' => 'text',
        'value' => 'mainCustomer.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalKasbonRequest',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end'],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalPanjarCashAdvance',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end'],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalBill',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end'],
    ],
    /*[
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'keterangan',
        'format'=>'ntext',
    ],*/
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
                return Html::a('<i class="bi bi-printer"></i>', ['export-to-pdf', 'id' => $model->id], [
                    'data-pjax' => '0',
                    'target' => '_blank',
                ]);
            }
        ],
        'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i>',
            'class' => 'text-danger',
            'title' => 'Delete',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
            'data-pjax' => '0'
        ],
    ],
];   