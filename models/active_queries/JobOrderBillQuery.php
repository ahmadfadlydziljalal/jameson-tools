<?php

namespace app\models\active_queries;

use app\models\JobOrderBill;
use Yii;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * This is the ActiveQuery class for [[JobOrderBill]].
 *
 * @see JobOrderBill
 * @method JobOrderBill[] all($db = null)
 * @method JobOrderBill one($db = null)
 */
class JobOrderBillQuery extends ActiveQuery
{

    /**
     * @param $id
     * @return JobOrderBill
     * @throws NotFoundHttpException
     */
    public function asModel($id): JobOrderBill
    {
        if (($model = parent::where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function notYetRegistered(): array
    {
        $bills = parent::joinWith('jobOrder')
            ->joinWith(['vendor' => function ($vendor) {
                $vendor->from(['vendor' => 'card']);
            }])
            ->where([
                'is', 'job_order_bill.bukti_pengeluaran_petty_cash_id', NULL
            ])
            ->andWhere([
                'is', 'job_order_bill.bukti_pengeluaran_buku_bank_id', NULL
            ])
            ->all();

        $data = [];
        foreach ($bills as $bill) {
            $data[$bill->id] = $bill->jobOrder->reference_number . ' - ' . $bill->vendor->nama . ' - ' . Yii::$app->formatter->asDecimal($bill->getTotalPrice(),2);
        }
        return $data;
    }

}
