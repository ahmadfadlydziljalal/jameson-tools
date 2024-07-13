<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\JobOrderDetailCashAdvance */
/* @see \app\controllers\JobOrderController::actionExportToPdfPaymentCashAdvance() */
?>

<div class="content-section">
    <h1 class="text-center">Kasbon | Cash Advance</h1>

    <div style="width:100%">
        <div style="float:left; width:49%">
            <strong>Kasbon ke: <?= $model->order ?></strong>,
        </div>
        <div style="float:right; text-align:right; width:49%">
            <span>Job Order: <?= $model->jobOrder->reference_number ?></span>
        </div>
    </div>

    <div>
        <p><?= $model->mataUang->singkatan ?> <?=Yii::$app->formatter->asDecimal( $model->kasbon_request, 2) ?></p>
        <p><i>Terbilang: <?= Yii::$app->formatter->asSpellout($model->kasbon_request) ?></i></p>
        <p>Keterangan: <br>
            Kasbon: Keperluan <?= $model->jenisBiaya->name ?> untuk <?= $model->vendor->nama ?><br/>
            Job Order: <?=!empty( $model->jobOrder->keterangan) ? nl2br( $model->jobOrder->keterangan) :  $model->jobOrder->keterangan ?>
        </p>
    </div>


    <hr>

    <!-- Signature -->
    <table class="table table-borderless mt-1" style="page-break-inside: avoid">
        <thead>
        <tr>
            <td style="width: 50%" class="text-center">Dibuat Oleh</td>
            <td style="width: 50%" class="text-center">Diketahui Oleh</td>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td class="text-center" style="height: 6em"><?= Yii::$app->user->identity->username ?></td>
            <td class="text-center"></td>
        </tr>

        <tr>
            <td class="text-center"></td>
            <td class="text-center">
                (
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )
            </td>
        </tr>
        </tbody>
    </table>
</div>
