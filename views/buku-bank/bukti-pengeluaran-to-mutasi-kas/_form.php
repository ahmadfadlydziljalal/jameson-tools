<?php

use app\components\helpers\ArrayHelper;
use app\models\BuktiPenerimaanBukuBank;
use app\models\BuktiPengeluaranBukuBank;
use app\widgets\modal_ajax\ModalAjaxWidget;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
        <div class="col-12 col-lg-10 col-xl-8">

            <?= $form->errorSummary($model) ?>

            <?php

            $data = [];
            if (!$model->isNewRecord) {
                $data[$model->bukti_pengeluaran_buku_bank_id] = $model->buktiPengeluaranBukuBank->reference_number;
            }

            $data = ArrayHelper::merge($data, BuktiPengeluaranBukuBank::find()
                ->notYetRegisteredAsMutasiKasPettyCashInBukuBank()
            );

            echo $form->field($model, 'bukti_pengeluaran_buku_bank_id')->widget(Select2::class, [
                'data' => $data,
                'options' => ['placeholder' => 'Pilih Bukti Pengeluaran Buku Bank'],
                'addon' => [
                    'append' => Html::a('<i class="bi bi-search"></i>', Url::to(['bukti-pengeluaran-buku-bank/view']), [
                        'class' => 'btn btn-warning btn-search',
                        'title' => 'Mark on map',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#ajax-modal',
                    ]),
                    'asButton' => true
                ],
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

<?php
$js = <<<JS
    jQuery(document).ready(function() {
        const source  = jQuery('#bukubank-bukti_pengeluaran_buku_bank_id');
        const ajaxModal = document.getElementById('ajax-modal');
        
        jQuery('.buku-bank-form .btn-search').click(function(e) {
            const url = jQuery(this).attr('href');
            jQuery(this).attr( 'href', url + '/' + source.val() );
            
            ajaxModal.addEventListener('hidden.bs.modal', () => {
                jQuery(this).attr( 'href', url );
            });
            
        });
    })
JS;

$this->registerJs($js);

?>

<?= ModalAjaxWidget::widget() ?>