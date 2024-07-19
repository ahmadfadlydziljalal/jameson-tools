<?php

use kartik\bs5dropdown\ButtonDropdown;
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
        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="d-inline-flex gap-1">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Buat Mutasi Lainnya',
                'dropdown' => [
                    'items' => [
                        '<h6 class="dropdown-header">Debit</h6>',
                        ['label' => 'Bukti Penerimaan', 'url' => ['create-by-bukti-penerimaan-petty-cash']],
                        ['label' => 'Lainnya', 'url' => ['create-by-penerimaan-lainnya']],
                        '<hr class="dropdown-divider">',
                        '<h6 class="dropdown-header">Credit</h6>',
                        ['label' => 'Bukti Pengeluaran', 'url' => ['create-by-bukti-pengeluaran-petty-cash']],
                        ['label' => 'Lainnya', 'url' => ['create-by-pengeluaran-lainnya']],
                    ],
                    'options' => [
                        'class' => 'dropdown-menu-end',
                    ],
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-primary',
                ],
                'encodeLabel' => false
            ]); ?>

            <?= Html::a('<i class="bi bi-printer"></i> Export to PDF', ['mutasi-kas-petty-cash/export-to-pdf', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'target' => '_blank',
            ]) ?>

            <?php if (!$model->isFromMutasiKas()) : ?>
                <?= Html::a('Update', $model->updateUrl, ['class' => 'btn btn-outline-primary']) ?>
            <?php endif; ?>

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

    <div class="d-inline-flex gap-2">
        <?php
        if ($model->getPrevious()) {
            echo Html::a('<< Previous', ['view', 'id' => $model->getPrevious()->id], ['class' => 'btn btn-outline-primary']);
        }

        if ($model->getNext()) {
            echo Html::a('Next >>', ['view', 'id' => $model->getNext()->id], ['class' => 'btn btn-outline-primary']);
        }
        ?>
    </div>


</div>