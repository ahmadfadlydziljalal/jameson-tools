<?php

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

<div class="bukti-pengeluaran-petty-cash-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Export To PDF', ['bukti-pengeluaran-petty-cash/export-to-pdf', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'target' => '_blank'
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

    <?php try {
        echo DetailView::widget([
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
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

    <?php if ($model->buktiPengeluaranPettyCashBill) : ?>
        <?= $this->render('_view_bill_payment', [
            'model' => $model
        ]) ?>
    <?php endif ?>

    <?php if ($model->buktiPengeluaranPettyCashCashAdvance) : ?>
        <?= $this->render('_view_cash_advance', [
            'model' => $model
        ]) ?>
    <?php endif ?>


</div>