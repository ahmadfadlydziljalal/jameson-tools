<?php
/* @var $this yii\web\View */
/* @var $model app\models\Trash */
/* @see app\controllers\TrashController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Trash';
$this->params['breadcrumbs'][] = ['label' => 'Trash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="trash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>