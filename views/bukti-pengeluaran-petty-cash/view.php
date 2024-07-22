<?php

use kartik\bs5dropdown\ButtonDropdown;
use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranPettyCash */
/* @see app\controllers\BuktiPengeluaranPettyCashController::actionView() */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-pengeluaran-petty-cash-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Buat Lagi',
                'dropdown' => [
                    'items' => [
                        ['label' => 'By Kasbon / Cash Advance', 'url' => ['create-by-cash-advance']],
                        ['label' => 'By Payment Bill', 'url' => ['create-by-bill']],
                    ],
                    'options' => [
                        'class' => 'dropdown-menu-right',
                    ],
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-primary',
                ],
                'encodeLabel' => false
            ]); ?>
            <?= Html::a('Export To PDF', ['bukti-pengeluaran-petty-cash/export-to-pdf', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ]) ?>

            <?= Html::a('<i class="bi bi-pencil"></i> Update', $model->getUpdateUrl(), [
                'class' => 'btn btn-outline-primary',
            ]) ?>

            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>
    </div>

    <?php  echo DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered table-detail-view'
        ],
        'attributes' => [
            'reference_number',
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
    ]);?>

    <?php if ($model->jobOrderBill) : ?>
        <?= $this->render('_view_bill_payment', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if ($model->jobOrderDetailCashAdvance) : ?>
        <?= $this->render('_view_cash_advance', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <div class="d-inline-flex">
        <?php
        if ($model->getPrevious()) {
            echo Html::a('<< Previous', ['view', 'id' => $model->getPrevious()->id], [
                'class' => 'btn btn-primary', 'data-pjax' => 1,
                'id' => 'prev-page'
            ]);
        }

        if ($model->getNext()) {
            echo Html::a('Next >>', ['view', 'id' => $model->getNext()->id], [
                'class' => 'btn btn-primary', 'data-pjax' => "1",
                'id' => 'next-page'
            ]);
        }
        ?>
    </div>


</div>