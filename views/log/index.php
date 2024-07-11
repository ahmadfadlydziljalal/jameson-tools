<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\LogController::actionIndex() */

$this->title = 'Log';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="log-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?php try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'itemOptions' => [
                'class' => 'mb-3'
            ]
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>