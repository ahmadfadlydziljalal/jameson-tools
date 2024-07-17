<?php

use app\models\User;
use kartik\dialog\Dialog;
use mdm\admin\components\Helper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Dialog::widget()
?>
<div class="invoice-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">

        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>

        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a('Buat Invoice Lainnya', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Export PDF', ['export-to-pdf', 'id' => $model->id], ['class' => 'btn btn-outline-primary', 'target' => '_blank']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>
    </div>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                'reference_number',
                [
                    'attribute' => 'customer_id',
                    'value' => $model->customer ? $model->customer->nama : '-',
                ],
                'tanggal_invoice:date',
                [
                    'attribute' => 'nomor_rekening_tagihan_id',
                    'value' => $model->nomorRekeningTagihan ? nl2br( $model->nomorRekeningTagihan->atas_nama): '-',
                    'format' => 'html',
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return User::findOne($model->created_by)->username ?? null;
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return User::findOne($model->updated_by)->username ?? null;
                    }
                ],
            ],
        ]);

        echo Html::tag('h2', 'Invoice Detail');
        echo !empty($model->invoiceDetails) ?
            GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $model->invoiceDetails
                ]),
                'columns' => [
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'invoice_id',
                    // ],
                    [
                        'class' => '\yii\grid\DataColumn',
                        'attribute' => 'quantity',
                    ],
                    [
                        'class' => '\yii\grid\DataColumn',
                        'attribute' => 'satuan_id',
                        'value' => fn ($model) => $model->satuan ? $model->satuan->nama : '-',
                    ],
                    [
                        'class' => '\yii\grid\DataColumn',
                        'attribute' => 'barang_id',
                        'value' => fn ($model) => $model->barang ? $model->barang->nama : '-',
                    ],
                    [
                        'class' => '\yii\grid\DataColumn',
                        'attribute' => 'harga',
                        'format' => ['decimal', 2],
                        'contentOptions' => ['class' => 'text-end'],
                    ],
                ]
            ]) :
            Html::tag("p", 'Invoice Detail tidak tersedia', [
                'class' => 'text-warning font-weight-bold p-3'
            ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>