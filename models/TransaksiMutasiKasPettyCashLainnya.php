<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\TransaksiMutasiKasPettyCashLainnya as BaseTransaksiMutasiKasPettyCashLainnya;
use mdm\autonumber\AutoNumber;

/**
 * This is the model class for table "transaksi_mutasi_kas_petty_cash_lainnya".
 */
class TransaksiMutasiKasPettyCashLainnya extends BaseTransaksiMutasiKasPettyCashLainnya
{

    const SCENARIO_PENERIMAAN = 'scenario-penerimaan';
    const SCENARIO_PENGELUARAN = 'scenario-pengeluaran';


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
           [['jenis_pendapatan_id', 'nominal'], 'required', 'on' => self::SCENARIO_PENERIMAAN],
           [['jenis_biaya_id', 'nominal'], 'required', 'on' => self::SCENARIO_PENGELUARAN],
        ]);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PENERIMAAN] = [
            'card_id',
            'jenis_pendapatan_id',
            'nominal',
        ];
        $scenarios[self::SCENARIO_PENGELUARAN] = [
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
                $this->reference_number = AutoNumber::generate("?" . "/PC-OUT-OTH/" .date('Y'), false, 4);
            }

            # Penerimaan
            if($this->jenis_pendapatan_id){
                $this->reference_number = AutoNumber::generate("?" . "/PC-IN-OTH/" .date('Y'), false, 4);
            }
        }
        return parent::beforeSave($insert);
    }

}
