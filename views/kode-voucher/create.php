<?php
/* @var $this yii\web\View */
/* @var $model app\models\KodeVoucher */
/* @see app\controllers\KodeVoucherController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Kode Voucher';
$this->params['breadcrumbs'][] = ['label' => 'Kode Voucher', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="kode-voucher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>