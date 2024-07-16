<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\BuktiPengeluaranBukuBank as BaseBuktiPengeluaranBukuBank;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "bukti_pengeluaran_buku_bank".
 */
class BuktiPengeluaranBukuBank extends BaseBuktiPengeluaranBukuBank
{
    const SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON = 'scenario_pengeluaran_by_cash_advance_or_kasbon';
    const SCENARIO_PENGELUARAN_BY_BILL = 'scenario_pengeluaran_by_bill';

    public ?array $cashAdvances = [];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/BP-OUT-BB/' . date('Y'), // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [[
                'rekening_saya_id',
                'vendor_id',
                'nomor_bukti_transaksi',
                'tanggal_transaksi',
                'cashAdvances'
            ], 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON],
        ]);
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'cashAdvances' => 'Kasbon-kasbon / Cash Advance',
        ]);
    }

    public function saveForCashAdvances(): bool
    {
        if (!$this->validate()) return false;

        // update case
        $setNull = [];
        if(!$this->isNewRecord) {
            $oldInvoice = ArrayHelper::map($this->jobOrderDetailCashAdvances, 'id', 'id');
            $setNull = array_diff($oldInvoice, $this->cashAdvances);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {

                if (!empty($setNull)) {
                    JobOrderDetailCashAdvance::updateAll(['job_order_detail_cash_advance.bukti_pengeluaran_buku_bank_id' => null],[ 'id' => $setNull]);
                }

                foreach ($this->cashAdvances as $cashAdvanceID) {
                    if ($jobOrderDetailCashAdvance = JobOrderDetailCashAdvance::findOne($cashAdvanceID)) {
                        if (!$flag) break;
                        $jobOrderDetailCashAdvance->bukti_pengeluaran_buku_bank_id = $this->id;
                        $flag = $jobOrderDetailCashAdvance->save(false);
                    } else {
                        $flag = false;
                        break;
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


}
