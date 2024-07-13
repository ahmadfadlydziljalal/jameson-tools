<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPengeluaranPettyCash;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranPettyCash]].
 *
 * @see \app\models\BuktiPengeluaranPettyCash
 * @method BuktiPengeluaranPettyCash[] all($db = null)
 * @method BuktiPengeluaranPettyCash one($db = null)
 */
class BuktiPengeluaranPettyCashQuery extends \yii\db\ActiveQuery
{

    public function cashAdvanceNotYetRealization(): array
    {
        $data = parent::joinWith(['jobOrderDetailCashAdvance' => function (ActiveQuery $jobOrderDetailCashAdvance) {
            $jobOrderDetailCashAdvance->joinWith('jobOrder');
        }])
            ->joinWith('buktiPenerimaanPettyCash')
            ->where([
                'IS NOT', 'job_order_detail_cash_advance_id', NULL
            ])
            ->andWhere([
                'IS' , 'bukti_penerimaan_petty_cash.id', NULL
            ])
            ->all();
        return ArrayHelper::map($data, 'id', function($model){
            /** @var BuktiPengeluaranPettyCash $model */
            return "Kasbon ke " . $model->jobOrderDetailCashAdvance->order . ' - '
                . $model->jobOrderDetailCashAdvance->jobOrder->reference_number. ' - '
                . $model->jobOrderDetailCashAdvance->jenisBiaya->name. ' - '
                . \Yii::$app->formatter->asDecimal($model->jobOrderDetailCashAdvance->cash_advance, 2)
                ;
        });
    }
}
