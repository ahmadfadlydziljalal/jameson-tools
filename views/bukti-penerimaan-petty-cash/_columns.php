<?php

/* @var $this View */

use app\models\BuktiPenerimaanPettyCash;
use yii\bootstrap5\Html;
use yii\web\View;

?>
<?php
/** @var BuktiPenerimaanPettyCash $model */
return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
        // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'id',
        // 'format'=>'text',
    // ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'reference_number',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'voucher',
        'value'=> fn($model) => $model->mutasiKasPettyCash?->nomor_voucher
    ],
    /*[
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_pengeluaran_petty_cash_cash_advance_id',
    ],*/
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_pengeluaran_petty_cash_cash_advance_id',
        'value'=>function($model){
            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
            return $model->buktiPengeluaranPettyCashCashAdvance?->reference_number;
        }
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'cash_advance',
        'value'=>function($model){
            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
            if( $model->buktiPengeluaranPettyCashCashAdvance){
                return 'Kasbon ke ' . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order;
            }

        }
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'jenis_biaya',
        'value'=>function($model){
            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
            return $model->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance->jenisBiaya->name;
        }
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'nominal',
        'value'=>function($model){
            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
            return $model->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance->cash_advance;
        },
        'contentOptions'=>['style'=>'text-align:right'],
        'format'=> ['decimal',2],
    ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'created_at',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'updated_at',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'created_by',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'updated_by',
        // 'format'=>'text',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url,[
                    'target' => '_blank'
                ]);
            },
            'update' => function ($url, $model) {
                /** @var BuktiPenerimaanPettyCash $model */
                if($model->buktiPengeluaranPettyCashCashAdvance){
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-penerimaan-petty-cash/update-by-realisasi-kasbon', 'id' => $model->id]);
                }
                return '';
            },
            'delete' => function ($url, $model) {
                /** @var BuktiPenerimaanPettyCash $model */
                /** @see \app\controllers\BuktiPenerimaanPettyCashController::actionDeleteByRealisasiKasbon() */
                if($model->buktiPengeluaranPettyCashCashAdvance){
                    return Html::a('<i class="bi bi-trash"></i>', ['bukti-penerimaan-petty-cash/delete-by-realisasi-kasbon', 'id' => $model->id],[
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                            'pjax' =>'0'
                        ],
                        'class'=>'text-danger',
                    ]);
                }
                return '';
            }
        ]
    ],
];   