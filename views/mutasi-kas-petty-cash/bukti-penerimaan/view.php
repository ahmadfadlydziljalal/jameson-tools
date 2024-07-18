<?php

use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model app\models\MutasiKasPettyCash|mixed|null */

?>


<div class="mutasi-kas-petty-cash-bukti-penerimaan-view">
    <h2>Bukti Penerimaan: <?= $model->businessProcess ?></h2>

    <?php if ($model->buktiPenerimaanPettyCash->bukti_pengeluaran_petty_cash_cash_advance_id) : ?>
        <?php echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                [
                    'attribute' => 'reference_number',
                    'value' => $model->buktiPenerimaanPettyCash->reference_number,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'bukti_pengeluaran',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->reference_number,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'kasbon',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance->cash_advance,
                    'format' => ['decimal', 2],
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align:right',
                    ],
                ],
                [
                    'attribute' => 'order',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance?->order,
                    'contentOptions' => [
                        'style' => 'text-align:right',
                    ],
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'jenis_biaya',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance?->jenisBiaya?->name,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'vendor',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance?->vendor?->nama,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'job_order',
                    'value' => $model->buktiPenerimaanPettyCash?->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance?->jobOrder?->reference_number,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
            ]
        ]); ?>
    <?php endif ?>

    <?php if ($model->buktiPenerimaanPettyCash->buku_bank_id) : ?>
        <?php echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                [
                    'attribute' => 'reference_number',
                    'value' => $model->buktiPenerimaanPettyCash->reference_number,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'buku_bank',
                    'value' => $model->buktiPenerimaanPettyCash?->bukuBank?->nomor_voucher,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'jenis_biaya',
                    'value' => $model->buktiPenerimaanPettyCash?->bukuBank?->buktiPengeluaranBukuBank?->jobOrderDetailPettyCash?->jenisBiaya->name,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'vendor',
                    'value' => $model->buktiPenerimaanPettyCash?->bukuBank?->buktiPengeluaranBukuBank?->jobOrderDetailPettyCash?->vendor->nama,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'job_order',
                    'value' => $model->buktiPenerimaanPettyCash?->bukuBank?->buktiPengeluaranBukuBank?->jobOrderDetailPettyCash?->jobOrder->reference_number,
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                ],
                [
                    'attribute' => 'nominal',
                    'value' => $model->buktiPenerimaanPettyCash?->bukuBank?->buktiPengeluaranBukuBank?->jobOrderDetailPettyCash?->nominal,
                    'format' => ['decimal', 2],
                    'captionOptions' => [
                        'style' => 'text-align:left',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align:right',
                    ],
                ],
            ]
        ]); ?>
    <?php endif ?>


</div>
