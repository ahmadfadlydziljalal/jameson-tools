<?php

/* @var $this \yii\web\View */
?>
<?php

use app\components\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Json;

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
        'attribute' => 'card_id',
        'format' => 'raw',
        'value' => 'card.nama',
        'filter' => \app\models\Card::find()->map()
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