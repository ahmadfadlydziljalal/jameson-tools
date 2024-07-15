<?php

/* @var $this View */
/* @var $model BuktiPenerimaanBukuBank|string|ActiveRecord */

use app\models\BuktiPenerimaanBukuBank;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

echo Html::tag('p', 'Setoran Kasir');
echo GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $model->getSetoranKasirs(),
        'sort' => false,
        'pagination' => false,
    ]),
    'layout' => "{items}",
    'showPageSummary' => true,
    'columns' => [
        [
            'class' => SerialColumn::class
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'reference_number',
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'tanggal_setoran',
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'cashier.name',
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'staff_name',
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'total',
            'format' => ['decimal', 2],
            'contentOptions' => [
                'style' => 'text-align:right',
            ],
            'pageSummary' => true,
            'pageSummaryOptions' => [
                'style' => 'text-align:right',
            ]
        ],

    ]
]);