<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MutasiKasPettyCash */
/* @var $modelTransaksiLainnya app\models\TransaksiMutasiKasPettyCashLainnya */
/* @see app\controllers\MutasiKasPettyCashController::actionUpdateByPenerimaanLainnya() */

$this->title = 'Update Mutasi Kas Petty Cash: ' . $model->nomor_voucher;
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor_voucher, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="mutasi-kas-petty-cash-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTransaksiLainnya' => $modelTransaksiLainnya,
    ]) ?>
</div>