<?php

use kartik\number\NumberControl;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SetoranKasir */
/* @var $modelsDetail app\models\SetoranKasirDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="setoran-kasir-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
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

    <div class="d-flex flex-column mt-0" style="gap: 1rem">

        <div class="form-master">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <?= $form->field($model, 'tanggal_setoran')->widget(\kartik\datecontrol\DateControl::class, [
                        'type' => kartik\datecontrol\DateControl::FORMAT_DATE,
                        'options' => [
                            'autofocus' => 'autofocus'
                        ]
                    ]) ?>
                    <?= $form->field($model, 'cashier_id')->textInput()->dropDownList(\app\models\Cashier::find()->map(), [
                        'prompt' => 'Pilih Cashier'
                    ])
                    ?>
                    <?= $form->field($model, 'staff_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="form-detail">

            <?php
            DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 100,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $modelsDetail[0],
                'formId' => 'dynamic-form',
                'formFields' => ['id', 'setoran_kasir_id', 'payment_method_id', 'quantity', 'total',],
            ]);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="5">Setoran kasir detail</th>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Payment method</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col" style="width: 2px">Aksi</th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                        <tr class="item">

                            <td style="width: 2px;" class="align-middle">
                                <?php if (!$modelDetail->isNewRecord) {
                                    echo Html::activeHiddenInput($modelDetail, "[$i]id");
                                } ?>
                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td>
                                <?= $form->field($modelDetail, "[$i]payment_method_id", ['template' =>
                                        '{input}{error}{hint}', 'options' => ['class' => null]]
                                )->dropDownList(\app\models\PaymentMethod::find()->map(), [
                                    'prompt' => 'Pilih Payment Method'
                                ]);
                                ?>
                            </td>
                            <td><?= $form->field($modelDetail, "[$i]quantity", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                    'class' => 'form-control quantity',
                                    'type' => 'number'
                                ]) ?>
                            </td>

                            <td><?= $form->field($modelDetail, "[$i]total", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class, [
                                    'maskedInputOptions' => [
                                        //'prefix' => $quotation->mataUang->singkatan,
                                        'allowMinus' => false
                                    ],
                                ]);  ?></td>

                            <td>
                                <button type="button" class="remove-item btn btn-link text-danger">
                                    <i class="bi bi-trash"> </i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td class="text-end" colspan="4">
                            <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="d-flex justify-content-between">
            <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>