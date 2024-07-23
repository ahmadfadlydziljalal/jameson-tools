<?php

namespace app\models;

use app\models\base\Rekening as BaseRekening;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rekening".
 * @property float | integer $saldo_awal
 */
class Rekening extends BaseRekening
{


    public ?string $nomorNomorRekeningBank = null;
    public ?string $cardNama = null;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}