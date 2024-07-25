<?php

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\JenisTransfer;
use app\models\JobOrderDetailCashAdvance;
use app\models\Rekening;
use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BuktiPengeluaranBukuBank */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="bukti-pengeluaran-buku-bank-form">

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
                    <div class="card-header"><i class="bi bi-table"></i> Data Vendor</div>
                    <div class="card-body">
                        <?= $form->field($model, 'vendor_id')->widget(Select2::class, [
                            'data' => Card::find()->map(),
                            'options' => ['placeholder' => 'Pilih Vendor'],
                        ]) ?>

                        <?php
                        $data = [];
                        echo $form->field($model, 'vendor_rekening_id')->widget(DepDrop::class, [
                            'type' => DepDrop::TYPE_DEFAULT,
                            'data' => $data,
                            'pluginOptions' => [
                                'depends' => [
                                    'buktipengeluaranbukubank-vendor_id'
                                ],
                                'url' => Url::to(['/card/depdrop-find-rekening-card-id'])
                            ],
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => 'Select...',
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Data Transaksi</div>
                    <div class="card-body">
                        <?= $form->field($model, 'rekening_saya_id')->widget(Select2::class, [
                            'data' => Rekening::find()->mapOnlyTokoSaya(),
                            'options' => ['placeholder' => 'Pilih Rekening'],
                        ]) ?>
                        <?= $form->field($model, 'jenis_transfer_id')->radioList(JenisTransfer::find()->map())->inline() ?>
                        <?= $form->field($model, 'nomor_bukti_transaksi')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'tanggal_transaksi')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-table"></i> Pelunasan Kasbon</div>
                    <div class="card-body">
                        <?php
                        $data = [];
                        if (!$model->isNewRecord) {
                            $data = ArrayHelper::map($model->jobOrderDetailCashAdvances, 'id', function ($model) {
                                return  'Kasbon ke: ' . $model->order . ', ' . $model->jobOrder->reference_number
                                    . ', Panjar ' . Yii::$app->formatter->asDecimal($model->cash_advance, 2);
                            });
                            $model->cashAdvances = array_keys($data);
                        }

                        $data = ArrayHelper::merge($data, JobOrderDetailCashAdvance::find()->notYetRegistered());
                        echo $form->field($model, 'cashAdvances')->widget(Select2::class, [
                            'data' => $data,
                            'options' => [
                                'multiple' => true,
                                'placeholder' => '...'
                            ],
                            'theme' => Select2::THEME_CLASSIC,
                            'pluginOptions' => [
                                'width' => '100%',
                                'allowClear' => true,
                                /*'minimumInputLength' => 3,
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
                                'templateSelection' => new JsExpression('function (city) { return city.text; }'),*/
                            ],
                        ]) ?>
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
                <?= Html::a('Close', ['index'], ['class' => 'btn btn-secondary', 'type' => 'button']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>