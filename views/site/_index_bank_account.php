<?php

/* @var $this View */
/* @var $myBank MyBankAccountsReport */

/* @var $isPdf bool */

use app\models\reports\MyBankAccountsReport;
use yii\web\View;

$classTable = !$isPdf ? "table table-striped caption-top"
    : "table table-bordered caption-top";

?>

<div class="table-responsive">
    <table class="<?= $classTable ?>">
        <?php if(!$isPdf): ?>
            <caption><i class="bi bi-bank2"></i> Bank Account</caption>
        <?php else : ?>
            <caption  style="text-align: left; margin-bottom: 1em">Bank Account</caption>
        <?php endif ?>

        <thead>
        <tr>
            <th scope="col">#</th>
            <th>Bank</th>
            <th>Account</th>
            <th class="text-end">Init Balance (IB)</th>
            <th class="text-end">Penerimaan</th>
            <th class="text-end">Pengeluaran</th>
            <th class="text-end">Last Balance</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($myBank->bankAccounts as $key => $account): ?>
            <tr>
                <th scope="row"><?php echo($key + 1) ?></th>
                <td><?= $account->bank->nama_bank ?></td>
                <td><?= $account->bank->nomor_rekening ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($account->getStartingBalance(), 2) ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($account->getSumDebit(), 2) ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($account->getSumCredit(), 2) ?></td>
                <td class="text-end">
                    <?= Yii::$app->formatter->asDecimal($account->getEndingBalance(), 2) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <th></th>
            <th colspan="2">Total</th>
            <th style="text-align: right"><?= $myBank->getTotalInitNominalBankAccounts(true) ?></th>
            <th style="text-align: right"><?= $myBank->getTotalDebitBankAccounts(true) ?></th>
            <th style="text-align: right"><?= $myBank->getTotalCreditBankAccounts(true) ?></th>
            <th class="text-nowrap" style="text-align: right">
                <?php if (!$isPdf): ?>
                    <div class="d-inline-flex bg-primary text-light p-2 rounded-3">
                        <h3 class="m-0">Rp. <?= $myBank->getTotalEndingBalanceBankAccounts(true) ?></h3>
                    </div>
                <?php else: ?>
                    <h3 class="text-end">Rp. <?= $myBank->getTotalEndingBalanceBankAccounts(true) ?></h3>
                <?php endif; ?>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

