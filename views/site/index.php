<?php
/* @see \app\controllers\SiteController::actionIndex() */

/* @var $this View */

use app\models\reports\MyBankAccountsReport;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Dashboard';

$myBank = new MyBankAccountsReport();

?>

<div class="site-index d-flex flex-column gap-3 gap-lg-5">

    <div class="d-flex justify-content-between flex-wrap gap-3">
        <h1 class="my-0">Welcome <?= Html::encode(Yii::$app->user->identity->username) ?></h1>
        <div>
            <i class="bi bi-clock"> </i>
            <span class="text-muted"><?= date('D, d-m-y H:i:s') ?></span>
        </div>
    </div>

    <div class="row gap-3 gap-sm-3 gap-md-3 gap-lg-0">
        <div class="col col-lg-8 col-xl-6">
            <?= $this->render('_index_total_ending_balance', [
                'myBank' => $myBank,
                'isPdf' => false
            ]) ?>
        </div>
        <div class="col col-lg-4 col-xl-6">
            <?= $this->render('_index_petty_cash', [
                'myBank' => $myBank,
            ]) ?>
        </div>
    </div>

    <?= $this->render('_index_bank_account', [
        'myBank' => $myBank,
        'isPdf' => false
    ]) ?>

    <div>
        <?= Html::a('<i class="bi bi-printer"></i> Cetak Summary', ['site/export-summary', 'key' => $myBank->getKey()], [
            'class' => 'btn btn-success',
            'target' => '_blank',
        ]) ?>
    </div>


    <!--<table class="table caption-top">
        <caption><i class="bi bi-receipt"></i> Piutang / Receivables</caption>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Customer</th>
            <th scope="col">Reference No.</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
        </tr>
        </tbody>
    </table>
    <table class="table caption-top">
        <caption><i class="bi bi-receipt"></i> Hutang / Payable</caption>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Vendor</th>
            <th scope="col">Reference No.</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
        </tr>
        </tbody>
    </table>
    <table class="table caption-top">
        <caption><i class="bi bi-receipt"></i> Kasbon / Cash Advance</caption>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Vendor</th>
            <th scope="col">Reference No.</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@twitter</td>
        </tr>
        </tbody>
    </table>-->


</div>