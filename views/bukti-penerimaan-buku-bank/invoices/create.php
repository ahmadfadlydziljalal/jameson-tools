<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanBukuBank */
/* @see app\controllers\BuktiPenerimaanBukuBankController::actionCreateForInvoices() */

use yii\helpers\Html;
$this->title = 'Tambah Bukti Penerimaan Buku Bank For Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-buku-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>