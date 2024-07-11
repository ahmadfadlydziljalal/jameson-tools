<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation_form_job".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property string $nomor
 * @property string $tanggal
 * @property string $person_in_charge
 * @property string $issue
 * @property integer $card_own_equipment_id
 * @property string $hour_meter
 * @property integer $mekanik_id
 * @property string $remarks
 *
 * @property \app\models\CardOwnEquipment $cardOwnEquipment
 * @property \app\models\Card $mekanik
 * @property \app\models\Quotation $quotation
 * @property \app\models\QuotationFormJobMekanik[] $quotationFormJobMekaniks
 * @property string $aliasModel
 */
abstract class QuotationFormJob extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_form_job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quotation_id', 'card_own_equipment_id', 'mekanik_id'], 'integer'],
            [['tanggal'], 'required'],
            [['tanggal'], 'safe'],
            [['issue', 'remarks'], 'string'],
            [['nomor', 'person_in_charge', 'hour_meter'], 'string', 'max' => 255],
            [['quotation_id'], 'unique'],
            [['mekanik_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['mekanik_id' => 'id']],
            [['card_own_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CardOwnEquipment::class, 'targetAttribute' => ['card_own_equipment_id' => 'id']],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Quotation::class, 'targetAttribute' => ['quotation_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal',
            'person_in_charge' => 'Person In Charge',
            'issue' => 'Issue',
            'card_own_equipment_id' => 'Card Own Equipment ID',
            'hour_meter' => 'Hour Meter',
            'mekanik_id' => 'Mekanik ID',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'person_in_charge' => 'Perwakilan customer',
            'card_own_equipment_id' => 'Nomor Unit',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardOwnEquipment()
    {
        return $this->hasOne(\app\models\CardOwnEquipment::class, ['id' => 'card_own_equipment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMekanik()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'mekanik_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotation()
    {
        return $this->hasOne(\app\models\Quotation::class, ['id' => 'quotation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationFormJobMekaniks()
    {
        return $this->hasMany(\app\models\QuotationFormJobMekanik::class, ['quotation_form_job_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\QuotationFormJobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationFormJobQuery(get_called_class());
    }


}
