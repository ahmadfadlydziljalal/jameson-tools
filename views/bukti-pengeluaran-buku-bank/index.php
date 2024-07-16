<?php

use kartik\bs5dropdown\ButtonDropdown;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BuktiPengeluaranBukuBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\BuktiPengeluaranBukuBankController::actionIndex() */

$this->title = 'Bukti Pengeluaran Buku Bank';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bukti-pengeluaran-buku-bank-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= ButtonDropdown::widget([
                'label' => '<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah',
                'dropdown' => [
                    'items' => [
                        ['label' => 'By Kasbon / Cash Advance', 'url' => ['create-by-cash-advance']],
                        ['label' => 'By Payment Bill', 'url' => ['create-by-bill']],
                    ],
                    'options' => [
                        'class' => 'dropdown-menu-right',
                    ],
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-primary',
                ],
                'encodeLabel' => false
            ]); ?>
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