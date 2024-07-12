<?php

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */

/* @var $index int */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

?>

<div class="card mb-4 border-1 item">

    <div class="card-header border-bottom text-bg-info">
        <strong>
            <?= ($index + 1) . '. ' . StringHelper::basename(get_class($model)) ?>
        </strong>
    </div>

    <div class="card-body">
        <?php
        try {
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id',
                    // 'claim_petty_cash_id',
                    'nomor',
                    [
                        'attribute' => 'vendor_id',
                        'value' => $model->vendor->nama
                    ],
                    'tanggal_nota:date'
                ],
            ]);
        } catch (Throwable $e) {
            echo $e->getTraceAsString();
        }
        ?>
    </div>

    <?php try {
        echo GridView::widget([
            'panel' => false,
            'bordered' => false,
            'striped' => false,
            'headerContainer' => [],
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getClaimPettyCashNotaDetails(),
                'sort' => false,
                'pagination' => false
            ]),
            'tableOptions' => [
                'class' => 'mb-0'
            ],
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => [
                        'style' => [
                            'width' => '2px'
                        ]
                    ],
                ],
                // [
                // 'class'=>'\yii\grid\DataColumn',
                // 'attribute'=>'id',
                // ],
                // [
                // 'class'=>'\yii\grid\DataColumn',
                // 'attribute'=>'claim_petty_cash_nota_id',
                // ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'tipePembelian',
                    'value' => 'namaTipePembelian'
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'barang_id',
                    'value' => 'barang.nama'
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'description',
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'quantity',
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'satuan_id',
                    'value' => 'satuan.nama'
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'harga',
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
            ]
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>


</div>