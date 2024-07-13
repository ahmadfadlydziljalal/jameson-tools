<?php

/* @var $this View */
/* @var $model app\models\BuktiPenerimaanPettyCash*/

use app\components\helpers\ArrayHelper;
use app\models\BuktiPengeluaranPettyCash;
use app\models\BuktiPengeluaranPettyCashCashAdvance;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

?>

<div class="bukti-penerimaan-petty-cash-form">

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
        <div class="col-12 col-lg-12">

            <?php

            $data = [];
            if(!$model->isNewRecord){
                $data [$model->bukti_pengeluaran_petty_cash_cash_advance_id] =
                    "Kasbon ke " . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order . ' - ' .
                    $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - ' .
                    $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name . ' - ' .
                    Yii::$app->formatter->asDecimal($model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance, 2) . ' - '  .
                    $model->buktiPengeluaranPettyCashCashAdvance->reference_number
                ;
            }
            $data = ArrayHelper::merge($data, BuktiPengeluaranPettyCash::find()->cashAdvanceNotYetRealization());
            echo $form->field($model, 'bukti_pengeluaran_petty_cash_cash_advance_id')->widget(Select2::class,[
                'data' => $data,
                'options' => ['placeholder' => 'Pilih Bukti Pengeluaran Kasbon'],
            ])?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a(' Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' =>'btn btn-success' ]) ?>

            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
