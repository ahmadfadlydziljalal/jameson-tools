<?php
/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanPettyCash */
/* @see app\controllers\BuktiPenerimaanPettyCashController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Bukti Penerimaan Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Penerimaan Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-penerimaan-petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>