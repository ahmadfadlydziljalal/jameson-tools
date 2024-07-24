<?php

use kartik\bs5dropdown\ButtonDropdown;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BuktiPengeluaranBukuBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BuktiPengeluaranBukuBankController::actionIndex() */

$this->title = 'Bukti Pengeluaran Buku Bank';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bukti-pengeluaran-buku-bank-index d-flex flex-column gap-3">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Buat',
                'dropdown' => [
                    'items' => [
                        ['label' => 'By Kasbon / Cash Advance', 'url' => ['create-by-cash-advance']],
                        ['label' => 'By Payment Bill', 'url' => ['create-by-bill']],
                        ['label' => 'By Payment Petty Cash', 'url' => ['create-by-petty-cash']],
                    ],
                    'options' => [
                        'class' => 'dropdown-menu-right',
                    ],
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-primary',
                ],
                'encodeLabel' => false
            ]); ?>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
        'tableOptions' => [
            'class' => 'table table-gridview table-fixes-last-column'
        ],
    ]); ?>

</div>