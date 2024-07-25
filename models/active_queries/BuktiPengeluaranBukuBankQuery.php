<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPengeluaranBukuBank;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranBukuBank]].
 *
 * @see BuktiPengeluaranBukuBank
 * @method BuktiPengeluaranBukuBank[] all($db = null)
 * @method BuktiPengeluaranBukuBank one($db = null)
 */
class BuktiPengeluaranBukuBankQuery extends ActiveQuery
{

    /**
     * Record yang di-hasilkan bisa dari kasbon atau pembayaran tagihan
     * @return array
     */
    public function notYetRegisteredInBukuBank(): array
    {
        $data = parent::joinWith('bukuBank')
            ->joinWith('jobOrderDetailPettyCash')
            ->where(['buku_bank.id' => null])
            ->andWhere([
                'IS','job_order_detail_petty_cash.id', NULL
            ])
            ->all();
        return ArrayHelper::map($data, 'id', function ($model) {
            /** @var BuktiPengeluaranBukuBank $model */
            return $model->reference_number . ': ' . $model->tujuanBayar . ' ' . Yii::$app->formatter->asCurrency($model->totalBayar);
        });
    }

    public function notYetRegisteredAsMutasiKasPettyCashInBukuBank(): array
    {
        $data = parent::joinWith('bukuBank')
            ->joinWith('jobOrderDetailPettyCash')
            ->where(['buku_bank.id' => null])
            ->andWhere([
                'IS NOT','job_order_detail_petty_cash.id', NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', function ($model) {
            /** @var BuktiPengeluaranBukuBank $model */
            return $model->reference_number . ': '
                . Yii::$app->formatter->asCurrency($model->jobOrderDetailPettyCash->nominal);
        });
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
