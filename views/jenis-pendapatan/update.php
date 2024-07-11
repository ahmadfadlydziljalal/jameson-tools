<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JenisPendapatan */
/* @see app\controllers\JenisPendapatanController::actionUpdate() */

$this->title = 'Update Jenis Pendapatan: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pendapatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="jenis-pendapatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>