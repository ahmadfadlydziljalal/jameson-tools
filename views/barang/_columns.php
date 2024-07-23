<?php

use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\Originalitas;
use app\models\TipePembelian;
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
      'class' => 'yii\grid\ActionColumn',
      'contentOptions' => [
         'class' => 'text-nowrap'
      ],
   ],
];   