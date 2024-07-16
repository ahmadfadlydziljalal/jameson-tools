<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\BuktiPengeluaranPettyCash as BaseBuktiPengeluaranPettyCash;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;

/**
 * This is the model class for table "bukti_pengeluaran_petty_cash".
 *
 * @property-read string $statusCashAdvance
 */
class BuktiPengeluaranPettyCash extends BaseBuktiPengeluaranPettyCash
{
    const SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON = 'scenario_pengeluaran_by_cash_advance_or_kasbon';
    const SCENARIO_PENGELUARAN_BY_BILL = 'scenario_pengeluaran_by_bill';

    public ?string $cashAdvanceReferenceNumber = null;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/BP-OUT-PC/' . date('Y'), // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['cashAdvanceReferenceNumber', 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON],
            ['job_order_bill_id', 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_BILL]
        ]);
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON] = [
            'cashAdvanceReferenceNumber'
        ];
        $scenarios[self::SCENARIO_PENGELUARAN_BY_BILL] = [
            'job_order_bill_id'
        ];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'cashAdvanceReferenceNumber' => 'Kasbon | Cash Advance',
        ]);
    }


    /**
     * @return bool
     */
    public function saveByCashAdvance(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {
                $advance = JobOrderDetailCashAdvance::findOne($this->cashAdvanceReferenceNumber);
                $flag = $advance->markAsPaidFromBuktiPengeluaranPettyCash($this->id);
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

    public function saveByBill(): bool
    {
        if (!$this->validate()) return false;
        return $this->save(false);
    }

    public function deleteByCashAdvance(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            /* Kasbon / Cash advance di reverse dari panjar ke kasbon field */
            $flag = $this->jobOrderDetailCashAdvance->reverseMarkAsPaid();
            if ($this->delete() && $flag) {
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

    public function updateByCashAdvance(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {

                // Ada perbedaan antara kasbon yang sudah exist dengan update yang terbaru
                if ($this->jobOrderDetailCashAdvance->id != intval($this->cashAdvanceReferenceNumber)) {

                    // Reverse existing kasbon
                    $flag = $this->jobOrderDetailCashAdvance->reverseMarkAsPaidFromBuktiPengeluaranPettyCash();

                    // Set new kasbon
                    $newCashAdvanceModel = JobOrderDetailCashAdvance::findOne($this->cashAdvanceReferenceNumber);
                    $flag = $newCashAdvanceModel->markAsPaidFromBuktiPengeluaranPettyCash($this->id) && $flag;
                }
            }

            if($flag){
                $transaction->commit();
                return true;
            }else{
                $transaction->rollBack();
            }

        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;

    }

    public function updateByBill(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        if ($this->getOldAttribute('job_order_bill_id') == $this->job_order_bill_id) {
            return true;  //  do nothing
        }
        return $this->save(false);
    }

    public function deleteByBill(): bool|int
    {
        return $this->delete();
    }

    public function getStatusCashAdvance(): string
    {
        $string = 'Kasbon ke ' . $this->jobOrderDetailCashAdvance?->order;
        if ($this->buktiPenerimaanPettyCash) {
            $string .= ' ' . Html::tag('span', $this->buktiPenerimaanPettyCash->reference_number, [
                    'class' => 'badge bg-success'
                ]);
        } else {
            $string .= ' ' . Html::tag('span', 'Kasbon belum lunas', ['class' => 'badge bg-danger']);
        }
        return $string;
    }


}
