<?php

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @see app\controllers\JobOrderController::actionCreateForPettyCash() */
/* @var $modelDetail \app\models\JobOrderDetailPettyCash */

use yii\helpers\Html;
$this->title = 'Tambah Job Order';
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-order-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'modelDetail' => $modelDetail,
    ]) ?>
</div>