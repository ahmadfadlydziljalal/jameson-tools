<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use \app\models\active_queries\JobOrderBillDetailQuery;

/**
 * This is the base-model class for table "job_order_bill_detail".
 *
 * @property integer $id
 * @property integer $job_order_bill_id
 * @property integer $jenis_biaya_id
 * @property string $quantity
 * @property integer $satuan_id
 * @property string $name
 * @property string $price
 *
 * @property \app\models\JenisBiaya $jenisBiaya
 * @property \app\models\JobOrderBill $jobOrderBill
 * @property \app\models\Satuan $satuan
 */
abstract class JobOrderBillDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_order_bill_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['job_order_bill_id', 'jenis_biaya_id', 'satuan_id'], 'integer'],
            [['jenis_biaya_id', 'quantity', 'satuan_id', 'name', 'price'], 'required'],
            [['quantity', 'price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['job_order_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\JobOrderBill::class, 'targetAttribute' => ['job_order_bill_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Satuan::class, 'targetAttribute' => ['satuan_id' => 'id']],
            [['jenis_biaya_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\JenisBiaya::class, 'targetAttribute' => ['jenis_biaya_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'job_order_bill_id' => 'Job Order Bill ID',
            'jenis_biaya_id' => 'Jenis Biaya ID',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan ID',
            'name' => 'Name',
            'price' => 'Price',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisBiaya()
    {
        return $this->hasOne(\app\models\JenisBiaya::class, ['id' => 'jenis_biaya_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderBill()
    {
        return $this->hasOne(\app\models\JobOrderBill::class, ['id' => 'job_order_bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(\app\models\Satuan::class, ['id' => 'satuan_id']);
    }

    /**
     * @inheritdoc
     * @return JobOrderBillDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobOrderBillDetailQuery(static::class);
    }
}
