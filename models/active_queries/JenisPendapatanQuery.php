<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\JenisPendapatan;

/**
 * This is the ActiveQuery class for [[JenisPendapatan]].
 *
 * @see \app\models\JenisPendapatan
 * @method JenisPendapatan[] all($db = null)
 * @method JenisPendapatan one($db = null)
 */
class JenisPendapatanQuery extends \yii\db\ActiveQuery
{

    public function map()
    {
        return ArrayHelper::map(parent::all(), 'id', 'name');
    }
}
