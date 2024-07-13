<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\BuktiPenerimaanPettyCash as BaseBuktiPenerimaanPettyCash;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "bukti_penerimaan_petty_cash".
 */
class BuktiPenerimaanPettyCash extends BaseBuktiPenerimaanPettyCash
{

    const SCENARIO_REALISASI_KASBON = 'scenario_realisasi_kasbon';

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
