<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardOwnEquipment */
/* @see app\controllers\CardOwnEquipmentController::actionUpdate() */

$this->title = 'Update Card Equipment: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card Own Equipment', 'url' => ['/card-own-equipment/index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama . ' ' . $model->card->nama, 'url' => ['/card-own-equipment/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="card-own-equipment-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
      'model' => $model,
   ]) ?>
</div>