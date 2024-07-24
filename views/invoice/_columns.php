<?php

/** @var $this yii\web\View */

/** @var Invoice $model */

use app\models\Card;
use app\models\Invoice;
use app\models\Rekening;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'customer_id',
        'format' => 'text',
        'value' => 'customer.nama',
        'contentOptions' => [
            'class' => 'text-wrap'
        ],
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->customer_id)
                ? Card::findOne($searchModel->customer_id)->nama
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
        'attribute' => 'tanggal_invoice',
        'width' => '100px',
        'format' => 'date',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nomor_rekening_tagihan_id',
        'header' => 'Rekening',
        'width' => '100px',
        'format' => 'text',
        'value' => fn($model) => $model->nomorRekeningTagihan->nama_bank,
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => Rekening::find()->mapOnlyTokoSaya('nama_bank'),
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ]
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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'contentOptions' => [
            'class' => 'small'
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
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'vAlign' => 'top',
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