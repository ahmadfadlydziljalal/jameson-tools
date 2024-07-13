<?php
/* @var $this yii\web\View */
/* @var $model app\models\MutasiKasPettyCash */
/* @see app\controllers\MutasiKasPettyCashController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Mutasi Kas Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mutasi-kas-petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>