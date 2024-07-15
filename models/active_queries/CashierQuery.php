<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\Cashier;

/**
 * This is the ActiveQuery class for [[Cashier]].
 *
 * @see \app\models\Cashier
 * @method Cashier[] all($db = null)
 * @method Cashier one($db = null)
 */
class CashierQuery extends \yii\db\ActiveQuery
{

    public function map(): array
    {
        return ArrayHelper::map(parent::all(), 'id', 'name');
    }
}
