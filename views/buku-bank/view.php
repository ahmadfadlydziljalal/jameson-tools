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
                    'data-pjax' => '0',
                ]) ?>

                <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
                <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= Html::a('Update', $model->getUpdateUrl(), ['class' => 'btn btn-outline-primary']) ?>
                <?php
                if (Helper::checkRoute('delete')) :
                    if ($model->buktiPenerimaanPettyCash) {
                        echo Html::a('<i class="bi bi-trash"></i>', ['delete-with-mutasi-kas', 'id' => $model->id], [
                            'data-confirm' => "Record ini berelasi dengan Mutasi Kas Petty Cash via Bukti Penerimaan Petty Cash. <br/> 
                                           <strong>{$model->buktiPenerimaanPettyCash->reference_number}</strong> 
                                           <strong>{$model->buktiPenerimaanPettyCash->mutasiKasPettyCash->nomor_voucher}</strong><br/>
                                           Jika data ini dihapus, maka Data Petty Cash juga tersebut akan ikut terhapus.<br/>
                                           <span class='text-danger'>Sayangnya kalau data sudah dihapus, maka semua data-data ini tidak dapat di restore ulang.</span>
                                           Apakah anda yakin ingin menghapus data ini ?
                                          ",
                            'data-title' => 'Are you sure ?',
                            'data-method' => 'post',
                            'class' => 'btn btn-outline-danger',
                        ]);
                    } else {
                        echo Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'class' => 'btn btn-outline-danger',
                            ]
                        );
                    }
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