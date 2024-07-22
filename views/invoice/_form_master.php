<?php

/* @var $form yii\bootstrap5\ActiveForm */
/* @var $this yii\web\View */
/* @var $model Invoice */

use app\models\Card;
use app\models\Invoice;
use app\models\Rekening;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;

?>

<div class="form-master">
    <div class="row">
        <div class="col-12 col-lg-7">
            <?= $form->field($model, 'customer_id')->widget(Select2::class, [
                'data' => Card::find()->map(),
                'options' => [
                    'placeholder' => '...',
                ]
            ]) ?>
            <?= $form->field($model, 'tanggal_invoice')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
            <?= $form->field($model, 'nomor_rekening_tagihan_id')->dropDownList(Rekening::find()->mapOnlyTokoSaya(),[
                'prompt' => '...'
            ]) ?>
        </div>
    </div>
</div>