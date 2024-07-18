<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\BukuBank */
/* @see app\controllers\BukuBankController::actionView() */

$this->title = $model->nomor_voucher;
$this->params['breadcrumbs'][] = ['label' => 'Buku Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin([
    'id' => 'pjax-view',
    'enablePushState' => true
]) ?>
<div class="buku-bank-view d-flex flex-column gap-3">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <div class="d-inline-flex align-items-center gap-2">
            <?= Html::a('<span class="lead"><i class="bi bi-arrow-left-circle"></i></span>', Yii::$app->request->referrer, ['class' => 'text-decoration-none']) ?>
            <h1 class="m-0">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>

        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('<i class="bi bi-printer"></i> Export PDF', ['buku-bank/export-to-pdf', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'target' => '_blank',
            ]) ?>

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


    <?= $this->render('_view_detail', ['model' => $model]); ?>

    <?php echo Html::tag('h2', $model->businessProcess['businessProcess']); ?>
    <div class="table-responsive">
        <?= $this->render('_view_detail_2', ['model' => $model]); ?>
    </div>


    <div class="d-inline-flex gap-2">
        <?php
        $prev = $model->getPrevious();
        if ($prev) {
            echo Html::a('<< Previous', ['view', 'id' => $prev->id], [
                'class' => 'btn btn-primary',
                'data-pjax' => 1,
                'id' => 'prev-page'
            ]);
        }

        $next = $model->getNext();
        if ($next) {
            echo Html::a('Next >>', ['view', 'id' => $next->id], [
                'class' => 'btn btn-primary',
                'data-pjax' => "1",
                'id' => 'next-page'
            ]);
        }
        ?>
    </div>



</div>
<?php Pjax::end() ?>