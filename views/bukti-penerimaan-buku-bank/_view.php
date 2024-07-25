<?php

/* @var $this yii\web\View */

/* @var $model app\models\BuktiPenerimaanBukuBank|string|\yii\db\ActiveRecord */

use yii\widgets\DetailView;
?>


<div class="bukti-penerimaan-view-_view">
    <?php

    try {
        echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                'reference_number',
                [
                    'attribute' => 'customer_id',
                    'value' => $model->customer->nama
                ],
                [
                    'attribute' => 'rekening_saya_id',
                    'value' => nl2br($model->rekeningSaya->atas_nama),
                    'format' => 'html'
                ],
                [
                    'attribute' => 'jenis_transfer_id',
                    'value' => $model->jenisTransfer->name
                ],
                'nomor_transaksi_transfer',
                'tanggal_transaksi_transfer:date',
                'tanggal_jatuh_tempo:date',
                'keterangan:ntext',
                [
                    'attribute' => 'jumlah_setor',
                    'format' => ['decimal', 2],
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
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

    <?php if ($model->invoices) {
        echo $this->render('_view_invoices', [
            'model' => $model,
        ]);
    } ?>

    <?php if ($model->setoranKasirs) {
        echo $this->render('_view_setoran_kasir', [
            'model' => $model,
        ]);
    } ?>
</div>

