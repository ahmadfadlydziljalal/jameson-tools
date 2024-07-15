<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\JenisTransfer;

/**
 * This is the ActiveQuery class for [[JenisTransfer]].
 *
 * @see \app\models\JenisTransfer
 * @method JenisTransfer[] all($db = null)
 * @method JenisTransfer one($db = null)
 */
class JenisTransferQuery extends \yii\db\ActiveQuery
{

    public function map()
    {
        return ArrayHelper::map(parent::all(), 'id', 'name');
    }
}
