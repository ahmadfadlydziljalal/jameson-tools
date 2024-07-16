<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\BuktiPengeluaranBukuBank;

/**
 * This is the ActiveQuery class for [[BuktiPengeluaranBukuBank]].
 *
 * @see \app\models\BuktiPengeluaranBukuBank
 * @method BuktiPengeluaranBukuBank[] all($db = null)
 * @method BuktiPengeluaranBukuBank one($db = null)
 */
class BuktiPengeluaranBukuBankQuery extends \yii\db\ActiveQuery
{

    public function notYetRegisteredInBukuBank()
    {
        $data = parent::joinWith('bukuBank')->where(['buku_bank.id' => null])
            ->all();
        return ArrayHelper::map($data, 'id', 'reference_number');
    }
}
