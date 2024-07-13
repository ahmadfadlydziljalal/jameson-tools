<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MutasiKasPettyCash */
/* @see app\controllers\MutasiKasPettyCashController::actionView() */

$this->title = $model->nomor_voucher;
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mutasi-kas-petty-cash-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap ">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-inline-flex gap-1">
            <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Create more', ['create'], ['class' => 'btn btn-success']) ?>
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

    <?php echo DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered table-detail-view'
        ],
        'attributes' => [
            'nomor_voucher',
            'tanggal_mutasi:date',
            'keterangan:ntext',
        ],
    ]); ?>

    <?php if ($model->bukti_penerimaan_petty_cash_id): ?>
        <?= $this->render('bukti-penerimaan/view', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if ($model->bukti_pengeluaran_petty_cash_id): ?>
        <?= $this->render('bukti-pengeluaran/view', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if ($model->transaksiMutasiKasPettyCashLainnya): ?>
        <?php if ($model->transaksiMutasiKasPettyCashLainnya->jenis_pendapatan_id): ?>
            <?= $this->render('penerimaan-lainnya/view', [
                'model' => $model
            ]) ?>
        <?php endif; ?>

        <?php if ($model->transaksiMutasiKasPettyCashLainnya->jenis_biaya_id): ?>
            <?= $this->render('pengeluaran-lainnya/view', [
                'model' => $model
            ]) ?>
        <?php endif; ?>
    <?php endif; ?>


</div>