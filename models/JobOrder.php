<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\JobOrder as BaseJobOrder;
use app\models\interfaces\PrevNextInterface;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "job_order".
 *
 * @property-read mixed $next
 * @property-read JobOrder $previous
 */
class JobOrder extends BaseJobOrder implements PrevNextInterface
{

    const SCENARIO_FOR_PETTY_CASH = 'scenario_for_petty_cash';


    public mixed $totalBill = 0;
    public mixed $totalKasbonRequest = 0;
    public mixed $totalPanjarCashAdvance = 0;
    public mixed $totalPettyCash = 0;

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/' . date('Y'), // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

    public function afterFind(): void
    {
        parent::afterFind();
        if ($this->jobOrderDetailCashAdvances) {
            foreach ($this->jobOrderDetailCashAdvances as $jobOrderDetailCashAdvance) {
                $this->totalKasbonRequest += $jobOrderDetailCashAdvance->kasbon_request;
                $this->totalPanjarCashAdvance += $jobOrderDetailCashAdvance->cash_advance;
            }
        }

        if ($this->jobOrderBills) {
            foreach ($this->jobOrderBills as $jobOrderBill) {
                $this->totalBill += $jobOrderBill->totalPrice;
            }
        }

        if ($this->jobOrderDetailPettyCash) {
            $this->totalPettyCash = $this->jobOrderDetailPettyCash->nominal;
        }
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'totalKasbonRequest' => 'Kasbon',
            'totalPanjarCashAdvance' => 'Panjar',
            'totalBill' => 'Bill',
            'totalPettyCash' => 'Petty Cash',
        ]);
    }

    /**
     * @return $this
     */
    public function getNext(): static|null
    {
        return static::find()->where(['>', 'id', $this->id])->one();
    }

    public function getPrevious(): static|null
    {
        return static::find()->where(['<', 'id', $this->id])->orderBy('id desc')->one();
    }

    public function saveForPettyCash(JobOrderDetailPettyCash $modelDetail): bool
    {

        if (!$this->validate() and !$modelDetail->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save(false)) {
                $modelDetail->job_order_id = $this->id;
                $flag = $modelDetail->save(false);
            }

            if ($flag) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

}
