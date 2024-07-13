<?php
/* @var $this yii\web\View */
/* @var $model app\models\MutasiKasPettyCash */
/* @var $kodeVoucher app\models\KodeVoucher */
/* @see app\controllers\MutasiKasPettyCashController::actionCreateByBuktiPengeluaranPettyCash() */

use yii\helpers\Html;
$this->title = 'Tambah Mutasi Kas Petty Cash : ' .  $kodeVoucher->singkatan;
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mutasi-kas-petty-cash-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>