<?php

use app\enums\TextLinkEnum;
use app\models\ClaimPettyCash;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Claim Petty Cashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claim-petty-cash-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="d-flex flex-row gap-2 mb-3">
        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?php
        if (Helper::checkRoute('delete')) :
            echo Html::a(TextLinkEnum::DELETE->value, ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        endif;
        ?>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <?php
            try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'nomor',
                        [
                            'attribute' => 'vendor_id',
                            'value' => $model->vendor->nama
                        ],
                        'tanggal:date',
                        'remarks:nText',
                        [
                            'attribute' => 'approved_by_id',
                            'value' => function ($model) {
                                /** @var ClaimPettyCash $model */
                                return $model->approvedBy->nama;
                            }
                        ],
                        [
                            'attribute' => 'acknowledge_by_id',
                            'value' => function ($model) {
                                /** @var ClaimPettyCash $model */
                                return $model->acknowledgeBy->nama;
                            }
                        ],
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                return app\models\User::findOne($model->created_by)->username;
                            }
                        ],
                        [
                            'attribute' => 'updated_by',
                            'value' => function ($model) {
                                return app\models\User::findOne($model->updated_by)->username;
                            }
                        ],
                    ],
                ]);
            } catch (Throwable $e) {
            }
            ?>
        </div>
    </div>

    <?php try {
        echo ListView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getClaimPettyCashNotas()
            ]),
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_view_detail', [
                    'model' => $model,
                    'index' => $index
                ]);
            },
            'layout' => '{items}'
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>

</div>