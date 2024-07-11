<?php

use yii\bootstrap5\ButtonDropdown;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BuktiPengeluaranPettyCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BuktiPengeluaranPettyCashController::actionIndex() */

$this->title = 'Bukti Pengeluaran Petty Cash';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bukti-pengeluaran-petty-cash-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?=   ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah',
                'dropdown' => [
                    'items' => [
                        ['label' => 'By Kasbon / Cash Advance', 'url' => ['create-by-cash-advance']],
                        ['label' => 'By Payment Bill', 'url' => ['create-by-bill']],
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

    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
    ]); ?>

</div>