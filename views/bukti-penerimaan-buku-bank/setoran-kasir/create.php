<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanBukuBank */
/* @see app\controllers\BuktiPenerimaanBukuBankController::actionCreateForSetoranKasir() */

use yii\helpers\Html;
use yii\helpers\Inflector;

$this->title = 'Tambah Bukti Penerimaan';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-buku-bank-create d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <span class="badge text-bg-info"> <?= ucwords(Inflector::humanize($model->scenario)) ?></span>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>