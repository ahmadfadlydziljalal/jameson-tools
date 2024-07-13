<?php

use app\models\MutasiKasPettyCash;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model MutasiKasPettyCash|string|ActiveRecord */
?>

<div class="mutasi-kas-petty-cash-bukti-pengeluaran-view">

    <h2>Bukti Pengeluaran: <?= $model->businessProcess ?></h2>

    <?php
    $attributes = [];
    if($model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance){
        $attributes = [
            [
                'attribute' => 'reference_number',
                'value' => $model->buktiPengeluaranPettyCash->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'job_order',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->jobOrder->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'kasbon',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->order,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right',
                ],
            ],
            [
                'attribute' => 'vendor',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->vendor->nama,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'jenis_biaya',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->jenisBiaya->name,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'Nominal',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->cash_advance,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right',
                ],
                'format' => ['decimal', 2],
            ],
        ];
    }

    if($model->buktiPengeluaranPettyCash->jobOrderBill){
        $attributes = [
            [
                'attribute' => 'reference_number',
                'value' => $model->buktiPengeluaranPettyCash->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'job_order',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderBill->jobOrder->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'nomor_tagihan',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderBill->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'vendor',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderBill->vendor->nama,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'total_bill',
                'value' => $model->buktiPengeluaranPettyCash->jobOrderBill->getTotalPrice(),
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right',
                ],
            ],
        ];
    }
    ?>

    <?php echo DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered table-detail-view'
        ],
        'attributes' => $attributes
    ]); ?>
</div>
