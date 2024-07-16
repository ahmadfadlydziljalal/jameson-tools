<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\enums\KodeVoucherEnum;
use app\models\base\BukuBank as BaseBukuBank;
use mdm\autonumber\AutoNumber;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;

/**
 * This is the model class for table "buku_bank".
 */
class BukuBank extends BaseBukuBank
{

    const SCENARIO_BUKTI_PENERIMAAN_BUKU_BANK = 'scenario_buku_penerimaan_buku_bank';
    const SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK = 'scenario_buku_pengeluaran_buku_bank';

    public string|array|null $businessProcess = null;
    public ?string $nominal = null;
    public ?string $cardName = null;

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            ['bukti_penerimaan_buku_bank_id', 'required', 'on' => self::SCENARIO_BUKTI_PENERIMAAN_BUKU_BANK],
            ['bukti_pengeluaran_buku_bank_id', 'required', 'on' => self::SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK],
        ]);
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_BUKTI_PENERIMAAN_BUKU_BANK] = [
            'bukti_penerimaan_buku_bank_id',
            'tanggal_transaksi',
            'keterangan',
        ];
        $scenarios[self::SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK] = [
            'bukti_pengeluaran_buku_bank_id',
            'tanggal_transaksi',
            'keterangan',
        ];
        return $scenarios;
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->nomor_voucher = AutoNumber::generate(KodeVoucherEnum::JP->name . "?", false, 4, [date('Y')]); // Reset setiap ganti tahun
        }
        return parent::beforeSave($insert);
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_penerimaan_buku_bank_id' => 'Bukti Penerimaan',
            'bukti_pengeluaran_buku_bank_id' => 'Bukti Pengeluaran',
            'nomor_voucher' => 'Voucher',
        ]);
    }

    public function afterFind(): void
    {
        parent::afterFind();

        if($this->bukti_pengeluaran_buku_bank_id){
            $this->businessProcess = $this->buktiPengeluaranBukuBank->referensiPembayaran;
        }

        if($this->bukti_penerimaan_buku_bank_id){
            $this->businessProcess = $this->buktiPenerimaanBukuBank->referensiPenerimaan;
        }

        if($this->transaksiBukuBankLainnya AND $this->transaksiBukuBankLainnya->jenis_biaya_id){
            $this->businessProcess = [
                'businessProcess' => 'Pengeluaran Buku Bank Lainnya',
                'data' => [
                    'vendor' => $this->transaksiBukuBankLainnya->card->nama,
                    'biaya' => $this->transaksiBukuBankLainnya->jenisBiaya->name,
                    'nominal' => $this->transaksiBukuBankLainnya->nominal,
                ]
            ];
        }

        if($this->transaksiBukuBankLainnya AND $this->transaksiBukuBankLainnya->jenis_pendapatan_id){
            $this->businessProcess = [
                'businessProcess' => 'Pendapatan Buku Bank Lainnya',
                'data' => [
                    'vendor' => $this->transaksiBukuBankLainnya->card->nama,
                    'biaya' => $this->transaksiBukuBankLainnya->jenisPendapatan->name,
                    'nominal' => $this->transaksiBukuBankLainnya->nominal,
                ]
            ];
        }
    }

    public function saveTransaksiLainnya(TransaksiBukuBankLainnya $modelTransaksiLainnya): bool
    {
        if (!$this->validate() and !$modelTransaksiLainnya->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($this->save(false)) {
                $modelTransaksiLainnya->buku_bank_id = $this->id;
                if ($modelTransaksiLainnya->save(false)) {
                    $transaction->commit();
                    return true;
                } else {
                    $transaction->rollBack();
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

}
