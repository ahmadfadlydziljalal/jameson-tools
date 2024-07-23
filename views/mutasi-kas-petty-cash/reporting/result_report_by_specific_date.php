<?php

/* @var $this yii\web\View */

/* @var $model app\models\form\MutasiKasPettyCashReportPerSpecificDate */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;

?>


<?php if ($model->getTransactions()['penerimaan']): ?>
    <p style="margin-top: 0; font-weight: bold">Penerimaan</p>
    <div>
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model->transactions['penerimaan'],
                'pagination' => false,
            ]),
            'layout' => "{items}",
            'showFooter' => true,
            'columns' => [
                [
                    'class' => SerialColumn::class
                ],
                [
                    'attribute' => 'tanggal_mutasi',
                    'format' => 'date',
                    'header' => 'Tgl.Mutasi'
                ],
                'nama_card',
                [
                    'attribute' => 'keterangan',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $keterangan = $model['type'];
                        if ($model['job_order']) {
                            $keterangan .= '<br/>Job Order: ' . $model['job_order'];
                        }

                        if ($model['bukti_pengeluaran']) {
                            $keterangan .= '<br/>B. Pengeluaran: ' . $model['bukti_pengeluaran'];
                        }

                        if ($model['buku_bank']) {
                            $keterangan .= '<br/>Buku Bank: ' . $model['buku_bank'];
                        }
                        return $keterangan;
                    },
                    'contentOptions' => [
                        'style' => 'white-space:nowrap'
                    ],
                ],
                [
                    'attribute' => 'bukti_penerimaan',
                    'footer' => 'Total Penerimaan',
                    'footerOptions' => [
                        'class' => 'text-end',
                        'style' => 'font-weight: bold'
                    ],
                ],
                [
                    'attribute' => 'nominal',
                    'format' => ['decimal', 2],
                    'contentOptions' => ['class' => 'text-end'],
                    'footer' => Yii::$app->formatter->asDecimal($model->getTotalPenerimaan(), 2),
                    'footerOptions' => [
                        'class' => 'text-end',
                        'style' => 'font-weight: bold'
                    ],
                ]
            ]
        ]) ?>
    </div>
    <br>
<?php endif ?>

<?php if ($model->getTransactions()['pengeluaran']): ?>
    <p style="margin-top: 0; font-weight: bold">Pengeluaran</p>
    <div>
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model->transactions['pengeluaran'],
            ]),
            'layout' => "{items}",
            'showFooter' => true,
            'columns' => [
                [
                    'class' => SerialColumn::class
                ],
                [
                    'attribute' => 'tanggal_mutasi',
                    'format' => 'date',
                    'header' => 'Tgl.Mutasi'
                ],
                'nama_card',
                [
                    'attribute' => 'keterangan',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model['type'] . '<br/>' .
                            $model['job_order'];
                    },
                    'contentOptions' => [
                        'style' => 'white-space:nowrap'
                    ],
                ],
                [
                    'attribute' => 'bukti_pengeluaran',
                    'footer' => 'Total Pengeluaran',
                    'footerOptions' => [
                        'class' => 'text-end',
                        'style' => 'font-weight: bold'
                    ],
                ],
                [
                    'attribute' => 'nominal',
                    'format' => ['decimal', 2],
                    'contentOptions' => ['class' => 'text-end'],
                    'footer' => Yii::$app->formatter->asDecimal($model->getTotalPengeluaran(), 2),
                    'footerOptions' => [
                        'class' => 'text-end',
                        'style' => 'font-weight: bold'
                    ],
                ]
            ]
        ]) ?>
    </div>
    <br>
<?php endif ?>

<div>
    <p style="margin-top:0 ;font-weight: bold">Summary </p>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th style="text-align: left">Saldo Awal</th>
            <th class="text-end"
                style="text-align: right"><?= Yii::$app->formatter->asDecimal($model->getBalanceBeforeDate(), 2) ?></th>
        </tr>
        <tr>
            <th style="text-align: left">Total Penerimaan</th>
            <th class="text-end"
                style="text-align: right"><?= Yii::$app->formatter->asDecimal($model->getTotalPenerimaan(), 2) ?></th>
        </tr>
        <tr>
            <th style="text-align: left">Total Pengeluaran</th>
            <th class="text-end"
                style="text-align: right"><?= Yii::$app->formatter->asDecimal($model->getTotalPengeluaran(), 2) ?></th>
        </tr>
        <tr>
            <th style="text-align: left">Saldo Akhir</th>
            <th class="text-end"
                style="text-align: right; font-weight: bold"><?= Yii::$app->formatter->asDecimal($model->getSaldoAkhir(), 2) ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left">
                <p style="font-weight: bold">Terbilang: <br/>
                    <?= Yii::$app->formatter->asSpellout($model->getSaldoAkhir()) ?>
                </p>
            </th>
        </tr>
        </tbody>

    </table>
</div>


