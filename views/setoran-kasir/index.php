<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SetoranKasirSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Setoran Kasir';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="setoran-kasir-index d-flex flex-column gap-2">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php try {
        echo GridView::widget([
            'tableOptions' => [
                'class' => 'table table-gridview table-fixes-last-column'
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__ . '/_columns.php'),
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>