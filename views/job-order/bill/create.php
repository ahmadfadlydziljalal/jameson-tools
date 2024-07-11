<?php
/* @var $this yii\web\View */
/* @var $model app\models\JobOrderBill */
/* @see \app\controllers\JobOrderController::actionCreateBill() */
/* @var $jobOrder app\models\JobOrder */
/* @var $modelsDetail array|\app\models\JobOrderBillDetail[] */

use yii\helpers\Html;
$this->title = 'Tambah Bill';
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $jobOrder->reference_number, 'url' => ['view', 'id' => $jobOrder->id, '#'=> 'quotation-tab-tab2']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="job-order-detail-bill">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>