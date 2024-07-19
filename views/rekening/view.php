<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rekening */

$this->title = $model->nama_bank;
$this->params['breadcrumbs'][] = ['label' => 'Rekenings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekening-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

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

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                'nama_bank',
                'nomor_rekening',
                [
                    'attribute' => 'saldo_awal',
                    'format' => ['decimal',2]
                ],
                'atas_nama',
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return \app\models\User::findOne($model->created_by)->username ?? null;
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return \app\models\User::findOne($model->updated_by)->username ?? null;
                    }
                ],
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>