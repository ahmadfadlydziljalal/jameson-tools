<?php

/* @var $this View */
/* @var $model BuktiPengeluaranPettyCash */

use app\models\BuktiPengeluaranPettyCash;
use yii\web\View;


?>

<div class="content-section">
    <h1 class="text-center">Bukti Pengeluaran Petty Cash</h1>
    <span>Reference: <?= $model->reference_number ?></span>
    <?php if ($model->buktiPengeluaranPettyCashBill) : ?>
        <?= $this->render('_view_bill_payment',[
            'model' => $model
        ]) ?>
    <?php endif ?>
    <?php if ($model->buktiPengeluaranPettyCashCashAdvance) : ?>
        <?= $this->render('_view_cash_advance',[
            'model' => $model
        ]) ?>
    <?php endif ?>
    <br>
    <small>Generated at: <?= Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s')) ?></small>
</div>
