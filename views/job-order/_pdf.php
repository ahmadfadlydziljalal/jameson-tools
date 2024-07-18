<?php

/* @var $this View */
/* @var $model JobOrder */

/* @see \app\controllers\JobOrderController::actionExportToPdf() */

use app\models\JobOrder;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>

<div class="content-section">
    <h1 class="text-center">Job Order</h1>

    <!-- Header -->
    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 31%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">No.</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->reference_number ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Date</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= Yii::$app->formatter->asDate($model->created_at) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-1" style=" float: right; width: 48%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">Kepada (Vendor).</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->mainVendor->nama ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Ditagihkan (Customer)</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->mainCustomer->nama ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Kasbon -->
    <?php if ($model->jobOrderDetailCashAdvances) : ?>
        <p>Kasbon / Cash Advance</p>
        <?php
        $columns = require __DIR__ . '/cash-advance/_columns.php';
        array_pop($columns);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-gridview'],
            'layout' => "{items}",
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getJobOrderDetailCashAdvances(),
                'pagination' => false,
                'sort' => false,
            ]),
            'columns' => $columns,
            'showPageSummary' => true
        ]);
        ?>
    <?php endif; ?>

    <!-- Bill -->
    <?php if ($model->jobOrderBills) : ?>
        <p>Tagihan Biaya / Bill</p>
        <?php
        $columns = require __DIR__ . '/bill/_columns.php';
        array_pop($columns);
        unset($columns[1]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-gridview'],
            'layout' => "{items}",
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getJobOrderBills(),
                'pagination' => false,
                'sort' => false,
            ]),
            'columns' => $columns,
            'showPageSummary' => true
        ]);
        ?>
    <?php endif; ?>

    <!-- Petty Cash -->
    <?php if ($model->jobOrderDetailPettyCash) : ?>
        <p>Request Petty Cash</p>
        <?php
        $columns = require __DIR__ . '/petty-cash/_columns.php';
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-gridview'],
            'layout' => "{items}",
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getJobOrderDetailPettyCash(),
                'pagination' => false,
                'sort' => false,
            ]),
            'columns' => $columns,
        ]);
        ?>
    <?php endif; ?>

    <p>Keterangan:</p>
    <span><?= empty($model->keterangan) ? '' : nl2br($model->keterangan) ?></span>

    <hr>

    <!-- Signature -->
    <table class="table table-borderless mt-1" style="page-break-inside: avoid">
        <thead>
        <tr>
            <td style="width: 50%" class="text-center">Dibuat Oleh</td>
            <td style="width: 50%" class="text-center">Diketahui Oleh</td>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td class="text-center" style="height: 6em"><?= Yii::$app->user->identity->username ?></td>
            <td class="text-center"></td>
        </tr>

        <tr>
            <td class="text-center"></td>
            <td class="text-center">
                (
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )
            </td>
        </tr>
        </tbody>
    </table>
</div>
