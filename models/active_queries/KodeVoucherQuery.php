<?php

namespace app\models\active_queries;

use app\enums\KodeVoucherEnum;
use \app\models\KodeVoucher;

/**
 * This is the ActiveQuery class for [[KodeVoucher]].
 *
 * @see \app\models\KodeVoucher
 * @method KodeVoucher[] all($db = null)
 * @method KodeVoucher one($db = null)
 */
class KodeVoucherQuery extends \yii\db\ActiveQuery
{

    public function pettyCashIn()
    {
        return parent::where([
            'code' => KodeVoucherEnum::CR->value
        ])->one();
    }

    public function pettyCashOut()
    {
        return parent::where([
            'code' => KodeVoucherEnum::CP->value
        ])->one();
    }

}
