<?php

use app\components\helpers\ArrayHelper;
use app\models\BuktiPenerimaanBukuBank;
use app\models\BuktiPengeluaranBukuBank;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="buku-bank-form">

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

            <?php
            $data = [];

            if (!$model->isNewRecord) {
                // TODO
            }

            $data = ArrayHelper::merge($data, BuktiPengeluaranBukuBank::find()->notYetRegisteredInBukuBank());
            echo $form->field($model, 'bukti_pengeluaran_buku_bank_id')->widget(Select2::class, [
                'data' => $data,
                'options' => ['placeholder' => 'Pilih Bukti Pengeluaran Buku Bank'],
            ]) ?>
            <?= $form->field($model, 'tanggal_transaksi')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

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