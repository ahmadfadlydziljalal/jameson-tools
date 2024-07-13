<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanPettyCash */
/* @see app\controllers\BuktiPenerimaanPettyCashController::actionView() */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-petty-cash-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
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

    <?php if ($model->buktiPengeluaranPettyCashCashAdvance): ?>

        <p><strong>Realisasi Petty Cash</strong></p>
        <?= DetailView::widget([
            'model' => $model->buktiPengeluaranPettyCashCashAdvance,
            'attributes' => [
                [
                    'label' => 'Bukti Pengeluaran',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->reference_number,
                ],
                [
                    'label' => 'Job Order',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number,
                ],
                [
                    'label' => 'Vendor',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->vendor->nama,
                ],
                [
                    'label' => 'Jenis Biaya',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name,
                ],
                [
                    'label' => 'Kasbon / Cash Advance',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order,
                ],
                [
                    'label' => 'Total',
                    'value' => $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance,
                    'format' => ['decimal', 2],
                ],
            ]
        ]) ?>

    <?php endif ?>

</div>