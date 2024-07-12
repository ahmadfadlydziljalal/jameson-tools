<?php
/** @var yii\web\View $this */
/** @see \app\controllers\StockPerGudangController */

/** @var ActiveDataProvider $dataProvider */


use app\models\ClaimPettyCash;
use app\models\TandaTerimaBarang;
use kartik\bs5dropdown\ButtonDropdown;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\ListView;

$this->title = 'Stock Per Gudang';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="lokasi-barang-index">

    <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <div>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div>
               <?= Html::a('<i class="bi bi-plus"></i> Start', ['stock-per-gudang/start-location'], ['class' => 'btn btn-primary']) ?>
               <?php
               echo ButtonDropdown::widget([
                  'label' => 'Masuk',
                  'dropdown' => [
                     'items' => [
                        [
                           'label' => 'Tanda Terima',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Claim Petty Cash',
                           'url' => ['barang-masuk-claim-petty-cash-step1']
                        ],
                        /*[
                           'label' => 'Free Spare Part',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Hibah',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Retur Supplier',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Retur Customer',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],*/
                     ],
                  ],
                  'buttonOptions' => ['class' => 'btn-primary']
               ]);
               ?>
               <?= Html::a('<i class="bi bi-plus"></i> Transfer', ['stock-per-gudang/transfer-barang-antar-gudang'], ['class' => 'btn btn-primary']) ?>
               <?php
               echo ButtonDropdown::widget([
                  'label' => 'Keluar',
                  'dropdown' => [
                     'items' => [
                        [
                           'label' => 'Quotation | Delivery Receipt',
                           'url' => ['stock-per-gudang/barang-keluar-delivery-receipt-step1']
                        ],
                     ],
                  ],
                  'buttonOptions' => ['class' => 'btn-primary']
               ]);
               ?>

               <?php
               echo ButtonDropdown::widget([
                  'label' => 'Laporan',
                  'dropdown' => [
                     'items' => [
                        [
                           'label' => 'Tanda Terima',
                           'url' => ['create-report-barang-masuk', 'modelName' => StringHelper::basename(TandaTerimaBarang::class)]
                        ],
                        [
                           'label' => 'Claim Petty Cash',
                           'url' => ['create-report-barang-masuk', 'modelName' => StringHelper::basename(ClaimPettyCash::class)]
                        ],
                        /*[
                           'label' => 'Free Spare Part',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Hibah',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Retur Supplier',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],
                        [
                           'label' => 'Retur Customer',
                           'url' => ['barang-masuk-tanda-terima-po-step1']
                        ],*/
                     ],
                  ],
                  'buttonOptions' => ['class' => 'btn-primary']
               ]);
               ?>
               <?= Html::a('<i class="bi bi-repeat"></i>', ['index'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

       <?= ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '_item',
          'options' => [
             'class' => 'row'
          ],
          'itemOptions' => [
             'tag' => null
          ],
          'layout' => '{items}'
       ]) ?>

    </div>


</div>