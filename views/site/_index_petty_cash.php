<?php

/* @var $myBank app\models\reports\MyBankAccountsReport */
/* @var $this yii\web\View */
?>

<div class="card border-primary rounded-3">
    <div class="card-body">
        <p class="fw-bold">Petty Cash</p>
        <h3>Rp. <?= Yii::$app->formatter->asDecimal($myBank->mutasiKasPettyCashReportPerSpecificDate->getEndingBalance(), 2) ?></h3>
    </div>
</div>
