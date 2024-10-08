<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPengeluaranPettyCash;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranPettyCash]].
 *
 * @see BuktiPengeluaranPettyCash
 * @method BuktiPengeluaranPettyCash[] all($db = null)
 * @method BuktiPengeluaranPettyCash one($db = null)
 */
class BuktiPengeluaranPettyCashQuery extends ActiveQuery
{
    /**
     * Mencari bukti pengeluaran yang belum dikembalikan
     * @return array
     */
    public function cashAdvanceNotYetRealization(): array
    {
        $data = parent::joinWith(['jobOrderDetailCashAdvance' => function (ActiveQuery $jobOrderDetailCashAdvance) {
            $jobOrderDetailCashAdvance->joinWith('jobOrder');
        }])
            ->joinWith('buktiPenerimaanPettyCash')
            ->where([
                'IS NOT', 'job_order_detail_cash_advance.bukti_pengeluaran_petty_cash_id', NULL
            ])
            ->andWhere([
                'IS', 'job_order_detail_cash_advance.bukti_pengeluaran_buku_bank_id', NULL
            ])
            ->andWhere([
                'IS', 'bukti_penerimaan_petty_cash.id', NULL
            ])
            ->all();
        return ArrayHelper::map($data, 'id', function ($model) {
            /** @var BuktiPengeluaranPettyCash $model */
            return "Kasbon ke " . $model->jobOrderDetailCashAdvance->order . ' - '
                . $model->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - '
                . $model->jobOrderDetailCashAdvance->jenisBiaya->name . ' - '
                . Yii::$app->formatter->asDecimal($model->jobOrderDetailCashAdvance->cash_advance, 2);
        });
    }

    /**
     * Mencari Bukti Pengeluaran yang belum didaftarkan di mutasi kas
     * @return array
     */
    public function notYetRegisteredInMutasiKas(): array
    {
        $data = parent::joinWith('mutasiKasPettyCash')
            ->joinWith(['jobOrderDetailCashAdvance' => function (ActiveQuery $jobOrderDetailCashAdvance) {
                $jobOrderDetailCashAdvance->joinWith('jobOrder');
            }])
            ->joinWith('buktiPenerimaanPettyCash')
            ->where([
                'IS', 'mutasi_kas_petty_cash.id', NULL
            ])
            ->all();
        $data = ArrayHelper::map($data, 'id', fn($model) => $this->setLabel($model));
        asort($data);

        return $data;
    }

    /**
     * @param BuktiPengeluaranPettyCash $model
     * @return string
     */
    protected function setLabel(BuktiPengeluaranPettyCash $model): string
    {
        if($model->jobOrderDetailCashAdvance){
            return "Kasbon ke " . $model->jobOrderDetailCashAdvance->order . ' - '
                . $model->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - '
                . $model->jobOrderDetailCashAdvance->jenisBiaya->name . ' - '
                . Yii::$app->formatter->asDecimal($model->jobOrderDetailCashAdvance->cash_advance, 2);
        }

        return 'Payment ' . $model->jobOrderBill->jobOrder->reference_number. ' - ' .
            $model->jobOrderBill->vendor->nama. ' - ' .
            Yii::$app->formatter->asDecimal($model->jobOrderBill->getTotalPrice(),2) ;
    }

    public function liveSearchById(mixed $q, mixed $id): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $query = parent::select(['id' => 'id', 'text' => 'reference_number'])
                ->where(['LIKE', 'reference_number', $q])
                ->orderBy('reference_number')
                ->asArray();
            $out['results'] = array_values($query->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->reference_number];
        }
        return $out;
    }



}
