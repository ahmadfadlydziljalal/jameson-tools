<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\JobOrder as BaseJobOrder;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "job_order".
 */
class JobOrder extends BaseJobOrder
{

    const SCENARIO_FOR_PETTY_CASH = 'scenario_for_petty_cash';

    public ?string $jenisBiayaPettyCash = null;
    public ?string $vendorPettyCash = null;
    public ?string $nominalPettyCash = null;

    public mixed $totalBill = 0;
    public mixed $totalKasbonRequest = 0;
    public mixed $totalPanjarCashAdvance = 0;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['jenisBiayaPettyCash', 'vendorPettyCash', 'nominalPettyCash'], 'required', 'on' => self::SCENARIO_FOR_PETTY_CASH],
            ['is_for_petty_cash', 'default', 'value' => 1, 'on' => self::SCENARIO_FOR_PETTY_CASH],
        ]);
    }

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
        foreach ($this->jobOrderDetailCashAdvances as $jobOrderDetailCashAdvance) {
            $this->totalKasbonRequest += $jobOrderDetailCashAdvance->kasbon_request;
            $this->totalPanjarCashAdvance += $jobOrderDetailCashAdvance->cash_advance;
        }

        foreach ($this->jobOrderBills as $jobOrderBill) {
            $this->totalBill += $jobOrderBill->getTotalPrice();
        }
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'totalKasbonRequest' => 'Kasbon',
            'totalPanjarCashAdvance' => 'Panjar',
            'totalBill' => 'Bill',
        ]);
    }

    public function saveForPettyCash()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save(false)) {
                $jobOrderBill = new JobOrderBill([
                    'job_order_id' => $this->id,
                    'reference_number' => '-',
                    'vendor_id' => $this->vendorPettyCash,
                ]);

                if ($flag = $jobOrderBill->save(false)) {
                    $jobOrderBillDetail = new JobOrderBillDetail([
                        'job_order_bill_id' => $jobOrderBill->id,
                        'jenis_biaya_id' => $this->jenisBiayaPettyCash,
                        'quantity' => 1,
                        'satuan_id' => 1,
                        'name' => 'Penambahan Saldo Petty Cash',
                        'price' => $this->nominalPettyCash
                    ]);

                    $flag = $jobOrderBillDetail->save(false);
                }
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

    public function updateForPettyCash()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->save(false)) {
               /* $jobOrderBill = new JobOrderBill([
                    'job_order_id' => $this->id,
                    'reference_number' => '-',
                    'vendor_id' => $this->vendorPettyCash,
                ]);*/

                $jobOrderBill = $this->jobOrderBills[0];
                $jobOrderBill->job_order_id = $this->id;
                $jobOrderBill->reference_number = '-';
                $jobOrderBill->vendor_id = $this->vendorPettyCash;

                if ($flag = $jobOrderBill->save(false)) {

                    $jobOrderBillDetail = $jobOrderBill->jobOrderBillDetails[0];
                    $jobOrderBillDetail->job_order_bill_id = $jobOrderBill->id;
                    $jobOrderBillDetail->jenis_biaya_id = $this->jenisBiayaPettyCash;
                    $jobOrderBillDetail->price = $this->nominalPettyCash;
                    $flag = $jobOrderBillDetail->save(false);
                }
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

    /**
     * @return $this
     */
    public function getNext()
    {
        return $this->find()->where(['>', 'id', $this->id])->one();
    }

    /**
     * @return $this
     */
    public function getPrevious()
    {
        return $this->find()->where(['<', 'id', $this->id])->orderBy('id desc')->one();
    }

}
