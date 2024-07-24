<?php

use app\enums\TextLinkEnum;
use app\models\CardType;
use kartik\form\ActiveForm;
use yii\helpers\Html;


/** @var yii\web\View $this */
/** @var app\models\search\CardSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card-search">

   <?php $form = ActiveForm::begin([
      'action' => ['index'],
      'method' => 'get',
      'type' => ActiveForm::TYPE_INLINE,
      'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
      'fieldConfig' => ['options' => ['class' => 'form-group me-1']], // spacing field groups
      'formConfig' => ['showErrors' => true],
      'options' => ['style' => 'align-items: flex-start'] // set style for proper tooltips error display

   ]); ?>

   <?= $form->field($model, 'nama')->textInput(['placeholder' => 'Cari by nama']) ?>
   <?= $form->field($model, 'kode') ?>
   <?= $form->field($model, 'cardTypeName')->dropDownList(CardType::find()->map(), [
      'prompt' => '= Pilih Type ='
   ]) ?>

    <div class="form-group me-1">
        <div class="d-flex flex-row gap-1">
           <?= Html::submitButton(TextLinkEnum::SEARCH->value, ['class' => 'btn btn-primary']) ?>
            <div class="ms-auto">
               <?= Html::a('<i class="bi bi-repeat"></i>' . ' Reset', ['index'], ['class' => 'btn btn-outline-primary', 'title' => 'Reset Filter']) ?>
            </div>
        </div>
    </div>

   <?php ActiveForm::end(); ?>

</div>