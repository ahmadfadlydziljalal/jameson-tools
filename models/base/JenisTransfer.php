<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use \app\models\active_queries\JenisTransferQuery;

/**
 * This is the base-model class for table "jenis_transfer".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 *
 * @property \app\models\BuktiPenerimaanBukuBank[] $buktiPenerimaanBukuBanks
 */
abstract class JenisTransfer extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jenis_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return ArrayHelper::merge($parentRules, [
            [['name'], 'required'],
            [['name', 'alias'], 'string', 'max' => 50]
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
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuktiPenerimaanBukuBanks()
    {
        return $this->hasMany(\app\models\BuktiPenerimaanBukuBank::class, ['jenis_transfer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return JenisTransferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JenisTransferQuery(static::class);
    }
}
