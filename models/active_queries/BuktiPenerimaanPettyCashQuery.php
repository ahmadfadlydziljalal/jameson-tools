<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPenerimaanPettyCash;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BuktiPenerimaanPettyCash]].
 *
 * @see BuktiPenerimaanPettyCash
 * @method BuktiPenerimaanPettyCash[] all($db = null)
 * @method BuktiPenerimaanPettyCash one($db = null)
 */
class BuktiPenerimaanPettyCashQuery extends ActiveQuery
{
    public function notYetRegisteredInMutasiKas(): array
    {
        $data = parent::joinWith('mutasiKasPettyCash')
            ->where([
                'IS', 'mutasi_kas_petty_cash.id', NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', function($model){
            /** @var BuktiPenerimaanPettyCash $model */
            $ref =  $model->reference_number;
            if($model->bukti_pengeluaran_petty_cash_cash_advance_id){
                $ref .= " Kasbon ke " . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order. ' - '
                    . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - '
                    . $model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name . ' - '
                    . Yii::$app->formatter->asDecimal($model->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance, 2);
            }
            return $ref;
        });
    }

    /**
     * @param mixed $q
     * @param mixed $id
     * @return array[]
     */
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
