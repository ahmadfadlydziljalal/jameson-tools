<?php

/* @var $this \yii\web\View */
?>
<?php
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
        'attribute'=>'nomor_voucher',
        'format'=>'text',
    ],
    /*[
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'kode_voucher_id',
        'format'=>'text',
    ],*/
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_penerimaan_buku_bank_id',
        'value'=>'buktiPenerimaanBukuBank.reference_number',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'bukti_pengeluaran_buku_bank_id',
        'value'=>'buktiPengeluaranBukuBank.reference_number',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_transaksi',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'businessProcess',
        'contentOptions'=>[
            'class' => 'small'
        ],
        'format'=>'raw',
        'value' => function ($model, $key, $index, $column) {
            return \yii\helpers\Html::tag('pre', \yii\helpers\VarDumper::dumpAsString($model->businessProcess));
        }
    ],


    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'keterangan',
        // 'format'=>'ntext',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   