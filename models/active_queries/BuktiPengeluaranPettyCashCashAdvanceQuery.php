<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPenerimaanPettyCash;
use app\models\BuktiPengeluaranPettyCash;
use app\models\BuktiPengeluaranPettyCashCashAdvance;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranPettyCashCashAdvance]].
 *
 * @see BuktiPengeluaranPettyCashCashAdvance
 * @method BuktiPengeluaranPettyCashCashAdvance[] all($db = null)
 * @method BuktiPengeluaranPettyCashCashAdvance one($db = null)
 */
class BuktiPengeluaranPettyCashCashAdvanceQuery extends ActiveQuery
{

    public function notYetRealization()
    {
        $data = parent::joinWith('buktiPengeluaranPettyCash')
            ->joinWith(['jobOrderDetailCashAdvance' => function($jobOrderDetailCashAdvance){
                return $jobOrderDetailCashAdvance->joinWith('jobOrder')
                ->joinWith('jenisBiaya');
            }])
            ->joinWith('buktiPenerimaanPettyCashCashAdvance')
            ->where([
                'IS' , 'bukti_penerimaan_petty_cash_id', NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', function ($model) {
            /** @var BuktiPengeluaranPettyCashCashAdvance $model */
            return $model->buktiPengeluaranPettyCash->reference_number . ' - ' .
                $model->jobOrderDetailCashAdvance->jobOrder->reference_number . ' - ' .
                'Kasbon ke ' . $model->jobOrderDetailCashAdvance->order  . ' - ' .
                $model->jobOrderDetailCashAdvance->jenisBiaya->name  . ' - ' .
               Yii::$app->formatter->asDecimal( $model->jobOrderDetailCashAdvance->cash_advance, 2)

                ;
        });
    }
}
