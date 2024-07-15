<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use \app\models\active_queries\PaymentMethodQuery;

/**
 * This is the base-model class for table "payment_method".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $code
 *
 * @property \app\models\SetoranKasirDetail[] $setoranKasirDetails
 */
abstract class PaymentMethod extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['name', 'alias', 'code'], 'required'],
            [['code'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'alias' => 'Alias',
            'code' => 'Code',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetoranKasirDetails()
    {
        return $this->hasMany(\app\models\SetoranKasirDetail::class, ['payment_method_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PaymentMethodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentMethodQuery(static::class);
    }
}
