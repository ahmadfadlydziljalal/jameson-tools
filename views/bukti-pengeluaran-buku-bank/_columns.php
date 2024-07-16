<?php

/* @var $this yii\web\View */

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
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'rekening_saya_id',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jenis_transfer_id',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_rekening_id',
        'format' => 'text',
    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'nomor_bukti_transaksi',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'tanggal_transaksi',
    // 'format'=>'date',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'keterangan',
    // 'format'=>'ntext',
    // ],
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
        'class' => 'yii\grid\ActionColumn',
        'template' => '{export-to-pdf} {view} {update} {delete}',
        'buttons' => [
            'export-to-pdf' => function ($url, $model) {
                return '';
            },
            'update' => function ($url, $model) {

                /** @var \app\models\BuktiPengeluaranBukuBank $model */
                if($model->jobOrderDetailCashAdvances){
                    return \yii\helpers\Html::a('<i class="bi bi-pencil"></i>' ,['bukti-pengeluaran-buku-bank/update-by-cash-advance','id'=>$model->id]);
                }
                return $model->id;
            }
        ]
    ],
];   