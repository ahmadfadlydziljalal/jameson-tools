<?php

namespace app\models\active_queries;

use \app\models\BukuBank;

/**
 * This is the ActiveQuery class for [[BukuBank]].
 *
 * @see \app\models\BukuBank
 * @method BukuBank[] all($db = null)
 * @method BukuBank one($db = null)
 */
class BukuBankQuery extends \yii\db\ActiveQuery
{

    public function liveSearchById(mixed $q, mixed $id)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = parent::select(['id' => 'id', 'text' => 'nomor_voucher'])
                ->where(['LIKE', 'nomor_voucher', $q])
                ->orderBy('nomor_voucher')
                ->asArray();
            $out['results'] = array_values($query->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->nomor_voucher];
        }
        return $out;
    }
}
