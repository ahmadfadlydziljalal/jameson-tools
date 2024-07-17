<?php

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */

use yii\helpers\Html;

?>

<div class="d-flex flex-column gap-3">
    <?php foreach ($model->jobOrderBills as $jobOrderBill): ?>
        <div class="card bg-transparent">

            <?php foreach ($jobOrderBill->jobOrderBillDetails as $jobOrderBillDetail) : ?>
                <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                    <p class="m-0"><?= $jobOrderBillDetail->jenisBiaya->name ?></p>
                    <div>
                        <i class="bi bi-person">
                            <?= $jobOrderBill->vendor->nama ?>, <?= $jobOrderBill->reference_number ?>
                        </i>
                    </div>
                </div>
                <div class="card-body"><?= $jobOrderBillDetail->name ?>
                    <h2><?= Yii::$app->formatter->asDecimal($jobOrderBillDetail->price, 2) ?></h2>


                </div>
            <?php endforeach; ?>

            <div class="card-body">
                <?php if ($jobOrderBill->buktiPengeluaranBukuBank) : ?>
                    <span class="text-muted">B.Pengeluaran:</span><br/><?= $jobOrderBill->buktiPengeluaranBukuBank->reference_number ?>
                <?php else : ?>
                    <?= Html::tag('span', 'Waiting for Bukti Pengeluaran Buku Bank', ['class' => 'text-danger']) ?>
                <?php endif ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>
