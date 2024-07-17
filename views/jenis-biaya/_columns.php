<?php

/* @var $this yii\web\View */
/* @var $model app\models\JenisBiaya */

use app\enums\JenisBiayaCategoryEnum;
use yii\helpers\Inflector;

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
        'attribute' => 'name',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'description',
        'format' => 'ntext',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'category',
        'value' => function ($model) {

            return $model->category ?
                Inflector::camel2words(JenisBiayaCategoryEnum::tryFrom(intval($model->category))->name )
                : ' ';
        }
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