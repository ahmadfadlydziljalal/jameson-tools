<?php

/* @var $this View */

use app\models\BuktiPenerimaanBukuBank;
use app\models\BuktiPengeluaranBukuBank;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
        'format' => 'text',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bankId',
        'value' => fn($model) => $model->businessProcess['bank']['nama_bank'],
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => \app\models\Rekening::find()->mapOnlyTokoSaya('nama_bank'),
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ]
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nomor_voucher',
        'format' => 'text',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kode_voucher_id',
        'format'=>'text',
    ],*/
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_transaksi',
        'filterType' => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
        'format' => 'date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bukti_penerimaan_buku_bank_id',
        'value' => 'buktiPenerimaanBukuBank.reference_number',
        'format' => 'text',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->bukti_penerimaan_buku_bank_id)
                ? BuktiPenerimaanBukuBank::findOne($searchModel->bukti_penerimaan_buku_bank_id)->reference_number
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '9em',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to('/bukti-penerimaan-buku-bank/find-by-id'),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ]
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bukti_pengeluaran_buku_bank_id',
        'value' => 'buktiPengeluaranBukuBank.reference_number',
        'format' => 'text',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->bukti_pengeluaran_buku_bank_id)
                ? BuktiPengeluaranBukuBank::findOne($searchModel->bukti_pengeluaran_buku_bank_id)->reference_number
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '9em',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to('/bukti-pengeluaran-buku-bank/find-by-id'),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ]
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mutasiKas',
        'value' => 'buktiPenerimaanPettyCash.mutasiKasPettyCash.nomor_voucher',
        'filterType' => GridViewInterface::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'initValueText' => !empty($searchModel->mutasiKas)
                ? \app\models\MutasiKasPettyCash::findOne($searchModel->mutasiKas)->nomor_voucher
                : '',
            'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'width' => '9em',
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Fetching ke API ...'; }"),
                ],
                'ajax' => [
                    'type' => 'GET',
                    'url' => Url::to('/mutasi-kas-petty-cash/find-by-id'),
                    'dataType' => 'json',
                    'data' => new JsExpression("function(params) { return {q:params.term}; }")
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(q) { return q.text; }'),
                'templateSelection' => new JsExpression('function (q) { return q.text; }'),
            ],
        ]
    ],

//    [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'businessProcess',
//        'contentOptions' => [
//            'class' => 'small text-wrap'
//        ],
//        'format' => 'raw',
//        'value' => function ($model, $key, $index, $column) {
//            /** @var \app\models\BukuBank $model */
//            /*return \yii\helpers\Html::tag('pre', VarDumper::dumpAsString($model->businessProcess));*/
//            if ($model->businessProcess) {
//                return $model->businessProcess['businessProcess'] ?? '';
//            }
//            return '';
//        }
//    ],
//    [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'nominal',
//        'contentOptions' => [
//            'class' => 'small text-end'
//        ],
//        'format' => ['decimal', 2],
//
//    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'keterangan',
    // 'format'=>'ntext',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer"></i>', $url, [
                    'target' => '_blank',
                ]);
            },
            'update' => function ($url, $model) {
                /** @var app\models\BukuBank $model */

                # Dengan bukti penerimaan buku bank
                if ($model->bukti_penerimaan_buku_bank_id) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-penerimaan-buku-bank', 'id' => $model->id]);
                }

                # Dengan penerimaan lainnya
                if ($model->transaksiBukuBankLainnya and $model->transaksiBukuBankLainnya->jenis_pendapatan_id) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-penerimaan-lainnya', 'id' => $model->id]);
                }

                # Dengan bukti pengeluaran buku bank
                if ($model->bukti_pengeluaran_buku_bank_id) {

                    # With mutasi kas
                    if ($model->buktiPengeluaranBukuBank->jobOrderDetailPettyCash) {
                        return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-pengeluaran-buku-bank-to-mutasi-kas', 'id' => $model->id]);
                    }
                    # otherwise Without mutasi kas
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-bukti-pengeluaran-buku-bank', 'id' => $model->id]);
                }

                # Dengan pengeluaran lainnya
                if ($model->transaksiBukuBankLainnya and $model->transaksiBukuBankLainnya->jenis_biaya_id) {
                    return Html::a('<i class="bi bi-pencil"></i>', ['buku-bank/update-by-pengeluaran-lainnya', 'id' => $model->id]);
                }

                return '';
            },
            'delete' => function ($url, $model) {
                /** @var app\models\BukuBank $model */
                if ($model->buktiPenerimaanPettyCash) {
                    return Html::a('<i class="bi bi-trash"></i>', ['delete-with-mutasi-kas', 'id' => $model->id], [
                        'data-confirm' => "Record ini berelasi dengan Mutasi Kas Petty Cash via Bukti Penerimaan Petty Cash. <br/> 
                                           <strong>{$model->buktiPenerimaanPettyCash->reference_number}</strong> 
                                           <strong>{$model->buktiPenerimaanPettyCash->mutasiKasPettyCash->nomor_voucher}</strong><br/>
                                           Jika data ini dihapus, maka Data Petty Cash juga tersebut akan ikut terhapus.<br/>
                                           <span class='text-danger'>Sayangnya kalau data sudah dihapus, maka semua data-data ini tidak dapat di restore ulang.</span>
                                           Apakah anda yakin ingin menghapus data ini ?
                                          ",
                        'data-title' => 'Are you sure ?',
                        'data-method' => 'post',
                        'class' => 'text-danger'
                    ]);
                }
                return Html::a('<i class="bi bi-trash"></i>', $url, [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]
                );
            }
        ]
    ],
];
