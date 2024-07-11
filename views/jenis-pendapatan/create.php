<?php
/* @var $this yii\web\View */
/* @var $model app\models\JenisPendapatan */
/* @see app\controllers\JenisPendapatanController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Jenis Pendapatan';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pendapatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="jenis-pendapatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>