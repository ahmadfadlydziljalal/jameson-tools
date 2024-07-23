<?php

/* @var $this yii\web\View */
/* @var $model app\models\form\BukuBankReportPerSpecificDate */

/* @see \app\controllers\BukuBankController::actionReportBySpecificDate() */

use app\models\Rekening;
use kartik\base\BootstrapInterface;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;


$this->title = 'Form Report';
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['report-by-specific-date']];

if (Yii::$app->session->getFlash('bukuBankReportPerSpecificDateResult')) :
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
    <?= $form->field($model, 'rekening')->widget(Select2::class, [
        'data' => Rekening::find()->mapOnlyTokoSaya()
    ]) ?>

    <div class="d-flex flex-row-reverse">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

    <?php if (Yii::$app->session->getFlash('bukuBankReportPerSpecificDateResult')) : ?>
        <hr>
        <div class="buku-bank-reporting-form-report-by-specific-date-result">
            <p class="fw-bold">Result: </p>
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

