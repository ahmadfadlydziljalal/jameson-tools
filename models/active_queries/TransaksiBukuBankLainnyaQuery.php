<?php

namespace app\models\active_queries;

use \app\models\TransaksiBukuBankLainnya;

/**
 * This is the ActiveQuery class for [[TransaksiBukuBankLainnya]].
 *
 * @see \app\models\TransaksiBukuBankLainnya
 * @method TransaksiBukuBankLainnya[] all($db = null)
 * @method TransaksiBukuBankLainnya one($db = null)
 */
class TransaksiBukuBankLainnyaQuery extends \yii\db\ActiveQuery
{

    public function otherTransactionLiveSearchById(mixed $q, mixed $id): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = parent::select(['id' => 'id', 'text' => 'reference_number'])
                ->where(['LIKE', 'reference_number', $q])
                ->orderBy('reference_number')
                ->asArray();
            $out['results'] = array_values($query->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->reference_number];
        }
        return $out;
    }

}
