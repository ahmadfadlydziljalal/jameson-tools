<?php

/* @var $this View */

/* @var $model BuktiPengeluaranPettyCash|string|ActiveRecord */

use app\models\BuktiPengeluaranPettyCash;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

?>
<div class="">
    <h2>Bill Payment</h2>
    <p><?= $model->jobOrderBill->vendor->nama ?></p>
    Ref: <?= $model->jobOrderBill->reference_number ?>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
                'query' => $model->jobOrderBill->getJobOrderBillDetails(),
                'pagination' => false,
                'sort' => false,
            ]
        ),
        'layout' => "{items}",

        'showPageSummary' => true,
        'columns' => require(Yii::getAlias('@app') . '/views/job-order/bill/_columns_view_detail.php'),
    ]) ?>
</div>

