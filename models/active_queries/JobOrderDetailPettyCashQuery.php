<?php

namespace app\models\active_queries;

use \app\models\JobOrderDetailPettyCash;

/**
 * This is the ActiveQuery class for [[JobOrderDetailPettyCash]].
 *
 * @see \app\models\JobOrderDetailPettyCash
 * @method JobOrderDetailPettyCash[] all($db = null)
 * @method JobOrderDetailPettyCash one($db = null)
 */
class JobOrderDetailPettyCashQuery extends \yii\db\ActiveQuery
{

    public function notYetRegistered(): array
    {
        $pettyCashes = parent::joinWith('jobOrder')
            ->joinWith(['vendor' => function ($vendor) {
                $vendor->from(['vendor' => 'card']);
            }])
            ->andWhere([
                'is', 'job_order_detail_petty_cash.bukti_pengeluaran_buku_bank_id', NULL
            ])
            ->all();

        $data = [];
        foreach ($pettyCashes as $pettyCash) {
            $data[$pettyCash->id] = $pettyCash->jobOrder->reference_number . ' - ' . $pettyCash->vendor->nama . ' - ' . \Yii::$app->formatter->asDecimal($pettyCash->nominal,2);
        }
        return $data;
    }
}
