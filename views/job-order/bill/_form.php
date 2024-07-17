<?php

use app\enums\JenisBiayaCategoryEnum;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\JobOrderBill;
use app\models\JobOrderBillDetail;
use app\models\Satuan;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model JobOrderBill|string|ActiveRecord */
/* @var $modelsDetail JobOrderBillDetail[]|array|string */
?>

<div class="job-order-bill-form">

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
                    <?= $form->field($model, 'vendor_id')->widget(Select2::class, [
                        'data' => Card::find()->map(),
                        'options' => ['placeholder' => '...'],
                    ]) ?>
                    <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>
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
                'formFields' => ['id', 'job_order_bill_id', 'jenis_biaya_id', 'quantity', 'satuan_id', 'name', 'price',],
            ]);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jenis Biaya</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
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
                                <?= $form->field($modelDetail, "[$i]jenis_biaya_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                                    ->dropDownList(
                                        JenisBiaya::find()->mapCategory([JenisBiayaCategoryEnum::EXPENSE, JenisBiayaCategoryEnum::COST]), [
                                        'prompt' => '= Pilih Salah Satu ='
                                    ]) ?>
                            </td>
                            <td><?= $form->field($modelDetail, "[$i]quantity", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]])->widget(MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'numeric',
                                        'digits' => 2,
                                        'groupSeparator' => ',',
                                        'radixPoint' => '.',
                                        'autoGroup' => true,
                                        'autoUnmask' => true,
                                        'removeMaskOnSubmit' => true
                                    ],
                                    'options' => [
                                        'class' => 'form-control kasbon-request'
                                    ]
                                ]); ?></td>
                            <td><?= $form->field($modelDetail, "[$i]satuan_id", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]])->dropDownList(Satuan::find()->map(), [
                                    'prompt' => '= Pilih Salah Satu ='
                                ]) ?></td>
                            <td><?= $form->field($modelDetail, "[$i]name", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]]); ?></td>
                            <td><?= $form->field($modelDetail, "[$i]price", ['template' =>
                                    '{input}{error}{hint}', 'options' => ['class' => null]])->widget(MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'numeric',
                                        'digits' => 2,
                                        'groupSeparator' => ',',
                                        'radixPoint' => '.',
                                        'autoGroup' => true,
                                        'autoUnmask' => true,
                                        'removeMaskOnSubmit' => true
                                    ],
                                    'options' => [
                                        'class' => 'form-control kasbon-request'
                                    ]
                                ]); ?></td>

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
                        <td class="text-end" colspan="6">
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
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
