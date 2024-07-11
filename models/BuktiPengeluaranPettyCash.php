<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\BuktiPengeluaranPettyCash as BaseBuktiPengeluaranPettyCash;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bukti_pengeluaran_petty_cash".
 */
class BuktiPengeluaranPettyCash extends BaseBuktiPengeluaranPettyCash
{
    const SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON = 'scenario_pengeluaran_by_cash_advance_or_kasbon';

    public ?int $kasbon = null;

    const SCENARIO_PENGELUARAN_BY_BILL = 'scenario_pengeluaran_by_bill';
    public ?int $bill = null;

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
            ['kasbon', 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON],
            ['bill', 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_BILL]
        ]);
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON] = [
            'kasbon'
        ];
        $scenarios[self::SCENARIO_PENGELUARAN_BY_BILL] = [
            'bill'
        ];
        return $scenarios;
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

                $flag = (new BuktiPengeluaranPettyCashCashAdvance([
                    'bukti_pengeluaran_petty_cash_id' => $this->id,
                    'job_order_detail_cash_advance_id' => $this->kasbon
                ]))->save(false);

                if ($flag) {
                    $advance = JobOrderDetailCashAdvance::findOne($this->kasbon);
                    $flag = $advance->markAsPaid();
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

    public function saveByBill()
    {
        if (!$this->validate()) return false;

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {
                $flag = (new BuktiPengeluaranPettyCashBill([
                    'bukti_pengeluaran_petty_cash_id' => $this->id,
                    'job_order_bill_id' => $this->bill
                ]))->save(false);
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

    public function deleteByCashAdvance(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            /* Kasbon / Cash advance di reverse dari panjar ke kasbon field */
            $flag = $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->reverseMarkAsPaid();
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

        if ($this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->id == $this->kasbon) {
            //  do nothing
            return true;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            // re-back again from panjar ke kasbon
            if ($flag = $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->reverseMarkAsPaid()) {

                // remove yang lama si record junction link
                if ($flag = ($this->buktiPengeluaranPettyCashCashAdvance->delete())) {

                    // create new junction link
                    $new = (new BuktiPengeluaranPettyCashCashAdvance([
                        'bukti_pengeluaran_petty_cash_id' => $this->id,
                        'job_order_detail_cash_advance_id' => $this->kasbon
                    ]));

                    if ($flag = $new->save(false)) {
                        // junction yang baru di assign sebagai sudah paid
                        $flag = $new->jobOrderDetailCashAdvance->markAsPaid();
                    }
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

    public function updateByBill(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->buktiPengeluaranPettyCashBill->jobOrderBill->id == $this->bill) {
            //  do nothing
            return true;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->buktiPengeluaranPettyCashBill->delete()) {
                $flag = (new BuktiPengeluaranPettyCashBill([
                    'bukti_pengeluaran_petty_cash_id' => $this->id,
                    'job_order_bill_id' => $this->bill
                ]))->save(false);
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


    public function deleteByBill(): bool|int
    {
        return $this->delete();
    }

    public function getStatusCashAdvance(): string
    {
        $string = 'Kasbon ke ' . $this->buktiPengeluaranPettyCashCashAdvance?->jobOrderDetailCashAdvance?->order;
        if ($this->buktiPengeluaranPettyCashCashAdvance?->buktiPenerimaanPettyCashCashAdvance) {
            $string .= ' ' . Html::tag('span', $this->buktiPengeluaranPettyCashCashAdvance?->buktiPenerimaanPettyCashCashAdvance->buktiPenerimaanPettyCash->reference_number, [
                    'class' => 'badge bg-success'
                ]);
        } else {
            $string .= ' ' . Html::tag('span', 'Kasbon belum lunas', ['class' => 'badge bg-danger']);
        }

        return $string;
    }


}
