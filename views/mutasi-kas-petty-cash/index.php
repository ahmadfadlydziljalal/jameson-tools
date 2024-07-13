<?php

use kartik\bs5dropdown\ButtonDropdown;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MutasiKasPettyCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\MutasiKasPettyCashController::actionIndex() */

$this->title = 'Mutasi Kas Petty Cash';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mutasi-kas-petty-cash-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= ButtonDropdown::widget([
                'label' => 'Debit',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => '<span class="bi bi-dot"></span> Bukti Penerimaan',
                            'url' => ['create-by-bukti-penerimaan-petty-cash']
                        ],
                        [
                            'label' => '<span class="bi bi-dot"></span> Lainnya (Other)',
                            'url' => ['create-by-penerimaan-lainnya']
                        ],
                    ],
                    'encodeLabels' => false,
                ],
                'encodeLabel' => false,
                'buttonOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]) ?>
            <?= ButtonDropdown::widget([
                'label' => 'Credit',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => '<span class="bi bi-dot"></span> Bukti Pengeluaran',
                            'url' => ['create-by-bukti-pengeluaran-petty-cash']
                        ],
                        [
                            'label' => '<span class="bi bi-dot"></span> Lainnya (Other)',
                            'url' => ['create-by-pengeluaran-lainnya']
                        ],
                    ],
                    'encodeLabels' => false,
                ],
                'encodeLabel' => false,
                'buttonOptions' => [
                    'class' => 'btn btn-secondary'
                ]
            ]) ?>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
        'tableOptions' => [
            'class' => 'table table-grid-view table-fixes-last-column'
        ],
    ]);?>

</div>