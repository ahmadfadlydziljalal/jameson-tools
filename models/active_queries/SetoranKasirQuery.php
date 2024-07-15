<?php

namespace app\models\active_queries;

use \app\models\SetoranKasir;
use yii\db\Query;

/**
 * This is the ActiveQuery class for [[SetoranKasir]].
 *
 * @see \app\models\SetoranKasir
 * @method SetoranKasir[] all($db = null)
 * @method SetoranKasir one($db = null)
 */
class SetoranKasirQuery extends \yii\db\ActiveQuery
{

    public function notInBuktiPenerimaanBukuBankYet(mixed $q, mixed $id): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];

        // For update, harus bisa dibedakan yang mana udah exist, yang mana yang ga
        if (!is_null($q) and !empty($id) ) {
            // yang masih available
            $data = (new Query())->select(['id' => 'id', 'text' => 'reference_number'])
                ->from('setoran_kasir')
                ->where([
                    'IS', 'bukti_penerimaan_buku_bank_id', NULL
                ])
                ->andWhere(['LIKE', 'setoran_kasir.reference_number', $q])
                ->all();

            // kalau ga ada, cari yang sudah exist
            if(empty($data)){
                $data = (new Query())->select(['id' => 'id', 'text' => 'reference_number'])
                    ->from('setoran_kasir')
                    ->where(['IN', 'setoran_kasir.id', array_map('intval', $id)])
                    ->andWhere(['LIKE', 'setoran_kasir.reference_number', $q])
                    ->all();
            }

            $out['results'] = $data;
            return $out;
        }

        // For CREATE
        if (!is_null($q)) {
            $query = parent::select(['id' => 'setoran_kasir.id', 'text' => 'reference_number'])
                ->where(['LIKE', 'setoran_kasir.reference_number', $q])
                ->andWhere([
                    'IS', 'bukti_penerimaan_buku_bank_id', NULL
                ])
                ->asArray();
            $out['results'] = array_values($query->all());
        }

        return $out;
    }
}
