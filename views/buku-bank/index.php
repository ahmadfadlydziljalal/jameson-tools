<?php

use kartik\bs5dropdown\ButtonDropdown;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BukuBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BukuBankController::actionIndex() */

$this->title = 'Buku Bank';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="buku-bank-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= ButtonDropdown::widget([
                'label' => 'Debit',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => '<span class="bi bi-dot"></span> Bukti Penerimaan',
                            'url' => ['create-by-bukti-penerimaan-buku-bank']
                        ],
                        [
                            'label' => '<span class="bi bi-dot"></span> Lainnya (Other)',
                            'url' => ['create-by-penerimaan-lainnya']
                        ],
                    ],
                    'encodeLabels' => false,
                ],
                'encodeLabel' => false,
                'buttonOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]) ?>
            <?= ButtonDropdown::widget([
                'label' => 'Credit',
                'dropdown' => [
                    'items' => [
                        [
                            'label' => '<span class="bi bi-dot"></span> Bukti Pengeluaran',
                            'url' => ['create-by-bukti-pengeluaran-buku-bank']
                        ],
                        [
                            'label' => '<span class="bi bi-dot"></span> Lainnya (Other)',
                            'url' => ['create-by-pengeluaran-lainnya']
                        ],
                    ],
                    'encodeLabels' => false,
                ],
                'encodeLabel' => false,
                'buttonOptions' => [
                    'class' => 'btn btn-secondary'
                ]
            ]) ?>
        </div>
    </div>

    <?php try { 
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__.'/_columns.php'),
            ]);
        } catch(Exception $e){
            echo $e->getMessage();
        }
        catch (Throwable $e) {
            echo $e->getMessage();
        }
    
         ?>

</div>