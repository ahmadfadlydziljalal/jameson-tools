<?php

/* @var $this yii\web\View */
/* @var $model \app\models\JobOrderDetailCashAdvance */

use app\enums\TextLinkEnum;
use yii\bootstrap5\Html;

?>


<div class="card bg-transparent">
    <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
        <p class="m-0">Cash Advance ke: <?= $model->order ?></p>
        <div>
            <i class="bi bi-person"></i> <?= $model->vendor->nama ?>
        </div>
    </div>
    <div class="card-body">

        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 row-cols-xl-2">

            <div class="col">
                <h2 class="card-title"><?= $model->jenisBiaya->name ?></h2>
                <?= $model->getBuktiPengeluaranReferenceNumber() ?>
            </div>

            <div class="col">
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between flex-row">
                        <span class="text-muted">Kasbon Request:</span>
                        <span>
                            <?= $model->mataUang->singkatan ?>
                            <?= Yii::$app->formatter->asDecimal($model->kasbon_request, 2) ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between flex-row">
                        <span class="text-muted">Panjar / Cash Advance:</span>
                        <span>
                            <?= $model->mataUang->singkatan ?>
                            <?= Yii::$app->formatter->asDecimal($model->cash_advance, 2) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer p-3 d-flex justify-content-between flex-wrap">
        <?= Html::a('<i class="bi bi-printer"></i> Print PDF', ['export-to-pdf-payment-cash-advance', 'id' => $model->id], [
            'target' => '_blank',
            'class' => 'btn btn-outline-primary'
        ]) ?>

        <?php if(!$model->isPanjar()): ?>
        <div>
            <?= Html::a('<i class="bi bi-pencil"></i> Update', ['update-cash-advance', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary'
            ]) ?>

            <?= Html::a('<i class="bi bi-trash"></i>', ['delete-cash-advance', 'id' => $model->id], [
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                    'pjax' => '0',
                ],
                'class' => 'btn btn-outline-danger'
            ]) ?>
        </div>

        <?php endif ?>

    </div>
</div>
