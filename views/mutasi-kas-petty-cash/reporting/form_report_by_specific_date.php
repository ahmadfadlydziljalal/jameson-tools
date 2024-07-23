<?php

/* @var $this yii\web\View */
/* @var $model app\models\form\BukuBankReportPerSpecificDate */
/* @see \app\controllers\MutasiKasPettyCashController::actionReportBySpecificDate() */

use kartik\base\BootstrapInterface;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\Html;


$this->title = 'Form Report';
$this->params['breadcrumbs'][] = ['label' => 'Mutasi Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['report-by-specific-date']];

if (Yii::$app->session->getFlash('mutasiKasPettyCashReportPerSpecificDateResult')) :
    $this->params['breadcrumbs'][] = 'Result';
endif;


?>

<div class="buku-bank-reporting-form-report-by-specific-date d-flex flex-column gap-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
    </div>
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => BootstrapInterface::SIZE_SMALL]
    ]) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::class) ?>

    <div class="d-flex flex-row-reverse">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>


    <?php if (Yii::$app->session->getFlash('mutasiKasPettyCashReportPerSpecificDateResult')) : ?>
        <hr>
        <div class="buku-bank-reporting-form-report-by-specific-date-result">
            <p class="fw-bold">Result: </p>

            <div class="d-flex justify-content-between flex-wrap fw-bold">
                <p >Saldo Awal <?= $model->date ?></p>
                <p ><?= Yii::$app->formatter->asDecimal($model->balanceBeforeDate, 2) ?></p>
            </div>

            <?= $this->render('result_report_by_specific_date', [
                'model' => $model,
            ]); ?>

            <div class="d-flex flex-row-reverse">
                <?= Html::a('<i class="bi bi-printer"></i> Export to PDF', ['report-by-specific-date-to-pdf', 'attributes' => \app\components\helpers\ArrayHelper::toArray($model)], [
                    'target' => '_blank',
                    'class' => 'btn btn-primary',
                    'data-pjax' => '0',
                ]) ?>
            </div>

        </div>

    <?php endif; ?>

</div>

