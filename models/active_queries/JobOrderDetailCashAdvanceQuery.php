<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\JobOrderDetailCashAdvance;
use Yii;
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

    public function notYetRegistered(): array
    {
        $data = parent::joinWith('jobOrder')
            ->where(['is', 'job_order_detail_cash_advance.bukti_pengeluaran_petty_cash_id', NULL])
            ->andWhere(['is', 'job_order_detail_cash_advance.bukti_pengeluaran_buku_bank_id', NULL])
            ->all();

        return ArrayHelper::map($data, 'id', function ($model) {
            /** @var JobOrderDetailCashAdvance $model */
            if ($model->bukti_pengeluaran_petty_cash_id) {
                return 'Kasbon ke ' . $model->order .
                    ': ' . $model->jobOrder->reference_number .
                    ', Panjar ' . Yii::$app->formatter->asDecimal($model->cash_advance, 2);
            }

            return 'Kasbon ke ' . $model->order .
                ': ' . $model->jobOrder->reference_number .
                ', Request: ' . Yii::$app->formatter->asDecimal($model->kasbon_request, 2);
        });
    }
}
