<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\enums\KodeVoucherEnum;
use app\models\base\BukuBank as BaseBukuBank;
use mdm\autonumber\AutoNumber;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\Json;

/**
 * This is the model class for table "buku_bank".
 */
class BukuBank extends BaseBukuBank
{
    const SCENARIO_BUKTI_PENERIMAAN_BUKU_BANK = 'scenario_buku_penerimaan_buku_bank';
    const SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK = 'scenario_buku_pengeluaran_buku_bank';
    const SCENARIO_RESTORE = 'scenario_restore';

    public string|array|null $businessProcess = null;
    public ?string $nominal = null;

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
        $scenarios[self::SCENARIO_RESTORE] = array_keys($this->attributes);
        return $scenarios;
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            if ($this->scenario != self::SCENARIO_RESTORE) {
                $this->nomor_voucher = AutoNumber::generate(KodeVoucherEnum::JP->name . "?", false, 4, [date('Y')]); // Reset setiap ganti tahun
            }

        }
        return parent::beforeSave($insert);
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'bukti_penerimaan_buku_bank_id' => 'Bukti Penerimaan',
            'bukti_pengeluaran_buku_bank_id' => 'Bukti Pengeluaran',
            'nomor_voucher' => 'Voucher',
            'tanggal_transaksi' => 'Tgl.Transaksi',
        ]);
    }

    public function afterFind(): void
    {
        parent::afterFind();

        if ($this->bukti_pengeluaran_buku_bank_id) {
            $this->nominal = $this->buktiPengeluaranBukuBank->totalBayar;
            $this->businessProcess = $this->buktiPengeluaranBukuBank->referensiPembayaran;

        }

        if ($this->bukti_penerimaan_buku_bank_id) {
            $this->nominal = round($this->buktiPenerimaanBukuBank->jumlah_setor);
            $this->businessProcess = $this->buktiPenerimaanBukuBank->referensiPenerimaan;
        }

        if ($this->transaksiBukuBankLainnya and $this->transaksiBukuBankLainnya->jenis_biaya_id) {
            $this->nominal = $this->transaksiBukuBankLainnya->nominal;
            $this->businessProcess = [
                'businessProcess' => 'Pengeluaran Buku Bank Lainnya',
                'bank' => ArrayHelper::toArray($this->transaksiBukuBankLainnya->rekening),
                'card' => ArrayHelper::toArray($this->transaksiBukuBankLainnya->card),
                'data' => [
                    'reference_number' => $this->transaksiBukuBankLainnya->reference_number,
                    'vendor' => $this->transaksiBukuBankLainnya->card->nama,
                    'biaya' => $this->transaksiBukuBankLainnya->jenisBiaya->name,
                    'nominal' => round($this->transaksiBukuBankLainnya->nominal, 2),
                ]
            ];
        }

        if ($this->transaksiBukuBankLainnya and $this->transaksiBukuBankLainnya->jenis_pendapatan_id) {
            $this->nominal = $this->transaksiBukuBankLainnya->nominal;
            $this->businessProcess = [
                'businessProcess' => 'Pendapatan Buku Bank Lainnya',
                'bank' => ArrayHelper::toArray($this->transaksiBukuBankLainnya->rekening),
                'card' => ArrayHelper::toArray($this->transaksiBukuBankLainnya->card),
                'data' => [
                    'reference_number' => $this->transaksiBukuBankLainnya->reference_number,
                    'vendor' => $this->transaksiBukuBankLainnya->card->nama,
                    'biaya' => $this->transaksiBukuBankLainnya->jenisPendapatan->name,
                    'nominal' => round($this->transaksiBukuBankLainnya->nominal, 2),
                ]
            ];
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getMutasiKasPettyCash(): ActiveQuery
    {
        return $this->hasOne(MutasiKasPettyCash::class, ['bukti_penerimaan_petty_cash_id' => 'id'])
            ->via('buktiPenerimaanPettyCash');
    }

    public function getNext(): ?BukuBank
    {
        return static::find()->where(['>', 'id', $this->id])->one();
    }

    public function getPrevious(): ?BukuBank
    {
        return static::find()->where(['<', 'id', $this->id])->orderBy('id desc')->one();
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

    public function saveWithoutMutasiKasPettyCash(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        return $this->save(false);
    }

    public function saveWithMutasiKasPettyCash(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        # set state for create | update
        $oldBuktiPenerimaanPettyCash = null;
        if (!$this->isNewRecord) {
            # update
            $oldBuktiPenerimaanPettyCash = $this->buktiPenerimaanPettyCash;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($flag = $this->save(false)) {

                // update case
                if ($oldBuktiPenerimaanPettyCash) {
                    $flag = $oldBuktiPenerimaanPettyCash->mutasiKasPettyCash->delete() &&
                        $oldBuktiPenerimaanPettyCash->delete();
                }

                // pengecekan flag untuk meng-support update case
                if ($flag) {

                    // kalau bukti pengeluaran untuk penambahan saldo mutasi kas
                    if ($this->buktiPengeluaranBukuBank->jobOrderDetailPettyCash) {
                        $buktiPenerimaanPettyCash = new BuktiPenerimaanPettyCash();
                        $buktiPenerimaanPettyCash->tanggal_transaksi = $this->tanggal_transaksi;
                        $buktiPenerimaanPettyCash->buku_bank_id = $this->id;
                        $flag = $buktiPenerimaanPettyCash->save(false);

                        if ($flag) {
                            $mutasiKasPettyCash = new MutasiKasPettyCash();
                            $mutasiKasPettyCash->kode_voucher_id = KodeVoucherEnum::CR->value;
                            $mutasiKasPettyCash->bukti_penerimaan_petty_cash_id = $buktiPenerimaanPettyCash->id;
                            $mutasiKasPettyCash->tanggal_mutasi = $this->tanggal_transaksi;
                            $flag = $mutasiKasPettyCash->save(false);
                        }
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
     * @throws Throwable
     */
    public function deleteWithMutasiKas(): bool
    {
        $data = [
            BukuBank::class => ArrayHelper::toArray($this),
            BuktiPenerimaanPettyCash::class => ArrayHelper::toArray($this->buktiPenerimaanPettyCash),
            MutasiKasPettyCash::class => ArrayHelper::toArray($this->buktiPenerimaanPettyCash->mutasiKasPettyCash),
        ];

        $transaction = Yii::$app->db->beginTransaction();
        try {

            # Save as data trash
            $model = new Trash([
                'name' => BukuBank::tableName(),
                'key' => $this->id,
                'data' => Json::encode($data)
            ]);

            if ($flag = $model->save()) {
                if ($flag = $this->buktiPenerimaanPettyCash->mutasiKasPettyCash->delete()) {
                    if ($flag = $this->buktiPenerimaanPettyCash->delete()) {
                        $flag = $this->delete();
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

    public function getUpdateUrl(): array|string
    {
        # Dengan bukti penerimaan buku bank
        if ($this->bukti_penerimaan_buku_bank_id) {
            return ['buku-bank/update-by-bukti-penerimaan-buku-bank', 'id' => $this->id];
        }

        # Dengan penerimaan lainnya
        if ($this->transaksiBukuBankLainnya and $this->transaksiBukuBankLainnya->jenis_pendapatan_id) {
            return ['buku-bank/update-by-penerimaan-lainnya', 'id' => $this->id];
        }

        # Dengan bukti pengeluaran buku bank
        if ($this->bukti_pengeluaran_buku_bank_id) {

            # With mutasi kas
            if ($this->buktiPengeluaranBukuBank->jobOrderDetailPettyCash) {
                return ['buku-bank/update-by-bukti-pengeluaran-buku-bank-to-mutasi-kas', 'id' => $this->id];
            }
            # Without mutasi kas
            return ['buku-bank/update-by-bukti-pengeluaran-buku-bank', 'id' => $this->id];
        }

        # Dengan pengeluaran lainnya
        if ($this->transaksiBukuBankLainnya and $this->transaksiBukuBankLainnya->jenis_biaya_id) {
            return ['buku-bank/update-by-pengeluaran-lainnya', 'id' => $this->id];
        }

        return '';
    }

    public function getDeleteUrl(): array
    {
        if ($this->buktiPenerimaanPettyCash) {
            return ['delete-with-mutasi-kas', 'id' => $this->id];
        }
        return ['delete', 'id' => $this->id];
    }

}
