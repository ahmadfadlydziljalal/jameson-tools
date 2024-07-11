<?php

/* @var $this yii\web\View */
/* @var $model app\models\JobOrder|string|\yii\db\ActiveRecord */
/* @var $modelPaymentKasbon app\models\form\PaymentKasbonForm */
/* @see \app\controllers\JobOrderController::actionPaymentCashAdvance() */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\widgets\MaskedInput;

?>

<?php Modal::begin([
    'options' => [
        'id' => 'modalPaymentKasbonForm',
        'tabindex' => false // important for Select2 to work properly
    ],
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => TRUE
    ],
    'headerOptions' => [
        'id' => 'modalHeader'
    ],
    'title' => 'Cash Form!',
    'bodyOptions' => [
        'id' => 'modalBody'
    ]
]); ?>
<?php $form = ActiveForm::begin(['action' => ['payment-cash-advance']]); ?>
<?php echo Html::activeHiddenInput($modelPaymentKasbon, 'id') ?>
<?php echo $form->field($modelPaymentKasbon, 'change')->widget(MaskedInput::class, [
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
        'class' => 'form-control form-control-lg price'
    ]
]); ?>
<?php echo Html::tag('div', Html::submitButton('Pay!', ['class' => 'btn btn-primary']), [
    'class' => 'd-flex flex-row-reverse'
]); ?>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>

<?php
$js = <<<JS
const modalPaymentKasbonForm = document.getElementById('modalPaymentKasbonForm');
const paymentKasbonId = jQuery('#paymentkasbonform-id');

modalPaymentKasbonForm.addEventListener('show.bs.modal', event => {
  // Button that triggered the modal
  const button = event.relatedTarget;
  paymentKasbonId.val(button.getAttribute('data-id'));
});

modalPaymentKasbonForm.addEventListener('hide.bs.modal', () => {
  paymentKasbonId.val('');
});

JS;
$this->registerJs($js);
