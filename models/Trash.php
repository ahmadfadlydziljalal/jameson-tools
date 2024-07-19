<?php

namespace app\models;

use app\models\base\Trash as BaseTrash;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "trash".
 */
class Trash extends BaseTrash
{
    /**
     * @throws Throwable
     */
    public function restore(): bool
    {
        $isRestored = false;
        switch ($this->name):
            case BukuBank::tableName():
                $isRestored = $this->restoreBukuBank();
                break;
            default:
                break;
        endswitch;
        return $isRestored;
    }

    /**
     * @throws Throwable
     */
    private function restoreBukuBank(): bool
    {
        $this->data = Json::decode($this->data);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $flag = true;
            foreach ($this->data as $tableName => $attributes) {

                if(!$flag) break;

                /** @var ActiveRecord $tableName */
                $model = new $tableName;
                $model->scenario = $model::SCENARIO_RESTORE;
                $model->setAttribute('id', $attributes['id']); // set primary key
                $model->attributes = $attributes;
                $flag = $model->save();
            }

            if ($flag) {
                if($this->delete()){
                    $transaction->commit();
                    return true;
                }else{
                    $transaction->rollBack();
                }
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
