<?php

/* @var $model app\models\JobOrder| */
/* @var $modelPaymentKasbon app\models\form\PaymentKasbonForm */
/* @var $this yii\web\View */

use app\enums\TextLinkEnum;
use kartik\grid\GridView;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;

//$this->registerCss('.table-responsive{ min-height: 320px }');
?>

<div class="card bg-transparent" id="cash-advance">
    <div class="card-body">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row gap-2">
                <?= Html::a(TextLinkEnum::TAMBAH->value, ['create-cash-advance', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getJobOrderDetailCashAdvances()
                ]),
                'columns' => require(__DIR__ . '/_columns.php'),
                'showPageSummary' => true
            ]) ?>
        </div>
    </div>
</div>

<?= $this->render('_modal_payment',[
    'modelPaymentKasbon' => $modelPaymentKasbon,
]) ?>