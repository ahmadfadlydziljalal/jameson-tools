<?php
/* @var $this yii\web\View */
/* @var $model app\models\JenisBiaya */
/* @see app\controllers\JenisBiayaController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Jenis Biaya';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Biaya', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="jenis-biaya-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>