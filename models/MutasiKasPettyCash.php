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
    const SCENARIO_RESTORE = 'scenario_restore';

    public ?string $businessProcess = null;
    public ?string $nominal = null;
    public ?string $cardName = null;

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_pengeluaran_petty_cash_id' => 'Bukti Pengeluaran',
            'bukti_penerimaan_petty_cash_id' => 'Bukti Penerimaan',
            'nomor_voucher' => 'Voucher',
            'tanggal_mutasi' => 'Tgl. Mutasi',
            'vendorName' => 'Vendor',
        ]);
    }

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            ['bukti_pengeluaran_petty_cash_id', 'required', 'on' => self::SCENARIO_BUKTI_PENGELUARAN_PETTY_CASH],
            ['bukti_penerimaan_petty_cash_id', 'required', 'on' => self::SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH],
        ]);
    }

    public function scenarios(): array
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
        $scenarios[self::SCENARIO_RESTORE] = array_keys($this->attributes);
        return $scenarios;
    }

    public function beforeSave($insert): bool
    {
        if($insert){
            if($this->scenario != self::SCENARIO_RESTORE){
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
        }
        return parent::beforeSave($insert);
    }

    public function afterFind(): void
    {
        parent::afterFind();

        # Pencatatan dari bukti pengeluaran
        if($this->bukti_pengeluaran_petty_cash_id){
            if($this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance){
                $this->businessProcess =
                    'Kasbon ke ' .$this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->order . ', '.
                    $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->jobOrder->reference_number;
                $this->nominal = $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->cash_advance;
                $this->cardName = $this->buktiPengeluaranPettyCash->jobOrderDetailCashAdvance->vendor->nama;
            }
            if($this->buktiPengeluaranPettyCash->jobOrderBill){
                $this->businessProcess =
                    'Payment Bill ' . $this->buktiPengeluaranPettyCash->jobOrderBill->reference_number. ', '.
                    $this->buktiPengeluaranPettyCash->jobOrderBill->jobOrder->reference_number
                ;
                $this->nominal = $this->buktiPengeluaranPettyCash->jobOrderBill->getTotalPrice();
                $this->cardName = $this->buktiPengeluaranPettyCash->jobOrderBill->vendor->nama;
            }
        }

        # Pencatatan dari pengeluaran lainnya
        if($this->transaksiMutasiKasPettyCashLainnya && $this->transaksiMutasiKasPettyCashLainnya->jenis_biaya_id){
            $this->businessProcess = 'Pengeluaran lainnya';
            $this->nominal = $this->transaksiMutasiKasPettyCashLainnya->nominal;
            $this->cardName = $this->transaksiMutasiKasPettyCashLainnya->card->nama;
        }

        # Pencatatan dari bukti penerimaan
        if($this->bukti_penerimaan_petty_cash_id){

            # Dari pengembalian kasbon
            if($this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance){
                $this->businessProcess =
                    'Pengembalian Kasbon ke ' . $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->order. ', '.
                    $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number;
                $this->nominal = $this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance;
                $this->cardName =$this->buktiPenerimaanPettyCash->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->vendor->nama;
            }

            # Dari Buku Bank
            if($this->buktiPenerimaanPettyCash->bukuBank){
                $this->businessProcess = 'Mutasi Bank ' . $this->buktiPenerimaanPettyCash->bukuBank->nomor_voucher;
                $this->nominal = $this->buktiPenerimaanPettyCash->bukuBank->buktiPengeluaranBukuBank->jobOrderDetailPettyCash->nominal;
                $this->cardName  =  $this->buktiPenerimaanPettyCash->bukuBank->buktiPengeluaranBukuBank->vendor->nama;
            }
        }

        # Pencatatan dari penerimaan lainnya
        if($this->transaksiMutasiKasPettyCashLainnya && $this->transaksiMutasiKasPettyCashLainnya->jenis_pendapatan_id){
            $this->businessProcess = 'Penerimaan lainnya';
            $this->nominal = $this->transaksiMutasiKasPettyCashLainnya->nominal;
            $this->cardName = $this->transaksiMutasiKasPettyCashLainnya->card->nama;
        }

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
