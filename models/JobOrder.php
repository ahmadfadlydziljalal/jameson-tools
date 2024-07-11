<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use \app\models\base\JobOrder as BaseJobOrder;

/**
 * This is the model class for table "job_order".
 */
class JobOrder extends BaseJobOrder
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            # custom behaviors,
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'reference_number', // required
                'value' => '?' . '/' . date('Y') , // format auto number. '?' will be replaced with generated number
                'digit' => 4
            ],
        ]);
    }

}
