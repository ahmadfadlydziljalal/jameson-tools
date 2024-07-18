<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPengeluaranBukuBank;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranBukuBank]].
 *
 * @see \app\models\BuktiPengeluaranBukuBank
 * @method BuktiPengeluaranBukuBank[] all($db = null)
 * @method BuktiPengeluaranBukuBank one($db = null)
 */
class BuktiPengeluaranBukuBankQuery extends \yii\db\ActiveQuery
{

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
            return $model->reference_number;
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
            return $model->reference_number;
        });
    }
}
