<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BuktiPenerimaanBukuBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BuktiPenerimaanBukuBankController::actionIndex() */

$this->title = 'Bukti Penerimaan Buku Bank';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="bukti-penerimaan-buku-bank-index d-flex flex-column gap-3">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' By Setoran Kasir', ['bukti-penerimaan-buku-bank/create-for-setoran-kasir'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' By Invoices', ['bukti-penerimaan-buku-bank/create-for-invoices'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
    ]); ?>

</div>