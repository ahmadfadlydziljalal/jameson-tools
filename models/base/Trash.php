<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use \app\models\active_queries\TrashQuery;

/**
 * This is the base-model class for table "trash".
 *
 * @property integer $id
 * @property string $name
 * @property integer $key
 * @property array $data
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
abstract class Trash extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trash';
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
            [['key'], 'integer'],
            [['data'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
            'key' => 'Key',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ]);
    }

    /**
     * @inheritdoc
     * @return TrashQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrashQuery(static::class);
    }
}
