<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use \app\models\active_queries\JobOrderQuery;

/**
 * This is the base-model class for table "job_order".
 *
 * @property integer $id
 * @property string $reference_number
 * @property integer $main_vendor_id
 * @property integer $main_customer_id
 * @property integer $is_for_petty_cash
 * @property string $keterangan
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\models\JobOrderBill[] $jobOrderBills
 * @property \app\models\JobOrderDetailCashAdvance[] $jobOrderDetailCashAdvances
 * @property \app\models\Card $mainCustomer
 * @property \app\models\Card $mainVendor
 */
abstract class JobOrder extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_order';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['blameable'] = [
            'class' => BlameableBehavior::class,
        ];
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
                        ];
        
    return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['main_vendor_id', 'main_customer_id'], 'required'],
            [['main_vendor_id', 'main_customer_id', 'is_for_petty_cash'], 'integer'],
            [['keterangan'], 'string'],
            [['reference_number'], 'string', 'max' => 24],
            [['main_customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['main_customer_id' => 'id']],
            [['main_vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['main_vendor_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'reference_number' => 'Reference Number',
            'main_vendor_id' => 'Main Vendor ID',
            'main_customer_id' => 'Main Customer ID',
            'is_for_petty_cash' => 'Is For Petty Cash',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'main_vendor_id' => 'Kepada',
            'main_customer_id' => 'Ditagihkan',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderBills()
    {
        return $this->hasMany(\app\models\JobOrderBill::class, ['job_order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderDetailCashAdvances()
    {
        return $this->hasMany(\app\models\JobOrderDetailCashAdvance::class, ['job_order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainCustomer()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'main_customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainVendor()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'main_vendor_id']);
    }

    /**
     * @inheritdoc
     * @return JobOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobOrderQuery(static::class);
    }
}
