<?php

/* @var $this \yii\web\View */

use app\models\Card;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

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
            /** @var \app\models\JobOrder $model */
            $string = Html::tag('span', $model->reference_number);
            if ($model->jobOrderDetailPettyCash) {
                $string .=  ' ' . Html::tag('span', 'PC', ['class' => 'badge rounded-pill text-bg-info']);
            }
            return $string;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'main_vendor_id',
        'format' => 'text',
        'value' => 'mainVendor.nama',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->main_vendor_id)
                ? Card::findOne($searchModel->main_vendor_id)->nama
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'main_customer_id',
        'format' => 'text',
        'value' => 'mainCustomer.nama',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->main_customer_id)
                ? Card::findOne($searchModel->main_customer_id)->nama
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
        'attribute' => 'totalKasbonRequest',
        'format' => ['decimal', 2],
        'contentOptions' => function($model){
            return !empty($model->totalKasbonRequest) ? ['class' => 'text-end text-danger '] : ['class' => 'text-end '];
        },
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalPanjarCashAdvance',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end '],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalBill',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end '],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'totalPettyCash',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end '],
    ],
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