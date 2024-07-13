<?php

use app\components\helpers\ArrayHelper;
use app\models\JobOrderDetailCashAdvance;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranPettyCash */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="bukti-pengeluaran-petty-cash-form">

    <?php $form = ActiveForm::begin([

        'layout' => ActiveForm::LAYOUT_HORIZONTAL,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 col-form-label',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],

        /*'layout' => ActiveForm::LAYOUT_FLOATING,
            'fieldConfig' => [
            'options' => [
            'class' => 'form-floating'
            ]
        ]*/

    ]); ?>

    <div class="row">
        <div class="col-12 col-lg-8">

            <?php
            $data = [];
            if(!$model->isNewRecord){
                $data [$model->job_order_detail_cash_advance_id] =
                    "Kasbon ke " . $model->jobOrderDetailCashAdvance->order . ': ' .
                    $model->jobOrderDetailCashAdvance->jobOrder->reference_number;
            }
            $data = ArrayHelper::merge($data, JobOrderDetailCashAdvance::find()->notYetRegistered());
            echo $form->field($model, 'job_order_detail_cash_advance_id')->widget(Select2::class,[
                'data' => $data,
                'options' => [
                    'placeholder' => 'Pilih Kasbon ...',
                ]
            ]);
            ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a('Close', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' =>'btn btn-success' ]) ?>
            </div>

        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>