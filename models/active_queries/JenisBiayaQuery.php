<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\JenisBiaya;

/**
 * This is the ActiveQuery class for [[JenisBiaya]].
 *
 * @see \app\models\JenisBiaya
 * @method JenisBiaya[] all($db = null)
 * @method JenisBiaya one($db = null)
 */
class JenisBiayaQuery extends \yii\db\ActiveQuery
{

    public function mapCategory(mixed $category): array
    {
        if (is_array($category)) {
            return ArrayHelper::map(parent::where([
                'IN', 'category', $category
            ])->all(), 'id', 'name');
        }

        return ArrayHelper::map(parent::where([
            'category' => $category
        ])->all(), 'id', 'name');
    }

    public function map(): array
    {
        return ArrayHelper::map(parent::all(), 'id', 'name');
    }

}
