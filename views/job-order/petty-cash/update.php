<?php
/* @var $this yii\web\View */
/* @var $model app\models\JobOrderDetailCashAdvance */
/* @see \app\controllers\JobOrderController::actionUpdateCashAdvance() */
/* @var $jobOrder app\models\JobOrder */

use yii\helpers\Html;
$this->title = 'Update Job Order';
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id, '#'=> 'quotation-tab-tab1']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-order-detail-cash-advance-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>