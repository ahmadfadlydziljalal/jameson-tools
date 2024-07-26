<?php

use app\components\helpers\ArrayHelper;
use app\models\JobOrderBill;
use kartik\datecontrol\DateControl;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

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

            <?= $form->field($model, 'tanggal_transaksi')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>

            <?php
            $data = [];
            if (!$model->isNewRecord) {
                $data[$model->jobOrderBill->id] = $model->jobOrderBill->jobOrder->reference_number . ' - ' .
                    $model->jobOrderBill->vendor->nama . ' - ' .
                    Yii::$app->formatter->asDecimal($model->jobOrderBill->getTotalPrice(), 2);

                $model->jobOrderBillReferenceNumber = $model->jobOrderBill->id;
            }

            $data = ArrayHelper::merge($data, JobOrderBill::find()->notYetRegistered());
            echo $form->field($model, 'jobOrderBillReferenceNumber')
                ->dropDownList($data)/*->widget(Select2::class, [
                    'data' => $data,
                    'options' => [
                        'placeholder' => 'Pilih Bill ...',
                    ]
                ])*/
            ;
            ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a('Close', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>