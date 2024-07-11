<?php

use app\enums\TextLinkEnum;
use app\models\Barang;
use app\models\BarangSatuan;
use app\models\ProformaDebitNote;
use app\models\ProformaDebitNoteDetailBarang;
use app\models\Quotation;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaDebitNote|null|string|ActiveRecord */
/* @var $modelsDetail ProformaDebitNoteDetailBarang[]|string */

?>

<div class="quotation-form">
   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form'
   ]) ?>

   <?php DynamicFormWidget::begin([
      'widgetContainer' => 'dynamicform_wrapper',
      'widgetBody' => '.container-items',
      'widgetItem' => '.item',
      'limit' => 100,
      'min' => 1,
      'insertButton' => '.add-item',
      'deleteButton' => '.remove-item',
      'model' => $modelsDetail[0],
      'formId' => 'dynamic-form',
      'formFields' => ['id', 'barang_id', 'satuan_id', 'stock', 'quantity', 'unit_price', 'discount'],
   ]); ?>

    <div class="d-flex flex-column gap-3 container-items">

       <?php foreach ($modelsDetail as $i => $model) : ?>

           <div class="card rounded border-0 shadow item">

               <div class="card-header d-flex justify-content-between">
                  <?php if (!$model->isNewRecord) {
                     echo Html::activeHiddenInput($model, "[$i]id");
                  } ?>

                  <?= Html::tag('span', 'Barang', ['class' => 'fw-bold']) ?>
                  <?= Html::button('<i class="bi bi-x-lg"> </i>', [
                     'class' => 'remove-item btn btn-danger btn-sm rounded-circle'
                  ]) ?>
               </div>

               <div class="card-body">

                   <div class="row row-cols-2 row-cols-lg-4">

                       <!-- Barang ID -->
                       <div class="col">
                          <?= $form->field($model, "[$i]barang_id")
                             ->widget(Select2::class, [
                                'data' => Barang::find()->map(),
                                'options' => [
                                   'prompt' => '= Pilih Salah Satu =',
                                   'class' => 'form-control barang'
                                ],
                             ]);
                          ?>
                       </div>

                       <!-- Satuan ID -->
                       <div class="col">
                          <?php
                          $data2 = [];
                          if (Yii::$app->request->isPost || !$model->isNewRecord) {
                             if ($model->satuan_id) $data2 = BarangSatuan::find()->mapSatuan($model->barang_id);
                          }
                          ?>
                          <?= $form->field($model, "[$i]satuan_id")
                             ->widget(DepDrop::class, [
                                'data' => $data2,
                                'pluginOptions' => [
                                   'initialize' => true,
                                   'depends' => [
                                      'proformadebitnotedetailbarang-' . $i . '-barang_id'
                                   ],
                                   'url' => Url::to(['barang/depdrop-find-satuan-by-barang'])
                                ],
                                'options' => [
                                   'class' => 'form-control satuan',
                                   'placeholder' => 'Select...',
                                ]
                             ]);
                          ?>
                       </div>

                       <!-- Stock -->
                       <div class="col">
                          <?= $form->field($model, "[$i]stock")->textInput([
                             'class' => 'form-control stock',
                             'type' => 'number'
                          ]) ?>
                       </div>

                       <!-- Quantity -->
                       <div class="col">
                          <?= $form->field($model, "[$i]quantity")->textInput([
                             'class' => 'form-control quantity',
                             'type' => 'number'
                          ]) ?>
                       </div>

                   </div>

                   <div class="row row-cols-2 row-cols-lg-4">

                       <!-- Unit Price -->
                       <div class="col">
                          <?= $form->field($model, "[$i]unit_price")->widget(NumberControl::class, [
                             'maskedInputOptions' => [
                                'prefix' => $quotation->mataUang->singkatan,
                                'allowMinus' => false
                             ],
                          ]); ?>
                       </div>

                       <!-- Discount -->
                       <div class="col">
                          <?= $form->field($model, "[$i]discount")->textInput([
                             'class' => 'form-control quantity',
                             'type' => 'number'
                          ]) ?>
                       </div>

                   </div>

               </div>

           </div>

       <?php endforeach; ?>

    </div>
    <div class="d-flex justify-content-center my-2">
       <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
    </div>

   <?php DynamicFormWidget::end() ?>

    <div class="d-flex justify-content-between">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>
   <?php ActiveForm::end() ?>
</div>