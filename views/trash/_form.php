<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trash */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="trash-form">

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

            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'autofocus' => 'autofocus'
            ]) ?>
            <?= $form->field($model, 'key')->textInput() ?>
            <?= $form->field($model, 'data')->textarea([
                    'rows' => 12
            ]) ?>

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