<?php

/* @var $this yii\web\View */

/* @var $model app\models\BuktiPengeluaranBukuBank|string|ActiveRecord */

use yii\db\ActiveRecord;
use yii\widgets\DetailView;

?>

<?php echo DetailView::widget([
    'model' => $model,
    'options' => [
        'class' => 'table table-bordered table-detail-view'
    ],
    'attributes' => [
        'reference_number',
        [
            'attribute' => 'vendor_id',
            'value' => $model->vendor->nama,
        ],
        [
            'attribute' => 'vendor_rekening_id',
            'value' => $model->vendorRekening?->nama_bank,
        ],
        [
            'attribute' => 'rekening_saya_id',
            'value' => $model->rekeningSaya->atas_nama,
            'format' => 'nText',
        ],
        [
            'attribute' => 'jenis_transfer_id',
            'value' => $model->jenisTransfer->name,
        ],

        'nomor_bukti_transaksi',
        'tanggal_transaksi:date',
        'keterangan:ntext',
        [
            'attribute' => 'nomorVoucher',
            'value' => $model->bukuBank?->nomor_voucher,
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
//            'value' => fn($model) => $model->createdBy->username,
            'value' => function ($model) {
                return app\models\User::findOne($model->created_by)->username;
            }
        ],
        [
            'attribute' => 'updated_by',
            'value' => function ($model) {
                return app\models\User::findOne($model->updated_by)->username;
            }
        ],
    ],
]); ?>

<?php
echo $this->render('_view_2', [
    'model' => $model,
]);
?>
