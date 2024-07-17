<?php

/* @var $this yii\web\View */

/* @var $model app\models\JobOrder|string|yii\db\ActiveRecord */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div class="d-flex flex-column gap-3">
    <div>
        <?= Html::a('<i class="bi bi-plus-circle"></i> Tambah Bill', ['job-order/create-bill', 'id' => $model->id],
            [
                'class' => 'btn btn-primary',
            ])
        ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getJobOrderBills()
        ]),
        'tableOptions' => [
            'class' => 'table table-fixes-last-column'
        ],
        'columns' => require(__DIR__ . '/_columns.php'),
        'showPageSummary' => true
    ]) ?>
</div>
