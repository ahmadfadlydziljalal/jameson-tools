<?php

/* @var $this yii\web\View */
/* @var $model app\models\Rekening */


use yii\helpers\Html;
$this->title = 'Tambah Rekening';
$this->params['breadcrumbs'][] = ['label' => 'Rekening', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="rekening-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>