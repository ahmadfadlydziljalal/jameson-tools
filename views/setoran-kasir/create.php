<?php

/* @var $this yii\web\View */
/* @var $model app\models\SetoranKasir */
/* @var $modelsDetail app\models\SetoranKasirDetail */

use yii\helpers\Html;
$this->title = 'Tambah Setoran Kasir';
$this->params['breadcrumbs'][] = ['label' => 'Setoran Kasir', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="setoran-kasir-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>