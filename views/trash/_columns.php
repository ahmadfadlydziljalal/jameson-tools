<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'name',
        'format' => 'text',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'key',
        'format' => 'text',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'data',
        'format' => 'raw',
        'contentOptions' => [
            'class' => 'text-wrap',
        ],
        'value' => fn($model) => Html::tag('pre', VarDumper::dumpAsString(Json::decode($model->data), 2)),

    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'vAlign' => 'top',
        'template' => '{restore}{divider}{update}{view}{delete}',
        'buttons' => [
            'divider' =>function(){
                return  '<li><hr class="dropdown-divider"></li>';
            },
            'restore' => function ($url, $model) {
                return Html::a("<i class='bi bi-arrow-90deg-right'></i> Restore", $url, [
                    'class' => 'dropdown-item',
                    'data-method' => 'post',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to restore this item?'),
                ]);
            }
        ],
        'viewOptions' => [
            'label' => '<i class="bi bi-eye-fill"></i> View',
        ],
        'updateOptions' => [
            'label' => '<i class="bi bi-pencil"></i> Update',
        ],
        'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i> Delete',
            'class' => 'text-danger'
        ]
    ],
];   