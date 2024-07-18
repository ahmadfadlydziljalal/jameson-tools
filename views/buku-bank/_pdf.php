<?php

/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
?>

<div class="content-section">
    <h1 class="text-center">Voucher Buku Bank</h1>
    <?=  $this->render('_view_detail', ['model' => $model]); ?>
    <br>
    <?=  $this->render('_view_detail_2', ['model' => $model]); ?>
</div>