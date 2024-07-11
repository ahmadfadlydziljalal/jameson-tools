<?php

use app\assets\Bootstrap5VerticalTabs;
use mdm\admin\components\Helper;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @see app\controllers\JobOrderController::actionView() */
/* @var $modelPaymentKasbon \app\models\form\PaymentKasbonForm */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Bootstrap5VerticalTabs::register($this);
?>

<div class="job-order-view d-flex flex-column gap-2">
    <div class="job-order-view d-flex flex-column gap-2">
        <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
                <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
                <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
                <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
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
        <div class="row flex-row-reverse">
            <?php
            echo Tabs::widget([
                'options' => [
                    'class' => 'nav nav-pills left-tabs m-0 col-md-3',
                    'id' => 'quotation-tab',
                    'aria-orientation' => 'vertical',
                    'role' => 'tablist'
                ],
                'tabContentOptions' => [
                    'class' => 'col-md-9 pt-0'
                ],
                'itemOptions' => [
                    'class' => 'p-0 '
                ],
                'headerOptions' => [
                    'class' => 'p-0 text-nowrap text-start '
                ],
                'items' => [
                    [
                        'label' => 'Master Job Order',
                        'content' => $this->render('master/index', ['model' => $model]),
                        // 'url' => '#quotation-tab-quotation'
                    ],
                    [
                        'label' => 'Advance / Kasbon',
                        'content' => $this->render('cash-advance/index', [
                            'model' => $model,
                            'modelPaymentKasbon' => $modelPaymentKasbon,
                        ]),
                        // 'url' => '#quotation-tab-barang'
                    ],
                    [
                        'label' => 'Bill / Tagihan',
                        'content' => $this->render('bill/index', ['model' => $model]),
                        // 'url' => '#quotation-tab-barang'
                    ],

                ],
            ]);
            ?>
        </div>
    </div>

