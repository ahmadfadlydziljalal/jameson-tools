<?php

namespace app\models\active_queries;

use \app\models\MutasiKasPettyCash;

/**
 * This is the ActiveQuery class for [[MutasiKasPettyCash]].
 *
 * @see \app\models\MutasiKasPettyCash
 * @method MutasiKasPettyCash[] all($db = null)
 * @method MutasiKasPettyCash one($db = null)
 */
class MutasiKasPettyCashQuery extends \yii\db\ActiveQuery
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
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->reference_number];
        }
        return $out;
    }
}
