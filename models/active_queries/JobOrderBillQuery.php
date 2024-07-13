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

    public function asModel($id)
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
            ->joinWith('buktiPengeluaranPettyCash')
            ->joinWith(['vendor' => function ($vendor) {
                $vendor->from(['vendor' => 'card']);
            }])
            ->where([
                'is', 'bukti_pengeluaran_petty_cash.id', NULL
            ])
            ->all();

        $data = [];
        foreach ($bills as $bill) {
            $data[$bill->id] =
                $bill->jobOrder->reference_number . ' - ' .
                $bill->vendor->nama . ' - ' .
                Yii::$app->formatter->asDecimal($bill->getTotalPrice(),2);
        }

        return $data;
    }
}
