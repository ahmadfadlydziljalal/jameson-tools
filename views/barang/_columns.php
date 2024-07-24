<?php

/* @var $this \yii\web\View */
?>
<?php

use kartik\grid\SerialColumn;

return [
    [
        'class' => SerialColumn::class,
        'contentOptions' => [
            'class' => 'align-middle text-end'
        ],
    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'detail' => function ($model, $key, $index, $column) {
            return $this->context->renderPartial('_item', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nama',
        'format' => 'text',
        'contentOptions' => [
            'class' => 'text-nowrap'
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'price_per_item_in_idr',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-nowrap text-end'
        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'options' => ['style' => 'width:2px;'],
        'contentOptions' => [
            'class' => 'text-nowrap'
        ],
    ],
];   