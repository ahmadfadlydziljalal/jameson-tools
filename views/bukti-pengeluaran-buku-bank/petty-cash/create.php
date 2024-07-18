<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranBukuBank */
/* @see app\controllers\BuktiPengeluaranBukuBankController::actionCreateByBillForPettyCash() */

use yii\helpers\Html;
$this->title = 'Tambah Bukti Pengeluaran Buku Bank By Payment Bill For Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-pengeluaran-buku-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>