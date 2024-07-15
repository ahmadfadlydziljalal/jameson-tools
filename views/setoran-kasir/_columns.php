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
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'reference_number',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_setoran',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'cashier_id',
        'format'=>'text',
        'value'=> 'cashier.name'
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'staff_name',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'total',
        'format'=>['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end'
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