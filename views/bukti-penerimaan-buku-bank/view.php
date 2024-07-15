<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanBukuBank */
/* @see app\controllers\BuktiPenerimaanBukuBankController::actionView() */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-buku-bank-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>
    </div>

    <?php try {
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
                'jumlah_setor',
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

    <?php
    if ($model->setoranKasirs) {
        echo $this->render('_view_setoran_kasir', [
            'model' => $model,
        ]);
    }
    ?>

</div>