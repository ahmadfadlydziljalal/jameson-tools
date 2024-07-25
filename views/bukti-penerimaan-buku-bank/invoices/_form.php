<?php

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\JenisTransfer;
use app\models\Rekening;
use kartik\datecontrol\DateControl;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPenerimaanBukuBank */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="bukti-penerimaan-buku-bank-form">

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
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="d-flex flex-column gap-3">
                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Data Customer</div>
                    <div class="card-body">
                        <?= $form->field($model, 'customer_id')->widget(Select2::class, [
                            'data' => Card::find()->map(),
                            'options' => ['placeholder' => 'Select Customer ...'],
                        ]) ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Data Transaksi</div>
                    <div class="card-body">
                        <?= $form->field($model, 'rekening_saya_id')->widget(Select2::class, [
                            'data' => Rekening::find()->mapOnlyTokoSaya('nama_bank'),
                            'options' => ['placeholder' => 'Select Rekening ...'],
                        ]) ?>
                        <?= $form->field($model, 'jenis_transfer_id')->radioList(JenisTransfer::find()->map())->inline() ?>
                        <?= $form->field($model, 'nomor_transaksi_transfer')->textInput() ?>
                        <?= $form->field($model, 'tanggal_transaksi_transfer')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                        <?= $form->field($model, 'tanggal_jatuh_tempo')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Nominal</div>
                    <div class="card-body">

                        <?= $form->field($model, 'jumlah_setor')->widget(NumberControl::class, [
                            'maskedInputOptions' => [
                                //'prefix' => $quotation->mataUang->singkatan,
                                'allowMinus' => false
                            ],
                        ])->label('Jumlah Setor') ?>

                        <?php

                        $data = [];
                        if (!$model->isNewRecord) {
                            $data = ArrayHelper::map($model->invoices, 'id', 'reference_number');
                            $model->invoiceInvoice = array_keys($data);
                            $js = new JsExpression('function(params) {
                    var selectedIds = ' . Json::encode(array_keys($data)) . '; // Get pre-selected values from the select2 element
                    return { q: params.term, id: selectedIds }; }');
                        } else {
                            $js = new JsExpression(' function(params) { return { q:params.term};}');
                        }

                        echo $form->field($model, 'invoiceInvoice')->widget(Select2::class, [
                            'data' => $data,
                            'options' => [
                                'multiple' => true,
                                'placeholder' => '...'
                            ],
                            'theme' => Select2::THEME_CLASSIC,
                            'pluginOptions' => [
                                'width' => '100%',
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => ['/invoice/find-not-in-buku-bank-yet'],
                                    'dataType' => 'json',
                                    'data' => $js
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ])
                        ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Informasi Lainnya</div>
                    <div class="card-body">
                        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
            </div>

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