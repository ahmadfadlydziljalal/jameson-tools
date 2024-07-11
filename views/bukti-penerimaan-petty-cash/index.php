<?php

use kartik\grid\GridView;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BuktiPenerimaanPettyCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BuktiPenerimaanPettyCashController::actionIndex() */

$this->title = 'Bukti Penerimaan Petty Cash';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bukti-penerimaan-petty-cash-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah',
                'dropdown' => [
                    'items' => [
                        ['label' => 'By Pengembalian / Realisasi Kasbon', 'url' => ['create-by-realisasi-kasbon']],
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

    <h1 class="text-danger">TODO Tambah melalui Buku Bank Belum ada</h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
    ]); ?>

</div>