<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\BuktiPenerimaanPettyCash as BaseBuktiPenerimaanPettyCash;
use Yii;
use yii\db\Exception;
use yii\helpers\Inflector;

/**
 * This is the model class for table "bukti_penerimaan_petty_cash".
 */
class BuktiPenerimaanPettyCash extends BaseBuktiPenerimaanPettyCash
{
    const SCENARIO_REALISASI_KASBON = 'scenario_realisasi_kasbon';
    const DANA_DARI_MUTASI_KAS_BANK = 'mutasi_kas_bank';
    const DANA_DARI_REALISASI_PENGEMBALIAN_KASBON = 'realisasi_pengembalian_kasbon';

    public ?array $referensiPenerimaan = null;
    public int|float $nominal = 0;
    public ?string $nomorVoucherMutasiKasPettyCash = null;

    public function afterFind(): void
    {
        parent::afterFind();

        if($this->bukti_pengeluaran_petty_cash_cash_advance_id){
            $this->nominal = $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance;
            $this->referensiPenerimaan['businessProcess'] =  ucwords(Inflector::humanize(static::DANA_DARI_REALISASI_PENGEMBALIAN_KASBON));
            $this->referensiPenerimaan['data'] = [
                'jobOrder' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number,
                'buktiPengeluaran' =>$this->buktiPengeluaranPettyCashCashAdvance->reference_number,
                'jenisBiaya' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name,
                'vendor' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->vendor->nama,
                'nominal' => $this->nominal,
            ];
        }

        if($this->buku_bank_id){

            foreach ($this->bukuBank->buktiPengeluaranBukuBank->jobOrderBills as $jobOrderBill){
                $this->nominal +=  $jobOrderBill->getTotalPrice();
            }

            $this->referensiPenerimaan['businessProcess'] =  ucwords(Inflector::humanize(static::DANA_DARI_MUTASI_KAS_BANK));
            $this->referensiPenerimaan['data'] = [
                'jobOrder' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderBills[0]->jobOrder->reference_number,
                'buktiPengeluaran' => $this->bukuBank->buktiPengeluaranBukuBank->reference_number,
                'jenisBiaya' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderBills[0]->jobOrderBillDetails[0]->jenisBiaya->name,
                'vendor' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderBills[0]->vendor->nama,
                'nominal' => $this->nominal,
            ];
        }


    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/BP-IN-PC/' . date('Y'), // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
           ['bukti_pengeluaran_petty_cash_cash_advance_id', 'required', 'on' => self::SCENARIO_REALISASI_KASBON],
        ]);
    }

    public function scenarios()
    {
        $parent = parent::scenarios();
        $parent[self::SCENARIO_REALISASI_KASBON] = [
            'bukti_pengeluaran_petty_cash_cash_advance_id',
        ];

        return $parent;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_pengeluaran_petty_cash_cash_advance_id' => 'Bukti Pengeluaran',
            'nomorVoucherMutasiKasPettyCash' => 'Voucher',
        ]);
    }

    public function createByCashAdvanceRealization()
    {
        if(!$this->validate()){
            return false;
        }

        return $this->save(false);

    }

    public function updateByRealisasiKasbon()
    {

        if(!$this->validate()){
            return false;
        }

        if ($this->getOldAttribute('bukti_pengeluaran_petty_cash_cash_advance_id') == $this->bukti_pengeluaran_petty_cash_cash_advance_id) {
            //  do nothing
            return true;
        }

        return $this->save(false);
    }
}
