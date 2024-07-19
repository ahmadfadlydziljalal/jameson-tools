<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TrashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\TrashController::actionIndex() */

$this->title = 'Trash';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="trash-index d-flex flex-column gap-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
    ]); ?>

</div>