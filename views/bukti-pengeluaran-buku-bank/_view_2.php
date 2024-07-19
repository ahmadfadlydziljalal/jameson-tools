<?php

/* @var $this View */
/* @var $model BuktiPengeluaranBukuBank|string|ActiveRecord */

use app\models\BuktiPengeluaranBukuBank;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;
?>

<div class="bukti-pengeluaran-buku-bank-view-referensi">
    <h2><?= $model->referensiPembayaran['businessProcess'] ?></h2>
    <?php
    $columns = array_merge([['class' => SerialColumn::class]], array_keys($model->referensiPembayaran['data'][0]));
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
    ?>
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->referensiPembayaran['data'],
            'pagination' => false,
            'sort' => false
        ]),
        'layout' => '{items}',
        'columns' => $columns,
        'showPageSummary' => true
    ]) ?>
</div>
