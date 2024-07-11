<?php

/* @var $this View */
/* @var $model app\models\BuktiPenerimaanPettyCash*/

use app\components\helpers\ArrayHelper;
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
                $data [$model->buktiPenerimaanPettyCashCashAdvance->bukti_pengeluaran_petty_cash_cash_advance_id] =
                    $model->buktiPenerimaanPettyCashCashAdvance->buktiPengeluaranPettyCashCashAdvance->buktiPengeluaranPettyCash->reference_number . ' - ' .
                    $model->buktiPenerimaanPettyCashCashAdvance->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - ' .
                    "Kasbon ke " . $model->buktiPenerimaanPettyCashCashAdvance->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order . ' - ' .
                    $model->buktiPenerimaanPettyCashCashAdvance->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name . ' - ' .
                    Yii::$app->formatter->asDecimal($model->buktiPenerimaanPettyCashCashAdvance->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance, 2)
                ;
                $model->buktiPengeluaranKasbonReferenceNumber = $model->buktiPenerimaanPettyCashCashAdvance->bukti_pengeluaran_petty_cash_cash_advance_id;
            }
            $data = ArrayHelper::merge($data, BuktiPengeluaranPettyCashCashAdvance::find()->notYetRealization());
            echo $form->field($model, 'buktiPengeluaranKasbonReferenceNumber')->widget(Select2::class,[
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
