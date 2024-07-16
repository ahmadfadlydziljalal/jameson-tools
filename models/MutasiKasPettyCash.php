<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\enums\KodeVoucherEnum;
use \app\models\base\MutasiKasPettyCash as BaseMutasiKasPettyCash;
use mdm\autonumber\AutoNumber;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "mutasi_kas_petty_cash".
 */
class MutasiKasPettyCash extends BaseMutasiKasPettyCash
{
    const SCENARIO_BUKTI_PENGELUARAN_PETTY_CASH = 'scenario_bukti_pengeluaran_petty_cash';
    const SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH = 'scenario_bukti_penerimaan_petty_cash';

    public ?string $businessProcess = null;
    public ?string $nominal = null;
    public ?string $vendorName = null;

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_pengeluaran_petty_cash_id' => 'Bukti Pengeluaran',
            'bukti_penerimaan_petty_cash_id' => 'Bukti Penerimaan',
            'nomor_voucher' => 'Voucher',
            'tanggal_mutasi' => 'Tgl. Mutasi',
            'vendorName' => 'Vendor',
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['bukti_pengeluaran_petty_cash_id', 'required', 'on' => self::SCENARIO_BUKTI_PENGELUARAN_PETTY_CASH],
            ['bukti_penerimaan_petty_cash_id', 'required', 'on' => self::SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH],
        ]);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_BUKTI_PENGELUARAN_PETTY_CASH] = [
            'bukti_pengeluaran_petty_cash_id',
            'tanggal_mutasi',
            'keterangan',
        ];
        $scenarios[self::SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH] = [
            'bukti_penerimaan_petty_cash_id',
            'tanggal_mutasi',
            'keterangan',
        ];
        return $scenarios;
    }

    public function beforeSave($insert): bool
    {
        if($insert){
            switch ($this->kode_voucher_id){
                case KodeVoucherEnum::CR->value:
                    $this->nomor_voucher = AutoNumber::generate(KodeVoucherEnum::CR->name ."?", false, 4,[date('Y')]); // Reset setiap ganti tahun
                    break;
                case KodeVoucherEnum::CP->value;
                    $this->nomor_voucher = AutoNumber::generate(KodeVoucherEnum::CP->name ."?", false, 4,[date('Y')]); // Reset setiap ganti tahun
                    break;
                default:
                    break;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        # Pencatatan dari bukti pengeluaran
        if($this->bukti_pengeluaran_petty_cash_id){
            if($this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance){
                $this->businessProcess =
                    'Kasbon ke ' .$this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->order . ', '.
                    $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->jobOrder->reference_number;
                $this->nominal = $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->cash_advance;
                $this->vendorName = $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->vendor->nama;
            }
            if($this->buktiPengeluaranPettyCash->jobOrderBill){
                $this->businessProcess =
                    'Payment Bill ' . $this->buktiPengeluaranPettyCash->jobOrderBill->reference_number. ', '.
                    $this->buktiPengeluaranPettyCash->jobOrderBill->jobOrder->reference_number
                ;
                $this->nominal = $this->buktiPengeluaranPettyCash->jobOrderBill->getTotalPrice();
                $this->vendorName = $this->buktiPengeluaranPettyCash->jobOrderBill->vendor->nama;
            }
        }

        # Pencatatan dari pengeluaran lainnya
        if($this->transaksiMutasiKasPettyCashLainnya && $this->transaksiMutasiKasPettyCashLainnya->jenis_biaya_id){
            $this->businessProcess = 'Pengeluaran lainnya';
            $this->nominal = $this->transaksiMutasiKasPettyCashLainnya->nominal;
            $this->vendorName = $this->transaksiMutasiKasPettyCashLainnya->card->nama;
        }

        # Pencatatan dari bukti penerimaan
        if($this->bukti_penerimaan_petty_cash_id){
            if($this->buktiPenerimaanPettyCash){
                $this->businessProcess =
                    'Pengembalian Kasbon ke ' . $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order. ', '.
                    $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number;
                $this->nominal = $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance;
                $this->vendorName =$this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->vendor->nama;
            }
        }

        # Pencatatan dari penerimaan lainnya
        if($this->transaksiMutasiKasPettyCashLainnya && $this->transaksiMutasiKasPettyCashLainnya->jenis_pendapatan_id){
            $this->businessProcess = 'Penerimaan lainnya';
            $this->nominal = $this->transaksiMutasiKasPettyCashLainnya->nominal;
            $this->vendorName = $this->transaksiMutasiKasPettyCashLainnya->card->nama;
        }
    }

    public function saveByBuktiPengeluaranPettyCash(): bool
    {
        if(!$this->validate()){
            return false;
        }
        return $this->save(false);
    }

    public function saveByBuktiPenerimaanPettyCash(): bool
    {
        if(!$this->validate()){
            return false;
        }
        return $this->save(false);
    }

    /**
     * @param TransaksiMutasiKasPettyCashLainnya $modelTransaksiLainnya
     * @return bool
     */
    public function saveTransaksiLainnya(TransaksiMutasiKasPettyCashLainnya $modelTransaksiLainnya): bool
    {

        if(!$this->validate() AND !$modelTransaksiLainnya->validate()){
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($this->save(false)){
                $modelTransaksiLainnya->mutasi_kas_petty_cash_id = $this->id;
                if($modelTransaksiLainnya->save(false)){
                    $transaction->commit();
                    return true;
                }else{
                    $transaction->rollBack();
                }
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
