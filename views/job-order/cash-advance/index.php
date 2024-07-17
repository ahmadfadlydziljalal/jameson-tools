<?php

/* @var $model app\models\JobOrder| */
/* @var $modelPaymentKasbon app\models\form\PaymentKasbonForm */

/* @var $this yii\web\View */

use app\enums\TextLinkEnum;
use kartik\grid\GridView;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

//$this->registerCss('.table-responsive{ min-height: 320px }');


$dataProvider = new ActiveDataProvider([
    'query' => $model->getJobOrderDetailCashAdvances(),
    'pagination' => false,
    'sort' => false,
]);
?>
<?php if (Yii::$app->settings->get('ui.jobOrder.kasbon') === 'listView') : ?>

    <?= Html::a('<i class="bi bi-plus-circle"></i> Tambah Kasbon', ['create-cash-advance', 'id' => $model->id], [
        'class' => 'btn btn-primary mb-3 mt-0',
    ]) ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "{items}",
        'options' => [
            'class' => 'd-flex flex-column gap-3'
        ]
    ]) ?>


<?php else : ?>

    <div class="card bg-transparent" id="cash-advance">
        <div class="card-body">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-row gap-2">
                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['create-cash-advance', 'id' => $model->id], [
                        'class' => 'btn btn-primary',
                    ]) ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => require(__DIR__ . '/_columns.php'),
                    'showPageSummary' => true
                ]) ?>
            </div>
        </div>
    </div>

<?php endif; ?>


<?php

/*$this->render('_modal_payment', [
    'modelPaymentKasbon' => $modelPaymentKasbon,
])*/ ?>