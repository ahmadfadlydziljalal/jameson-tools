<?php

/* @var $this yii\web\View */

/* @var $model app\models\form\BukuBankReportPerSpecificDate */

?>

<div class="">
    <table class="table table-bordered">
        <tr>
            <th style="text-align: left; font-weight: bold">Nama Bank</th>
            <td><?= $model->bank->nama_bank ?> </td>
            <th style="text-align: left; font-weight: bold">Account Number</th>
            <td><?= $model->bank->nomor_rekening ?> </td>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold">Query Date</th>
            <td><?= $model->date ?> </td>
            <th style="text-align: left; font-weight: bold">Balance</th>
            <td style="text-align: right; font-weight: bold"><?= Yii::$app->formatter->asDecimal($model->balanceBeforeDate, 2) ?> </td>
        </tr>
        <tr>
            <th style="text-align: left; font-weight: bold">Print Date</th>
            <td><?= date('d-m-Y, H:i') ?> </td>
            <th style="text-align: left; font-weight: bold">Print By</th>
            <td><?= Yii::$app->user->identity->username ?> </td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th>No</th>
            <th>Nomor Voucher</th>
            <th>Transaksi</th>
            <th>Keterangan</th>
            <th>Referensi</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Saldo</th>
        </tr>
        </thead>
        <tbody>
        <?php $saldo = $model->balanceBeforeDate ?>
        <?php foreach ($model->transactions as $key => $value) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $value['nomor_voucher'] ?></td>
                <td><?= Yii::$app->formatter->asDate($value['tanggal_transaksi']) ?></td>
                <td class="text-nowrap">
                    <?= $value['nama'] ?><br>
                    <strong><?= $value['type'] ?>; </strong> <?= $value['source_request'] ?>
                </td>
                <td>
                    <?= $value['referensi'] ?><br>
                    <?= $value['document'] ?>
                </td>
                <td class="text-end">
                    <?= Yii::$app->formatter->asDecimal($value['debit'], 2) ?>
                </td>
                <td class="text-end">
                    <?= Yii::$app->formatter->asDecimal($value['credit'], 2) ?>
                </td>
                <td class="text-end">
                    <?php
                    if (!empty(abs($value['debit']))) {
                        $saldo += abs($value['debit']);
                    } else {
                        $saldo -= abs($value['credit']);
                    }
                    echo Yii::$app->formatter->asDecimal($saldo, 2);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <th colspan="5" style="text-align: right; font-weight: bold">Saldo Akhir</th>
            <th class="text-end" style="text-align: right; font-weight: bold">
                <?= Yii::$app->formatter->asDecimal($model->getSumDebit(), 2) ?>
            </th>
            <th class="text-end" style="text-align: right; font-weight: bold">
                <?= Yii::$app->formatter->asDecimal($model->getSumCredit(), 2) ?>
            </th>
            <th class="text-end" style="text-align: right; font-weight: bold">
                <?= Yii::$app->formatter->asDecimal($model->getEndingBalance(), 2) ?>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: left; font-weight: bold">
                <small>Terbilang</small> <br/>
                <?= Yii::$app->formatter->asSpellout($model->getEndingBalance()) ?>
            </th>
        </tr>
        </tfoot>

    </table>
</div>
