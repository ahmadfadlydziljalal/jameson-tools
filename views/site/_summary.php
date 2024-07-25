<?php

/* @var $myBank app\models\reports\MyBankAccountsReport */
/* @var $this yii\web\View */

use yii\helpers\Html;

$keys = explode('-', $myBank->getKey());
?>
<div style="width: 100%">
    <div style="float: left; width: 49%">
        <?=  Html::img('/images/logo.png', [
            'style' => [
                'width' => '128px',
                'height' => 'auto',
            ]
        ]) ?>
    </div>
    <div style="float: right; width: 49%">
        <p  style="margin:0; text-align: right; font-size: .75em">
            <?= Yii::$app->settings->get('site.name') ?> <br>
            Generate: <strong><?= Yii::$app->formatter->asDatetime($keys[1]) ?></strong><br>
            Cetak: <strong><?= date('d-m-Y H:i') ?></strong>
        </p>
    </div>
</div>


