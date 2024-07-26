<?php
/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @var $modelDetail app\models\JobOrderDetailPettyCash */

/* @see \app\controllers\JobOrderController::actionUpdateForPettyCash() */

use yii\helpers\Html;

$this->title = 'Update Job Order For Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Job Order | Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id, '#' => 'quotation-tab-tab1']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-order-detail-cash-advance-update d-flex flex-column gap-3">
    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <span class="badge text-bg-info">Scenario: Penambahan Saldo Petty Cash</span>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'modelDetail' => $modelDetail,
    ]) ?>
</div>