<?php

/* @var $this \yii\web\View */
/* @var $model app\models\BukuBank|string|\yii\db\ActiveRecord */

use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;

if (isset($model->businessProcess['data'][0])) {


    $columns = array_merge([['class' => SerialColumn::class]], array_keys($model->businessProcess['data'][0]));
    $columns = array_map(function ($el) {
        if ($el == 'total') {
            return [
                'class' => DataColumn::class,
                'attribute' => $el,
                'contentOptions' => [
                    'class' => 'text-end',
                ],
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'pageSummaryOptions' => [
                    'class' => 'text-end border-start-0'
                ]
            ];
        }
        return $el;
    }, $columns);

    echo GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->businessProcess['data'],
            'pagination' => false,
            'sort' => false,
        ]),
        'layout' => "{items}",
        'columns' => $columns,
        'showPageSummary' => true,
        'responsive' => false
    ]);
} else {

    $attributes = [];
    foreach ($model->businessProcess['data'] as $key => $value) {
        if (!is_numeric($value)) {
            $attributes[] = $key;
            continue;
        }
        $attributes[] = [
            'attribute' => $key,
            'value' => $value,
            'contentOptions' => ['class' => 'text-end'],
            'format' => ['decimal', 2],
        ];
    }
    echo DetailView::widget([
        'model' => $model->businessProcess['data'],
        'attributes' => $attributes
    ]);
}
