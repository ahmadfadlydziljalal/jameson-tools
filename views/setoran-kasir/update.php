<?php

/* @var $this yii\web\View */
/* @var $model app\models\SetoranKasir */
/* @var $modelsDetail app\models\SetoranKasirDetail */

use yii\helpers\Html;

$this->title = 'Update Setoran Kasir: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Setoran Kasir', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="setoran-kasir-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>