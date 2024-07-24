<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranBukuBank */
/* @see app\controllers\BuktiPengeluaranBukuBankController::actionCreateByCashAdvance() */

use yii\helpers\Html;
$this->title = 'Tambah Bukti Pengeluaran';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-pengeluaran-buku-bank-create d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <span class="badge text-bg-info"> Scenario By Cash Advance / Kasbon</span>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>