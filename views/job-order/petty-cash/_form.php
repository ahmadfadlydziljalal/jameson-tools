<?php

use app\enums\JenisBiayaCategoryEnum;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\JobOrderDetailPettyCash;
use app\models\MataUang;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $modelDetail JobOrderDetailPettyCash */
?>

<div class="job-order-form">


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
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="d-flex flex-column gap-3">
                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Data Master</div>
                    <div class="card-body">
                        <?= $form->field($model, 'main_vendor_id')->widget(Select2::class, [
                            'data' => Card::find()->map(),
                            'options' => [
                                'placeholder' => '...'
                            ]
                        ]) ?>
                        <?= $form->field($model, 'main_customer_id')->widget(Select2::class, [
                            'data' => Card::find()->map(),
                            'options' => [
                                'placeholder' => '...'
                            ]
                        ]) ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Data Petty Cash</div>
                    <div class="card-body">
                        <?= $form->field($modelDetail, 'jenis_biaya_id')->widget(Select2::class, [
                            'data' => JenisBiaya::find()->mapCategory(JenisBiayaCategoryEnum::PETTY_CASH),
                            'options' => [
                                'placeholder' => '...'
                            ]
                        ]) ?>

                        <?= $form->field($modelDetail, 'vendor_id')->widget(Select2::class, [
                            'data' => Card::find()->map(),
                            'options' => [
                                'placeholder' => '...'
                            ]
                        ])->hint('Kepada siapa Petty Cash akan diberikan') ?>

                        <?= $form->field($modelDetail, 'mata_uang_id')->widget(Select2::class, [
                            'data' => MataUang::find()->map(),
                            'options' => [
                                'placeholder' => '...'
                            ]
                        ]); ?>

                        <?= $form->field($modelDetail, 'nominal')->widget(NumberControl::class, [
                            'maskedInputOptions' => [
                                'allowMinus' => false
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Informasi Lainnya</div>
                    <div class="card-body">
                        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
            </div>


            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a('Close', ['index'], ['class' => 'btn btn-secondary', 'type' => 'button']) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>