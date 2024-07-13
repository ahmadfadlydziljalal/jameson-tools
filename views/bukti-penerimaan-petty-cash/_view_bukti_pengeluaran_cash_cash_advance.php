<?php

use app\models\BuktiPenerimaanPettyCash;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model BuktiPenerimaanPettyCash|string|ActiveRecord */

?>

<div class="">
    <p><strong>Kasbon / Cash Advance</strong></p>
    <?= DetailView::widget([
        'model' => $model->buktiPengeluaranPettyCashCashAdvance,
        'attributes' => [
            [
                'attribute' => 'bukti_pengeluaran_id',
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'job_order_id',
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'jenis_biaya_id',
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'mata_uang_id',
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->mataUang->singkatan,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'kasbon_request',
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->kasbon_request,
                'contentOptions' => [
                    'class' => 'text-end'
                ],
            ],
            [
                'attribute' => 'cash_advance',
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance,
                'contentOptions' => [
                    'class' => 'text-end'
                ],
            ],
            [
                'attribute' => 'order',
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order,
                'contentOptions' => [
                    'class' => 'text-end'
                ],
            ],
        ]
    ]); ?>
</div>
