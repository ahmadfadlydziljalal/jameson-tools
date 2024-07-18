<?php

use app\assets\Bootstrap5VerticalTabs;
use app\components\helpers\ArrayHelper;
use app\models\form\PaymentKasbonForm;
use kartik\bs5dropdown\ButtonDropdown;
use mdm\admin\components\Helper;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @see app\controllers\JobOrderController::actionView() */
/* @var $modelPaymentKasbon PaymentKasbonForm */

$this->title = $model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Job Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Bootstrap5VerticalTabs::register($this);
?>

<div class="job-order-view d-flex flex-column gap-2">
    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Buat Job Order Lain',
                'dropdown' => [
                    'items' => [
                        ['label' => 'Job Order', 'url' => ['create']],
                        ['label' => 'Job Order | Petty Cash', 'url' => ['create-for-petty-cash']],
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
        $items[] = [
            'label' => 'Master Job Order',
            'content' => $this->render('master/index', ['model' => $model]),
            // 'url' => '#quotation-tab-quotation'
        ];

        if (!$model->jobOrderDetailPettyCash) {
            $items = ArrayHelper::merge($items, [
                [
                    'label' => 'Advance / Kasbon',
                    'content' => $this->render('cash-advance/index', [
                        'model' => $model,
                    ]),
                    // 'url' => '#quotation-tab-cash-advance'
                ],
                [
                    'label' => 'Bill / Tagihan',
                    'content' => $this->render('bill/index', ['model' => $model]),
                    // 'url' => '#quotation-tab-bill'
                ],
            ]);
        } else {
            $items = ArrayHelper::merge($items, [
                [
                    'label' => 'For Petty Cash',
                    'content' => $this->render('petty-cash/index', ['model' => $model,]),
                    // 'url' => '#quotation-tab-for-petty-cash'
                ],
            ]);
        }

        echo Tabs::widget([
            'options' => [
                'class' => 'nav nav-pills left-tabs m-0 col-md-3',
                'id' => 'quotation-tab',
                'aria-orientation' => 'vertical',
                'role' => 'tablist'
            ],
            'tabContentOptions' => [
                'class' => 'col-md-9 p-0 px-3'
            ],
            'itemOptions' => [
                'class' => 'p-0 '
            ],
            'headerOptions' => [
                'class' => 'p-0 text-nowrap text-start '
            ],
            'items' => $items,
        ]);
        ?>
    </div>

    <div class="d-inline-flex gap-2">
        <?php
        if ($model->getPrevious()) {
            echo Html::a('<< Previous', ['view' , 'id' => $model->getPrevious()->id], ['class' => 'btn btn-outline-primary']);
        }

        if ($model->getNext()) {
            echo Html::a('Next >>', ['view' , 'id' => $model->getNext()->id], ['class' => 'btn btn-outline-primary']);
        }
        ?>
    </div>

</div>

