<?php

/* @var $this \yii\web\View */
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
        'attribute' => 'card_id',
        'format' => 'text',
        'value' => 'card.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'saldo_awal',
        'format' => 'currency',
        'contentOptions' => ['class' => 'text-end'],
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