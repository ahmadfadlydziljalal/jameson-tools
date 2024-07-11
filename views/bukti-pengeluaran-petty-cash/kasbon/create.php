<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranPettyCash */
/* @see app\controllers\BuktiPengeluaranPettyCashController::actionCreateByCashAdvance() */

use yii\helpers\Html;
$this->title = 'Tambah Bukti Pengeluaran Petty Cash By Cash Advance / Kasbon';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-pengeluaran-petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>