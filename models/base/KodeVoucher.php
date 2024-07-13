<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use \app\models\active_queries\KodeVoucherQuery;

/**
 * This is the base-model class for table "kode_voucher".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $singkatan
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\models\MutasiKasPettyCash[] $mutasiKasPettyCashes
 */
abstract class KodeVoucher extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kode_voucher';
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
            [['name'], 'required'],
            [['code', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['singkatan'], 'string', 'max' => 8],
            [['code'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'singkatan' => 'Singkatan',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMutasiKasPettyCashes()
    {
        return $this->hasMany(\app\models\MutasiKasPettyCash::class, ['kode_voucher_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return KodeVoucherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KodeVoucherQuery(static::class);
    }
}
