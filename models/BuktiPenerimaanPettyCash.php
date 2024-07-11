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
    public ?string $buktiPengeluaranKasbonReferenceNumber = null;


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
           ['buktiPengeluaranKasbonReferenceNumber', 'required', 'on' => self::SCENARIO_REALISASI_KASBON],
        ]);
    }

    public function scenarios()
    {
        $parent = parent::scenarios();
        $parent[self::SCENARIO_REALISASI_KASBON] = [
            'buktiPengeluaranKasbonReferenceNumber',
        ];

        return $parent;
    }

    public function createByRealisasiKasbon()
    {
        if(!$this->validate()){
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($flag = $this->save(false)){
                $flag = (new BuktiPenerimaanPettyCashCashAdvance([
                    'bukti_penerimaan_petty_cash_id' => $this->id,
                    'bukti_pengeluaran_petty_cash_cash_advance_id' => $this->buktiPengeluaranKasbonReferenceNumber,
                ]))->save(false);
            }

            if($flag){
                $transaction->commit();
                return true;
            }else{
                $transaction->rollBack();
            }
        }catch(Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

    public function updateByRealisasiKasbon()
    {

        if(!$this->validate()){
            return false;
        }

        if ($this->buktiPenerimaanPettyCashCashAdvance->bukti_pengeluaran_petty_cash_cash_advance_id == $this->buktiPengeluaranKasbonReferenceNumber) {
            //  do nothing
            return true;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($flag = $this->buktiPenerimaanPettyCashCashAdvance->delete()) {
                $flag = (new BuktiPenerimaanPettyCashCashAdvance([
                    'bukti_penerimaan_petty_cash_id' => $this->id,
                    'bukti_pengeluaran_petty_cash_cash_advance_id' => $this->buktiPengeluaranKasbonReferenceNumber,
                ]))->save(false);
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
}
