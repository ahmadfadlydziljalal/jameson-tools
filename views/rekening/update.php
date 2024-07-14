<?php

/* @var $this yii\web\View */
/* @var $model app\models\Rekening */
use yii\helpers\Html;

$this->title = 'Update Rekening: ' . $model->card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Rekening', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->atas_nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rekening-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>