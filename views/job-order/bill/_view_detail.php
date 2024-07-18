<?php

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderBill|null */
/* @var $this View */
/* @var $model JobOrderBillDetail|null */
/* @see \app\controllers\JobOrderController::actionViewBillDetail() */

use app\models\JobOrderBillDetail;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>


<div class="job-order-bill-detail">
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getJobOrderBillDetails(),
            'pagination' => false,
            'sort' => false
        ]),
        'layout' => "{items}",
        'columns' => require __DIR__ . '/_columns_view_detail.php',
    ]) ?>
</div>
