<?php

/* @var $this View */

/* @var $model BuktiPengeluaranPettyCash|string|ActiveRecord */

use app\models\BuktiPengeluaranPettyCash;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="">
    <h2><strong>Kasbon / Cash Advance</strong></h2>
    <?= DetailView::widget([
        'model' => $model->jobOrderDetailCashAdvance,
        'attributes' => [
            [
                'attribute' => 'jenis_biaya_id',
                'value' => $model->jobOrderDetailCashAdvance->jenisBiaya->name,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'vendor_id',
                'value' => $model->jobOrderDetailCashAdvance->vendor->nama,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'mata_uang_id',
                'value' => $model->jobOrderDetailCashAdvance->mataUang->singkatan,
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
            ],
            [
                'attribute' => 'kasbon_request',
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right;',
                ],
            ],
            [
                'attribute' => 'cash_advance',
                'format' => ['decimal', 2],
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right;',
                ],
            ],
            [
                'attribute' => 'order',
                'captionOptions' => [
                    'style' => 'text-align:left;',
                ],
                'contentOptions' => [
                    'style' => 'text-align:right;',
                ],
            ],
        ]
    ]) ?>
</div>
