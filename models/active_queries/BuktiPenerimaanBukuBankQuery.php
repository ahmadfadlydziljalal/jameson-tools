<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use \app\models\BuktiPenerimaanBukuBank;

/**
 * This is the ActiveQuery class for [[BuktiPenerimaanBukuBank]].
 *
 * @see \app\models\BuktiPenerimaanBukuBank
 * @method BuktiPenerimaanBukuBank[] all($db = null)
 * @method BuktiPenerimaanBukuBank one($db = null)
 */
class BuktiPenerimaanBukuBankQuery extends \yii\db\ActiveQuery
{

    public function notYetRegisteredInBukuBank(): array
    {
        $data = parent::joinWith('bukuBank')
            ->where([
                'IS', 'buku_bank.id', NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', 'reference_number');
    }
}
