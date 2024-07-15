<?php

namespace app\models;

use \app\models\base\SetoranKasir as BaseSetoranKasir;

/**
 * This is the model class for table "setoran_kasir".
 */
class SetoranKasir extends BaseSetoranKasir
{

    public mixed $total  = null;

    public function afterFind()
    {
        parent::afterFind();
        $this->total = array_sum(array_column($this->setoranKasirDetails, 'total'));
    }

    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'reference_number',
                    'value' => '?' . '-' . date('Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 3
                ],
            ]
        );

    }
}
