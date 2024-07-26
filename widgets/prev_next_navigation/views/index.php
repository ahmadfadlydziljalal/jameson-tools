<?php

/* @var $this View */

/* @var app\models\interfaces\PrevNextInterface $model */

/* @var $isPjax int */

use yii\bootstrap5\Html;
use yii\web\View;

?>

<div class="d-inline-flex gap-2">
    <?php
    if ($model->getPrevious()) {
        echo Html::a('<< Previous', ['view', 'id' => $model->getPrevious()->id], [
            'class' => 'btn btn-primary', 'data-pjax' => $isPjax,
            'id' => 'prev-page'
        ]);
    }

    if ($model->getNext()) {
        echo Html::a('Next >>', ['view', 'id' => $model->getNext()->id], [
            'class' => 'btn btn-primary', 'data-pjax' => $isPjax,
            'id' => 'next-page'
        ]);
    }
    ?>
</div>
