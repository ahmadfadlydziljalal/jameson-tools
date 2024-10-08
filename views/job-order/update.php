<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @see app\controllers\JobOrderController::actionUpdate() */

$this->title = 'Update Job Order: ' . $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="job-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>