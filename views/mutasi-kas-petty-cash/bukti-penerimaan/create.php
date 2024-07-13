<?php

/* @var $this yii\web\View */
/* @var $kodeVoucher app\models\KodeVoucher */
/* @var $model app\models\MutasiKasPettyCash */
/* @see app\controllers\MutasiKasPettyCashController::actionCreateByBuktiPenerimaanPettyCash() */

use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Tambah Mutasi Kas Petty Cash Bukti Penerimaan : ' . $kodeVoucher->singkatan;
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="mutasi-kas-petty-cash-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
