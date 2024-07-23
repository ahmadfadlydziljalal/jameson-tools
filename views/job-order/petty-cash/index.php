<?php

/* @var $this yii\web\View */

/* @var $model app\models\JobOrder */

use app\enums\TextLinkEnum;
use yii\helpers\Html;

?>

<div class="d-flex flex-column gap-3">
    <div class="card bg-transparent">

        <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
            <p class="m-0"><?= $model->jobOrderDetailPettyCash->jenisBiaya->name ?></p>
            <small class="text-muted">Update is available as Bukti Pengeluaran Buku Bank is not exist</small>
        </div>

        <div class="card-body">
            <i class="bi bi-person">
                <?= $model->jobOrderDetailPettyCash->vendor->nama ?>
            </i>
            <h2><?= Yii::$app->formatter->asDecimal($model->jobOrderDetailPettyCash->nominal, 2) ?></h2>
        </div>

        <div class="card-body">
            <?php if ($model->jobOrderDetailPettyCash->buktiPengeluaranBukuBank) : ?>
                <div class="d-flex flex-column gap-2">
                    <div>
                        <?= Html::tag('span', '<i class="bi bi-hand-thumbs-up"></i> Paid', ['class' => 'badge bg-info']) . ' ' ?>
                    </div>

                    <span class="text-muted">B.Pengeluaran:</span> <br/>
                    <span><?= $model->jobOrderDetailPettyCash->buktiPengeluaranBukuBank->reference_number ?></span>
                </div>

            <?php else : ?>
                <div class="d-flex justify-content-between flex-wrap">
                    <?= Html::tag('span', 'Waiting for Bukti Pengeluaran Buku Bank', ['class' => 'text-danger']) ?>
                    <div>
                        <?= Html::a(TextLinkEnum::UPDATE->value, ['update-for-petty-cash', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>

                    </div>

                </div>

            <?php endif ?>
        </div>

    </div>
</div>
