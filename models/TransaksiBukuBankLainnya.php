<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\TransaksiBukuBankLainnya as BaseTransaksiBukuBankLainnya;

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
}
