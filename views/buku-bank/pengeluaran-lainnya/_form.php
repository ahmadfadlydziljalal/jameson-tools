<?php

use app\models\Card;
use app\models\JenisBiaya;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $modelTransaksiLainnya app\models\TransaksiBukuBankLainnya */

?>

<div class="mutasi-kas-petty-cash-form">

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
            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'tanggal_transaksi')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
            <?= $form->field($modelTransaksiLainnya, 'card_id')->widget(Select2::class, [
                'data' => Card::find()->map(),
                'options' => [
                    'placeholder' => 'Pilih Card ...',
                ]
            ]) ?>
            <?= $form->field($modelTransaksiLainnya, 'jenis_biaya_id')->widget(Select2::class, [
                'data' => JenisBiaya::find()->map(),
                'options' => [
                    'placeholder' => 'Pilih Card ...',
                ]
            ]) ?>
            <?= $form->field($modelTransaksiLainnya, 'nominal')->widget(MaskedInput::class, [
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
                    'class' => 'form-control harga'
                ]
            ]); ?>
            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a('Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>