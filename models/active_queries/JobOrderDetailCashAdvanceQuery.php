<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\JobOrderDetailCashAdvance;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * This is the ActiveQuery class for [[JobOrderDetailCashAdvance]].
 *
 * @see JobOrderDetailCashAdvance
 * @method JobOrderDetailCashAdvance[] all($db = null)
 * @method JobOrderDetailCashAdvance one($db = null)
 */
class JobOrderDetailCashAdvanceQuery extends ActiveQuery
{

    /**
     * @param $id
     * @return JobOrderDetailCashAdvance
     * @throws NotFoundHttpException
     */
    public function asModel($id): JobOrderDetailCashAdvance
    {
        if (($model = parent::where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function notYetRegistered()
    {
        $data = parent::select([
            'id' => 'job_order_detail_cash_advance.id',
            'referenceNumber' =>new Expression("CONCAT('Kasbon ke ', job_order_detail_cash_advance.order ,': ' ,  job_order.reference_number)")
        ])
            ->joinWith('buktiPengeluaranPettyCash')
            ->joinWith('jobOrder')
            ->where([
                'is', 'bukti_pengeluaran_petty_cash.id' , NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', 'referenceNumber');
    }
}
