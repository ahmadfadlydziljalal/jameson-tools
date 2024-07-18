<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\BuktiPengeluaranBukuBank as BaseBuktiPengeluaranBukuBank;
use Throwable;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "bukti_pengeluaran_buku_bank".
 */
class BuktiPengeluaranBukuBank extends BaseBuktiPengeluaranBukuBank
{
    const SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON = 'scenario_pengeluaran_by_cash_advance_or_kasbon';
    const SCENARIO_PENGELUARAN_BY_BILL = 'scenario_pengeluaran_by_bill';
    const SCENARIO_PENGELUARAN_BY_PETTY_CASH = 'scenario_pengeluaran_by_bill_saldo_petty_cash';
    const PEMBAYARAN_CASH_ADVANCE_OR_KASBON = 'Cash Advance / Kasbon';
    const PEMBAYARAN_BILL_JOB_ORDER = 'Bill Job Order';
    const PEMBAYARAN_MUTASI_KAS_PETTY_CASH = 'Mutasi Kas Petty Cash';

    public ?array $cashAdvances = [];
    public ?string $pettyCash = null;
    public ?array $bills = [];
    public ?string $tujuanBayar = null;
    public ?array $referensiPembayaran = null;
    public float|int $totalBayar = 0;

    public function afterFind(): void
    {
        parent::afterFind();

        // Bayar untuk kasbon
        if ($this->jobOrderDetailCashAdvances) {
            $this->tujuanBayar = static::PEMBAYARAN_CASH_ADVANCE_OR_KASBON;
            $this->referensiPembayaran['businessProcess'] = static::PEMBAYARAN_CASH_ADVANCE_OR_KASBON;
            foreach ($this->jobOrderDetailCashAdvances as $cashAdvance) {
                $this->totalBayar += $cashAdvance->cash_advance;
                $this->referensiPembayaran['data'][] = [
                    'jobOrder' => $cashAdvance->jobOrder->reference_number,
                    'vendor' => $cashAdvance->vendor->nama,
                    'reference_number' => 'Kasbon ke ' . $cashAdvance->order,
                    'total' => round($cashAdvance->cash_advance, 2),
                ];
            }
        }

        // Bayar untuk tagihan
        if ($this->jobOrderBills) {

            $this->tujuanBayar = static::PEMBAYARAN_BILL_JOB_ORDER;
            $this->referensiPembayaran['businessProcess'] = static::PEMBAYARAN_BILL_JOB_ORDER;

            foreach ($this->jobOrderBills as $jobOrderBill) {
                $this->totalBayar += $jobOrderBill->getTotalPrice();
                $this->referensiPembayaran['data'][] = [
                    'jobOrder' => $jobOrderBill->jobOrder->reference_number,
                    'vendor' => $jobOrderBill->vendor->nama,
                    'reference_number' => $jobOrderBill->reference_number,
                    'total' => round($jobOrderBill->getTotalPrice(), 2),
                ];
            }

        }

        // Bayar untuk penambahan saldo Petty Cash
        if ($this->jobOrderDetailPettyCash) {

            $this->tujuanBayar = static::PEMBAYARAN_MUTASI_KAS_PETTY_CASH;
            $this->referensiPembayaran['businessProcess'] = static::PEMBAYARAN_MUTASI_KAS_PETTY_CASH;

            $this->totalBayar = $this->jobOrderDetailPettyCash->nominal;
            $this->referensiPembayaran['data'][] = [
                'jobOrder' => $this->jobOrderDetailPettyCash->jobOrder->reference_number,
                'vendor' => $this->jobOrderDetailPettyCash->vendor->nama,
                'total' => $this->totalBayar,
            ];

        }
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors(): array
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

    /**
     * @inheritDoc
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [[
                'vendor_id',
                'rekening_saya_id',
                'nomor_bukti_transaksi',
                'tanggal_transaksi',
                'cashAdvances'
            ], 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON],
            [[
                'vendor_id',
                'rekening_saya_id',
                'nomor_bukti_transaksi',
                'tanggal_transaksi',
                'bills'
            ], 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_BILL],
            [[
                'vendor_id',
                'rekening_saya_id',
                'nomor_bukti_transaksi',
                'tanggal_transaksi',
                'pettyCash'
            ], 'required', 'on' => self::SCENARIO_PENGELUARAN_BY_PETTY_CASH],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON] = [
            'vendor_id',
            'vendor_rekening_id',
            'rekening_saya_id',
            'jenis_transfer_id',
            'nomor_bukti_transaksi',
            'tanggal_transaksi',
            'cashAdvances',
            'keterangan',
        ];
        $scenarios[self::SCENARIO_PENGELUARAN_BY_BILL] = [
            'vendor_id',
            'vendor_rekening_id',
            'rekening_saya_id',
            'jenis_transfer_id',
            'nomor_bukti_transaksi',
            'tanggal_transaksi',
            'bills',
            'keterangan',
        ];
        $scenarios[self::SCENARIO_PENGELUARAN_BY_PETTY_CASH] = [
            'vendor_id',
            'vendor_rekening_id',
            'rekening_saya_id',
            'jenis_transfer_id',
            'nomor_bukti_transaksi',
            'tanggal_transaksi',
            'pettyCash',
            'keterangan',
        ];
        return $scenarios;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'cashAdvances' => 'Kasbon-kasbon / Cash Advance',
        ]);
    }

    /**
     * @return bool
     */
    public function saveForCashAdvances(): bool
    {
        if (!$this->validate()) return false;

        // update case
        $setNull = [];
        if (!$this->isNewRecord) {
            $oldInvoice = ArrayHelper::map($this->jobOrderDetailCashAdvances, 'id', 'id');
            $setNull = array_diff($oldInvoice, $this->cashAdvances);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {

                if (!empty($setNull)) {

                    JobOrderDetailCashAdvance::updateAll(
                        ['job_order_detail_cash_advance.bukti_pengeluaran_buku_bank_id' => null],
                        ['id' => $setNull]
                    );

                }

                foreach ($this->cashAdvances as $cashAdvanceID) {
                    if ($jobOrderDetailCashAdvance = JobOrderDetailCashAdvance::findOne($cashAdvanceID)) {
                        if (!$flag) break;

                        $jobOrderDetailCashAdvance->bukti_pengeluaran_buku_bank_id = $this->id;
                        $flag = $jobOrderDetailCashAdvance->markAsPaidFromBuktiPengeluaranBukuBank($this->id);
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

    /**
     * @return bool
     */
    public function saveForBills(): bool
    {
        if (!$this->validate()) return false;

        // update case
        $setNull = [];
        if (!$this->isNewRecord) {
            $oldBills = ArrayHelper::map($this->jobOrderBills, 'id', 'id');
            $setNull = array_diff($oldBills, $this->bills);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {

                if (!empty($setNull)) {
                    JobOrderBill::updateAll(
                        ['job_order_bill.bukti_pengeluaran_buku_bank_id' => null],
                        ['id' => $setNull]
                    );
                }

                foreach ($this->bills as $billID) {
                    if ($jobOrderBill = JobOrderBill::findOne($billID)) {
                        if (!$flag) break;
                        $jobOrderBill->bukti_pengeluaran_buku_bank_id = $this->id;
                        $flag = $jobOrderBill->save(false);
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

    /**
     * @throws Throwable
     */
    public function deleteByCashAdvance(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $flag = true;

            /* Kasbon / Cash advance di reverse dari panjar ke kasbon field */
            foreach ($this->jobOrderDetailCashAdvances as $jobOrderDetailCashAdvance) {
                if (!$flag) break;
                $flag = $jobOrderDetailCashAdvance->reverseMarkAsPaidFromBuktiPengeluaranBukuBank();
            }

            if ($flag) {
                if ($this->delete()) {
                    $transaction->commit();
                    return true;
                }
            } else {
                $transaction->rollBack();
            }

        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

    public function saveForPettyCash(): bool
    {
        if(!$this->validate()){
            return false;
        }

        // Dalam kasus update, cek kalau ada perubahan pilihan petty cash
        $oldJobOrderDetailPettyCashID = null;
        if(!$this->isNewRecord AND $oldJobOrderDetailPettyCashID != $this->pettyCash){
            $oldJobOrderDetailPettyCashID= $this->jobOrderDetailPettyCash->id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($flag = $this->save(false)){

                if(!is_null($oldJobOrderDetailPettyCashID)){
                    $existingPettyCash = JobOrderDetailPettyCash::findOne($oldJobOrderDetailPettyCashID);
                    $existingPettyCash->bukti_pengeluaran_buku_bank_id = null;
                    $flag = $existingPettyCash->save(false);
                }

                if($flag){
                    if($pettyCash = JobOrderDetailPettyCash::findOne($this->pettyCash)){
                        $pettyCash->bukti_pengeluaran_buku_bank_id = $this->id;
                        $flag = $pettyCash->save(false);
                    }else{
                        $flag = false;
                    }
                }
            }

            if($flag){
                $transaction->commit();
                return true;
            }else{
                $transaction->rollBack();
            }

        }catch (Exception $e){
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }


}
