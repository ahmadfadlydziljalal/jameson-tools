<?php

/* @var $this View */

use app\models\BuktiPenerimaanPettyCash;
use app\models\BuktiPengeluaranPettyCash;
use app\models\BukuBank;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
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
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'reference_number',
        'format' => 'text',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_transaksi',
        'format' => 'date',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bukti_pengeluaran_petty_cash_cash_advance_id',
        'value' => fn($model) => $model->buktiPengeluaranPettyCashCashAdvance?->reference_number,
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->bukti_pengeluaran_petty_cash_cash_advance_id)
                ? BuktiPengeluaranPettyCash::findOne($searchModel->bukti_pengeluaran_petty_cash_cash_advance_id)->reference_number
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '100%',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to('/bukti-pengeluaran-petty-cash/find-by-id'),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'buku_bank_id',
        'value' => fn($model) => $model->bukuBank?->nomor_voucher,
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->buku_bank_id)
                ? BukuBank::findOne($searchModel->buku_bank_id)->nomor_voucher
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '100%',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to('/buku-bank/find-by-id'),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nomorVoucherMutasiKasPettyCash',
        'header' => 'Mutasi Kas',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->mutasiKasPettyCash) {
                return $model->mutasiKasPettyCash->nomor_voucher;
            }
            /* @see \app\controllers\BuktiPenerimaanPettyCashController::actionRegisterToMutasiKas() */
            return Html::a('Register it!', ['bukti-penerimaan-petty-cash/register-to-mutasi-kas', 'id' => $model->id], [
                'data-pjax' => '0',
                'data-confirm' => 'Are you sure you want to register ' . $model->reference_number . ' to Mutasi Kas?',
                'data-method' => 'post',
            ]);
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'businessProcess',
        'value' => fn($model) => $model->referensiPenerimaan['businessProcess']
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jobOrder',
        'value' => fn($model) => $model->referensiPenerimaan['data']['jobOrder']
    ],
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'buktiPengeluaran',
        'value' => fn($model) => $model->referensiPenerimaan['data']['buktiPengeluaran']
    ],*/
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jenisBiaya',
        'value' => fn($model) => $model->referensiPenerimaan['data']['jenisBiaya']
    ],*/
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor',
        'value' => fn($model) => $model->referensiPenerimaan['data']['vendor']
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nominal',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'style' => 'text-align:right',
        ],
        'value' => fn($model) => $model->referensiPenerimaan['data']['nominal']
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'target' => '_blank'
                ]);
            },
            'update' => function ($url, $model) {
                /** @var BuktiPenerimaanPettyCash $model */
                /** @see \app\controllers\BuktiPenerimaanPettyCashController::actionUpdateByRealisasiKasbon() */

                // Update hanya boleh yang datang dari bukti pengeluaran petty cash, (Kasbon)
                if ($model->buktiPengeluaranPettyCashCashAdvance and !$model->mutasiKasPettyCash) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['bukti-penerimaan-petty-cash/update-by-realisasi-kasbon', 'id' => $model->id]);
                }
                return '';
            },
            'delete' => function ($url, $model) {
                /** @var BuktiPenerimaanPettyCash $model */
                /** @see \app\controllers\BuktiPenerimaanPettyCashController::actionDeleteByRealisasiKasbon() */

                // Delete hanya boleh yang datang dari bukti pengeluaran petty cash, (Kasbon), dan belum terdaftar di mutasi kas
                if ($model->buktiPengeluaranPettyCashCashAdvance and !$model->mutasiKasPettyCash) {
                    return Html::a('<i class="bi bi-trash"></i>', ['bukti-penerimaan-petty-cash/delete-by-realisasi-kasbon', 'id' => $model->id], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                            'pjax' => '0'
                        ],
                        'class' => 'text-danger',
                    ]);
                }
                return '';
            }
        ]
    ],
//    [
//        'class'=>'\yii\grid\DataColumn',
//        'attribute'=>'referensiPenerimaan',
//        'format'=>'html',
//        'value' => fn($model) => Html::tag('pre',\yii\helpers\VarDumper::dumpAsString($model->referensiPenerimaan))
//    ],
//    [
//        'class'=>'\yii\grid\DataColumn',
//        'attribute'=>'cash_advance',
//        'value'=>function($model){
//            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
//            if( $model->buktiPengeluaranPettyCashCashAdvance){
//                return 'Kasbon ke ' . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order;
//            }
//        }
//    ],
//    [
//        'class'=>'\yii\grid\DataColumn',
//        'attribute'=>'jenis_biaya',
//        'value'=>function($model){
//            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
//            return $model->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance->jenisBiaya->name;
//        }
//    ],
//    [
//        'class'=>'\yii\grid\DataColumn',
//        'attribute'=>'nominal',
//        'value'=>function($model){
//            /** @var app\models\base\BuktiPenerimaanPettyCash $model */
//            return $model->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance->cash_advance;
//        },
//        'contentOptions'=>['style'=>'text-align:right'],
//        'format'=> ['decimal',2],
//    ],
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

];   