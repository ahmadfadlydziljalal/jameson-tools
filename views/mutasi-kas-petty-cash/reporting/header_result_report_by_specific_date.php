<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\form\MutasiKasPettyCashReportPerSpecificDate|object */

?>

<div style="width: 100%">
    <div style="float: left; width: 49%">
        <p><?= Yii::$app->name ?></p>
    </div>
    <div style="float: right; width: 49%">
        <p style="text-align: right"><?=  'Mutasi Kas Petty Cash: ' . $model->date ?></p>
        <p style="text-align: right; font-weight: bold" class="m-0">Balance: <?= Yii::$app->formatter->asDecimal($model->balanceBeforeDate, 2) ?></p>
    </div>
    <div style="clear: both"></div>
</div>