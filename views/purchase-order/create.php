<?php

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */

/* @var $modelsDetail app\models\MaterialRequisitionDetail */

$this->title = 'Membuat Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="purchase-order-create">

    <h1>Langkah ke dua</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>