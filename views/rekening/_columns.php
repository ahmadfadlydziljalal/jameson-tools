<?php

/* @var $this View */

use app\models\Card;
use kartik\grid\GridViewInterface;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'card_id',
        'format' => 'raw',
        'value' => 'card.nama',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->card_id)
                ? Card::findOne($searchModel->card_id)->nama
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
        'attribute' => 'nama_bank',
        'contentOptions' => [
            'class' => 'text-wrap'
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomor_rekening',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'saldo_awal',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'atas_nama',
        'format' => 'nText',
        'contentOptions' => [
            'class' => 'text-wrap'
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