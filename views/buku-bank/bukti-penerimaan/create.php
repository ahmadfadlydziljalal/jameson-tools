<?php
/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @see app\controllers\BukuBankController::actionCreateByBuktiPenerimaanBukuBank() */
/* @var $kodeVoucher app\models\KodeVoucher */

use yii\helpers\Html;
$this->title = 'Tambah Buku Bank '. $kodeVoucher->singkatan;
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="buku-bank-create d-flex flex-column gap-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>