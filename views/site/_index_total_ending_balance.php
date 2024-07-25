<?php

/* @var $myBank app\models\reports\MyBankAccountsReport */
/* @var $this yii\web\View */
/* @var $isPdf false */

?>

<div class="card text-bg-primary rounded-3">
    <div class="card-body">
        <p class="fw-bold">Total Balance ( Petty Cash + Bank ):</p>
        <?php if (!$isPdf) : ?>
            <p class="display-5 m-0">
                Rp. <?= $myBank->getTotalAllOfEndingBalance(true) ?>
            </p>
        <?php else : ?>
            <h3>Rp. <?= $myBank->getTotalAllOfEndingBalance(true) ?></h3>
            <p>
                Terbilang: <br/>
                <i><?= Yii::$app->formatter->asSpellout($myBank->getTotalAllOfEndingBalance(false)) ?></i>
            </p>
        <?php endif ?>
    </div>
</div>
