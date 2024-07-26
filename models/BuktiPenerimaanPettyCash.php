<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\models\base\BuktiPenerimaanPettyCash as BaseBuktiPenerimaanPettyCash;
use JetBrains\PhpStorm\ArrayShape;
use mdm\autonumber\AutoNumber;
use yii\db\Exception;
use yii\helpers\Inflector;

/**
 * This is the model class for table "bukti_penerimaan_petty_cash".
 */
class BuktiPenerimaanPettyCash extends BaseBuktiPenerimaanPettyCash
{
    const SCENARIO_REALISASI_KASBON = 'scenario_realisasi_kasbon';
    const SCENARIO_RESTORE = 'scenario_restore';
    const DANA_DARI_MUTASI_KAS_BANK = 'mutasi_kas_bank';
    const DANA_DARI_REALISASI_PENGEMBALIAN_KASBON = 'pengembalian_kasbon';

    public ?array $referensiPenerimaan = null;
    public int|float $nominal = 0;
    public ?string $nomorVoucherMutasiKasPettyCash = null;

    public function afterFind(): void
    {
        parent::afterFind();

        if ($this->bukti_pengeluaran_petty_cash_cash_advance_id) {
            $this->nominal = $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->cash_advance;
            $this->referensiPenerimaan['businessProcess'] = ucwords(Inflector::humanize(static::DANA_DARI_REALISASI_PENGEMBALIAN_KASBON));
            $this->referensiPenerimaan['data'] = [
                'jobOrder' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jobOrder->reference_number,
                'buktiPengeluaran' => $this->buktiPengeluaranPettyCashCashAdvance->reference_number,
                'jenisBiaya' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->jenisBiaya->name,
                'vendor' => $this->buktiPengeluaranPettyCashCashAdvance->jobOrderDetailCashAdvance->vendor->nama,
                'nominal' => $this->nominal,
            ];
        }

        if ($this->buku_bank_id) {
            $this->nominal += $this->bukuBank->buktiPengeluaranBukuBank->totalBayar;
            $this->referensiPenerimaan['businessProcess'] = ucwords(Inflector::humanize(static::DANA_DARI_MUTASI_KAS_BANK));
            $this->referensiPenerimaan['data'] = [
                'jobOrder' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderDetailPettyCash->jobOrder->reference_number,
                'buktiPengeluaran' => $this->bukuBank->buktiPengeluaranBukuBank->reference_number,
                'jenisBiaya' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderDetailPettyCash->jenisBiaya->name,
                'vendor' => $this->bukuBank->buktiPengeluaranBukuBank->jobOrderDetailPettyCash->vendor->nama,
                'nominal' => $this->nominal,
            ];
        }


    }

    /*public function behaviors()
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
    }*/

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['bukti_pengeluaran_petty_cash_cash_advance_id', 'required', 'on' => self::SCENARIO_REALISASI_KASBON],
        ]);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REALISASI_KASBON] = [
            'tanggal_transaksi',
            'bukti_pengeluaran_petty_cash_cash_advance_id',
        ];
        $scenarios[self::SCENARIO_RESTORE] = array_keys($this->attributes);
        return $scenarios;
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_pengeluaran_petty_cash_cash_advance_id' => 'Bukti Pengeluaran',
            'nomorVoucherMutasiKasPettyCash' => 'Voucher',
            'tanggal_transaksi' => 'Tgl. Transaksi',
            'buku_bank_id' => 'Buku Bank',
        ]);
    }

    public function createByCashAdvanceRealization()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->save(false);

    }

    public function updateByRealisasiKasbon()
    {

        if (!$this->validate()) {
            return false;
        }

        if ($this->getOldAttribute('bukti_pengeluaran_petty_cash_cash_advance_id') == $this->bukti_pengeluaran_petty_cash_cash_advance_id) {
            //  do nothing
            return true;
        }

        return $this->save(false);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->scenario != self::SCENARIO_RESTORE) {
                $this->reference_number = AutoNumber::generate('?' . '/BP-IN-PC/' . date('Y'), false, 4);
            }

        }
        return parent::beforeSave($insert);
    }

    public function getUpdateUrl(): array|string
    {
        if ($this->buktiPengeluaranPettyCashCashAdvance) {
            return ['bukti-penerimaan-petty-cash/update-by-realisasi-kasbon', 'id' => $this->id];
        }
        return '';
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

    /**
     * @throws Exception
     */
    #[ArrayShape(['status' => "bool", 'message' => "string"])]
    public function processRegisterToBukuBank(): array
    {
        $kodeVoucher = KodeVoucher::find()->pettyCashIn();
        $model = new MutasiKasPettyCash([
            'scenario' => MutasiKasPettyCash::SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH,
            'kode_voucher_id' => $kodeVoucher->id,
            'bukti_penerimaan_petty_cash_id' => $this->id,
            'tanggal_mutasi' => $this->tanggal_transaksi
        ]);

        $status = false;
        $message = '';
        if ($model->save()) {
            $status = true;
            $message = $this->reference_number . ' berhasil ditambahkan ke buku bank dengan nomor voucher <strong>' . $this->mutasiKasPettyCash->nomor_voucher . '</strong>';
        }
        return [
            'status' => $status,
            'message' => $message
        ];
    }

}
