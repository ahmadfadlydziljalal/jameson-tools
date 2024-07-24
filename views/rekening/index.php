<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RekeningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @see \app\controllers\RekeningController::actionIndex() */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Rekening';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="rekening-index d-flex flex-column gap-3">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
    ]); ?>

</div>