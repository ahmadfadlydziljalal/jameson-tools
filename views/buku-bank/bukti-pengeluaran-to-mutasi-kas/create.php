<?php
/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @see app\controllers\BukuBankController::actionCreateByBuktiPengeluaranBukuBankToMutasiKas() */
/* @var $kodeVoucher app\models\KodeVoucher */

use yii\helpers\Html;
$this->title = 'Tambah Buku Bank With Mutasi Kas '. $kodeVoucher->name;
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="buku-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>