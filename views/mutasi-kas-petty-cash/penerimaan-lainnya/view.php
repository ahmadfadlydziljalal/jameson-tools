<?php

use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model \app\models\MutasiKasPettyCash|mixed|null */

?>


<div class="mutasi-kas-petty-cash-bukti-pengeluaran-lainnya-view">
    <h2><?= $model->businessProcess ?></h2>

    <?php echo DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered table-detail-view'
        ],
        'attributes' => [
            [
                'attribute' => 'card_id',
                'value' => $model->transaksiMutasiKasPettyCashLainnya->card->nama,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'jenis_pendapatan_id',
                'value' => $model->transaksiMutasiKasPettyCashLainnya->jenisPendapatan->name,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
            [
                'attribute' => 'nominal',
                'value' => $model->transaksiMutasiKasPettyCashLainnya->nominal,
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right',
                ],
            ],
            [
                'attribute' => 'keterangan',
                'value' => $model->transaksiMutasiKasPettyCashLainnya->keterangan,
                'captionOptions' => [
                    'style' => 'text-align:left',
                ],
            ],
        ]
    ]); ?>
</div>
