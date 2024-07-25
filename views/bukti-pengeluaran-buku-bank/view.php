<?php

use app\enums\TextLinkEnum;
use kartik\bs5dropdown\ButtonDropdown;
use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranBukuBank */
/* @see app\controllers\BuktiPengeluaranBukuBankController::actionView() */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Pengeluaran Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bukti-pengeluaran-buku-bank-view d-flex flex-column gap-3">

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
                        ['label' => 'By Payment Petty Cash', 'url' => ['create-by-petty-cash']],
                    ],
                    'options' => [
                        'class' => 'dropdown-menu-end',
                    ],
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-primary',
                ],
                'encodeLabel' => false
            ]); ?>

            <?= Html::a(TextLinkEnum::PRINT->value, ['bukti-pengeluaran-buku-bank/export-to-pdf', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ]) ?>

            <?= Html::a(TextLinkEnum::UPDATE->value, $model->getUpdateUrl(), [
                'class' => 'btn btn-outline-primary',
            ]) ?>

            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus',  $model->getDeleteUrl() , [
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

    <?= $this->render('_view',[
            'model' => $model
    ]) ?>

    <div class="d-inline-flex gap-2">
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