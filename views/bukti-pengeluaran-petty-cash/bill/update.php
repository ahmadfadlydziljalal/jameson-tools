<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranPettyCash */
/* @see app\controllers\BuktiPengeluaranPettyCashController::actionUpdateByBill() */

$this->title = 'Update Bukti Pengeluaran: ' . $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="bukti-pengeluaran-petty-cash-update d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <span class="badge text-bg-info"> <?= ucwords(Inflector::humanize($model->scenario)) ?></span>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>