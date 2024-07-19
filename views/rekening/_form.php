<?php

use app\models\Card;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rekening */
/* @var $modelsDetail app\models\RekeningDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="rekening-form">

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
                    <?= $form->field($model, 'card_id')->widget(Select2::class, [
                        'data' => Card::find()->map(),
                        'options' => [
                            'placeholder' => '= Pilih salah satu ='
                        ]
                    ]) ?>

                    <?= $form->field($model, 'nama_bank')->textInput() ?>
                    <?= $form->field($model, 'nomor_rekening')->textInput() ?>
                    <?= $form->field($model, 'saldo_awal')->widget(\kartik\number\NumberControl::class) ?>

                    <?= $form->field($model, 'atas_nama')->textarea([
                        'rows' => 6,
                        'autofocus' => 'autofocus'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>