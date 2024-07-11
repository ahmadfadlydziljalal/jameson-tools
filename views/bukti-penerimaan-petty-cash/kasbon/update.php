<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanPettyCash */
/* @see app\controllers\BuktiPenerimaanPettyCashController::actionUpdateByRealisasiKasbon() */

$this->title = 'Update Bukti Penerimaan Petty Cash: ' . $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="bukti-penerimaan-petty-cash-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>