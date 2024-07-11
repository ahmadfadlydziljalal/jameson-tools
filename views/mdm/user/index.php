<?php

use app\models\User;
use mdm\admin\components\Helper;
use yii\bootstrap5\ButtonDropdown;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = (!Yii::$app->settings->get('site.name') ? Yii::$app->name : Yii::$app->settings->get('site.name')) . ' ' . Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('Tambah User', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['assignment', 'view', 'activate', 'update-with-sihrd-integration', 'delete']),
                'buttons' => [
                    'assignment' => function ($url, $model) {
                        return Html::a('<i class="bi bi-sign-turn-right"></i>', ['assignment/view', 'id' => $model->id]);
                    },
                    'activate' => function ($url, $model) {

                        if ($model->status == 10) {
                            return '';
                        }

                        $options = [
                            'title' => Yii::t('rbac-admin', 'Activate'),
                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<i class="bi bi-check"></i>', $url, $options);
                    },

                    'update-with-sihrd-integration' => function ($url, $model) {

                        // User dengan karyawan_id, dianggap sebagai non super-admin
                        if ($model->karyawan_id) {
                            return Html::a('<i class="bi bi-pen"></i>', ['update-with-sihrd-integration', 'id' => $model->id]);
                        }

                        return Html::a('<i class="bi bi-pen"></i>', ['update', 'id' => $model->id]);

                    },

                    'delete' => function ($url, $model) {

                        if ($model->id === 1) {
                            return '';
                        }

                        $options = [
                            'title' => Yii::t('rbac-admin', 'Delete'),
                            'aria-label' => Yii::t('rbac-admin', 'Delete'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to delete this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<i class="bi bi-trash"></i>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>