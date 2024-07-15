<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\PaymentMethod;

/**
 * This is the ActiveQuery class for [[PaymentMethod]].
 *
 * @see \app\models\PaymentMethod
 * @method PaymentMethod[] all($db = null)
 * @method PaymentMethod one($db = null)
 */
class PaymentMethodQuery extends \yii\db\ActiveQuery
{

    public function map(): array
    {
        return ArrayHelper::map(parent::all(), 'id', 'name');
    }
}
