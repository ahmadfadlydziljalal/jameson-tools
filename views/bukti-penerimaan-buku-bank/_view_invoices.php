<?php

/* @var $this View */
/* @var $model BuktiPenerimaanBukuBank|string|ActiveRecord */

use app\models\BuktiPenerimaanBukuBank;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

echo GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $model->getInvoices(),
        'sort' => false,
        'pagination' => false,
    ]),
    'layout' => "{items}",
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
            'attribute' => 'customer_id',
            'value' => fn($model) => $model->customer->nama
        ],
        'tanggal_invoice:date',
        [
            'class' => DataColumn::class,
            'attribute' => 'total',
            'format' => ['decimal', 2],
            'contentOptions' => [
                'style' => 'text-align:right',
            ],
            'pageSummary' => true
        ],

    ],
    'showPageSummary' => true
]);

?>