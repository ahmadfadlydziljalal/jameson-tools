<?php
/* @var $this yii\web\View */
/* @var $model app\models\Cashier */
/* @see app\controllers\CashierController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Cashier';
$this->params['breadcrumbs'][] = ['label' => 'Cashier', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cashier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>