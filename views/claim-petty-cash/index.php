<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ClaimPettyCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Claim Petty Cash';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="claim-petty-cash-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('<i class="bi bi-repeat"></i>' . ' Reset Filter', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-grid-view table-fixes-last-column'
            ],
            'columns' => require(__DIR__ . '/_columns.php'),
            'panel' => false,
            'bordered' => true,
            'striped' => false,
            'headerContainer' => [],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>

</div>