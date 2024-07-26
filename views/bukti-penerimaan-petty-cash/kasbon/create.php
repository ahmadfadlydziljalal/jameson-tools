<?php
/* @var $this View */
/* @var $model BuktiPenerimaanPettyCash */

/* @see \app\controllers\BuktiPenerimaanPettyCashController::actionCreateByRealisasiKasbon() */

use app\models\BuktiPenerimaanPettyCash;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Bukti Penerimaan Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-petty-cash-create d-flex flex-column gap-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>