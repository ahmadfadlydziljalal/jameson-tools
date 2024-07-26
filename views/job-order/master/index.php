<?php

/* @var $this yii\web\View */

/* @var $model app\models\JobOrder */

use app\enums\TextLinkEnum;
use yii\bootstrap5\Html;
use yii\widgets\DetailView;

?>

<div class="d-flex flex-column gap-3">
    <div>
        <?= Html::a(TextLinkEnum::PRINT->value, ['export-to-pdf', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'data-pjax' => '0'
        ]) ?>

        <?php if(!$model->jobOrderDetailPettyCash) {
            echo Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }else{
            echo Html::a(TextLinkEnum::UPDATE->value, ['update-for-petty-cash', 'id' => $model->id], ['class' => 'btn btn-primary']);
        } ?>

    </div>

    <?php echo DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-detail-view table-bordered'
        ],
        'attributes' => [
            'reference_number',
            [
                'attribute' => 'main_vendor_id',
                'value' => $model->mainVendor->nama
            ],
            [
                'attribute' => 'main_customer_id',
                'value' => $model->mainCustomer->nama
            ],
            'keterangan:ntext',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return app\models\User::findOne($model->created_by)->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return app\models\User::findOne($model->updated_by)->username;
                }
            ],
        ],
    ]); ?>

</div>



