<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="barang-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>
    </div>


    <div class="row">

        <div class="col-12 col-lg-8">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'options' => [
                    'class' => 'table table-bordered table-detail-view'
                ],
                'attributes' => [
                    'nama',
                    [
                        'attribute' => 'price_per_item_in_idr',
                        'format' => ['decimal', 2],
                    ],
                    [
                        'attribute' => 'price_per_item_in_idr',
                        'value' => Yii::$app->formatter->asSpellout($model->price_per_item_in_idr),
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-12 col-lg-4">


        </div>

    </div>

    <?= $this->render('_view_detail', ['model' => $model]) ?>


</div>