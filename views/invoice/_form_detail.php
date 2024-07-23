<?php

/* @var $form \yii\base\Widget|\yii\bootstrap5\ActiveForm */
/* @var $this \yii\web\View */
/* @var $model \app\models\Invoice|string|\yii\db\ActiveRecord */

/* @var $modelsDetail \app\models\InvoiceDetail|string */

use app\models\Barang;
use app\models\BarangSatuan;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

?>


<div class="form-detail">

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $modelsDetail[0],
        'formId' => 'dynamic-form',
        'formFields' => ['id', 'invoice_id', 'quantity', 'satuan_id', 'barang_id', 'harga',],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="6">Invoice detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Barang</th>
                <th scope="col">Quantity</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga</th>
                <th scope="col" style="width: 2px">Aksi</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                <tr class="item">

                    <td style="width: 2px;" class="align-middle">
                        <?php if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                        } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td><?php

                        $data = [];
                        echo $form->field($modelDetail, "[$i]barang_id", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->widget(Select2::class,
                            [
                                'data' =>$data,
                                'options' => [
                                    'prompt' => '= Pilih Salah Satu =',
                                    'class' => 'form-control barang'
                                ],
                                'pluginOptions' => [
                                    'width' => '100%',
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => ['/barang/find-by-id'],
                                        'dataType' => 'json',
                                        'data' => new JsExpression(' function(params) { return { q:params.term};}')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                ],
                            ]);
                    ?>
                    </td>

                    <td>
                        <?= $form->field($modelDetail, "[$i]quantity", [
                                'template' => '{input}{error}{hint}', 'options' => ['class' => null]]
                        )->textInput([
                            'class' => 'form-control quantity',
                            'type' => 'number'
                        ])
                        ?>
                    </td>

                    <td>
                        <?php
                        $data2 = [];
                        if (Yii::$app->request->isPost || !$model->isNewRecord) {
                            if ($modelDetail->satuan_id) $data2 = BarangSatuan::find()->mapSatuan($modelDetail->barang_id);
                        }
                        ?>
                        <?= $form->field($modelDetail, "[$i]satuan_id", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->widget(DepDrop::class, [
                                'data' => $data2,
                                'pluginOptions' => [
                                    'initialize' => true,
                                    'depends' => [
                                        'invoicedetail-' . $i . '-barang_id'
                                    ],
                                    'url' => Url::to(['barang/depdrop-find-satuan-by-barang'])
                                ],
                                'options' => [
                                    'class' => 'form-control satuan',
                                    'placeholder' => 'Select...',
                                ]
                            ]);
                        ?>
                    </td>

                    <td><?= $form->field($modelDetail, "[$i]harga", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class, [
                            'maskedInputOptions' => [
                                //'prefix' => $quotation->mataUang->singkatan,
                                'allowMinus' => false
                            ],
                        ]); ?>
                    </td>

                    <td>
                        <button type="button" class="remove-item btn btn-link text-danger">
                            <i class="bi bi-trash"> </i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

            <tfoot>
            <tr>
                <td class="text-end" colspan="5">
                    <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                </td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>
</div>
