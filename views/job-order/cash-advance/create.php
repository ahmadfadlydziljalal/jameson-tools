<?php
/* @var $this yii\web\View */
/* @var $model app\models\JobOrderDetailCashAdvance */
/* @see \app\controllers\JobOrderController::actionCreateCashAdvance() */
/* @var $jobOrder app\models\JobOrder */

use yii\helpers\Html;
$this->title = 'Tambah  Cash Advance';
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $jobOrder->reference_number, 'url' => ['view', 'id' => $jobOrder->id, '#'=> 'quotation-tab-tab1']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-order-detail-cash-advance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>