<?php

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $modelsDetail app\models\InvoiceDetail */

use yii\helpers\Html;
$this->title = 'Tambah Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>