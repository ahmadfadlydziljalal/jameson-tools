<?php

use app\enums\JenisBiayaCategoryEnum;
use app\models\Card;
use app\models\JenisBiaya;
use app\models\MataUang;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderDetailCashAdvance */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="job-order-detail-cash-advance-form">

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

            <?= $form->field($model, 'vendor_id')->widget(Select2::class, [
                'data' => Card::find()->map(),
                'options' => [
                    'placeholder' => '...'
                ]
            ]) ?>
            <?= $form->field($model, 'jenis_biaya_id')->widget(Select2::class, [
                'data' => JenisBiaya::find()->mapCategory(JenisBiayaCategoryEnum::CASH_ADVANCE),
                'options' => [
                    'placeholder' => '...'
                ]
            ]) ?>
            <?= $form->field($model, 'mata_uang_id')->widget(Select2::class, [
                'data' => MataUang::find()->map(),
                'options' => [
                    'placeholder' => '...'
                ]
            ]) ?>
            <?= $form->field($model, 'kasbon_request') ->widget(MaskedInput::class, [
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
            ]); ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a(' Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>