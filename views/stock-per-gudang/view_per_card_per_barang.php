<?php

use app\models\Barang;
use app\models\Card;
use app\models\search\StockPerGudangPerCardPerBarangSearch;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;
use yii\web\View;

/* @var $this View */
/* @var $card Card */
/* @var $barang Barang */
/* @var $dataProvider array */
/* @var $searchModel StockPerGudangPerCardPerBarangSearch */

$this->title = $barang->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $card->nama, 'url' => ['view-per-card', 'id' => $card->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-per-gudang-view">

    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div>
           <?= Html::a('<i class="bi bi-repeat"></i>', ['index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

   <?php try {
      echo GridView::widget([
         'tableOptions' => [
            'class' => 'table table-gridview table-fixes-last-column'
         ],
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'rowOptions' => [
            'class' => 'text-nowrap align-middle'
         ],
         'columns' => [
            [
               'class' => SerialColumn::class
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'block'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'rak'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'tier'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'row'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyInit',
               'header' => 'INIT',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyTandaTerimaBarang',
               'header' => 'TTB',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyClaimPettyCash',
               'header' => 'CPC',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyDeliveryReceipt',
               'header' => 'DR',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyTransferOut',
               'header' => 'TR-O',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyTransferIn',
               'header' => 'TR-I',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'qtyFinal',
               'header' => 'Final',
               'contentOptions' => [
                  'class' => 'text-end'
               ]
            ],
         ]
      ]);
   } catch (Throwable $e) {
      throw new InvalidConfigException($e->getMessage());
   } ?>


</div>