<?php

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $modelsDetail app\models\InvoiceDetail */

use yii\helpers\Html;

$this->title = 'Update Invoice: ' . $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reference_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invoice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>