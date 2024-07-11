<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPengeluaranPettyCash|string|\yii\db\ActiveRecord */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

?>
<div class="">
    <h3>Bill Payment</h3>
    <p><?= $model->buktiPengeluaranPettyCashBill->jobOrderBill->vendor->nama ?></p>
    Ref: <?= $model->buktiPengeluaranPettyCashBill->jobOrderBill->reference_number ?>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
                'query' => $model->buktiPengeluaranPettyCashBill->jobOrderBill->getJobOrderBillDetails(),
                'pagination' => false,
                'sort' => false,
            ]
        ),
        'layout' => "{items}",
        'columns' => require(Yii::getAlias('@app') . '/views/job-order/bill/_columns_view_detail.php'),
    ]) ?>
</div>

