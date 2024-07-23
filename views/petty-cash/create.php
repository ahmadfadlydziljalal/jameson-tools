<?php
/* @var $this yii\web\View */
/* @var $model app\models\PettyCash */
/* @see app\controllers\PettyCashController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>