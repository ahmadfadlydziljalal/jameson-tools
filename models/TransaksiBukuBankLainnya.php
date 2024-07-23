<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\TransaksiBukuBankLainnya as BaseTransaksiBukuBankLainnya;
use mdm\autonumber\AutoNumber;

/**
 * This is the model class for table "transaksi_buku_bank_lainnya".
 */
class TransaksiBukuBankLainnya extends BaseTransaksiBukuBankLainnya
{
    const SCENARIO_PENERIMAAN = 'scenario-penerimaan';
    const SCENARIO_PENGELUARAN = 'scenario-pengeluaran';
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['rekening_id','jenis_pendapatan_id', 'nominal'], 'required', 'on' => self::SCENARIO_PENERIMAAN],
            [['rekening_id','jenis_biaya_id', 'nominal'], 'required', 'on' => self::SCENARIO_PENGELUARAN],
        ]);
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PENERIMAAN] = [
            'rekening_id',
            'card_id',
            'jenis_pendapatan_id',
            'nominal',
        ];
        $scenarios[self::SCENARIO_PENGELUARAN] = [
            'rekening_id',
            'card_id',
            'jenis_biaya_id',
            'nominal',
        ];
        return $scenarios;
    }

    public function beforeSave($insert): bool
    {
        if($insert){
            # Pengeluaran
            if($this->jenis_biaya_id){
                $this->reference_number = AutoNumber::generate("?" . "/BB-OUT-OTH/" .date('Y'), false, 4);
            }

            # Penerimaan
            if($this->jenis_pendapatan_id){
                $this->reference_number = AutoNumber::generate("?" . "/BB-IN-OTH/" .date('Y'), false, 4);
            }
        }
        return parent::beforeSave($insert);
    }
}
