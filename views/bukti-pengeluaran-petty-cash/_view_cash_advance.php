<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\BuktiPengeluaranPettyCash|string|\yii\db\ActiveRecord */

use yii\widgets\DetailView;

?>

<div class="">
    <p><strong>Kasbon / Cash Advance</strong></p>

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
