<?php

namespace app\models\active_queries;

use app\models\Invoice;
use yii\db\Query;

/**
 * This is the ActiveQuery class for [[Invoice]].
 *
 * @see \app\models\Invoice
 * @method Invoice[] all($db = null)
 * @method Invoice one($db = null)
 */
class InvoiceQuery extends \yii\db\ActiveQuery
{

    public function notInBuktiPenerimaanBukuBankYet($q, $id): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];

        // For update, harus bisa dibedakan yang mana udah exist, yang mana yang ga
        if (!is_null($q) and !empty($id) ) {

            // yang masih available
            $data = (new Query())->select(['id' => 'invoice.id', 'text' => 'reference_number'])
                ->from('invoice')
                ->where([
                    'IS', 'bukti_penerimaan_buku_bank_id', NULL
                ])
                ->andWhere(['LIKE', 'invoice.reference_number', $q])
                ->all();

            // kalau ga ada, cari yang sudah exist
            if(empty($data)){
                $data = (new Query())->select(['id' => 'invoice.id', 'text' => 'reference_number'])
                    ->from('invoice')
                    ->where(['IN', 'invoice.id', array_map('intval', $id)])
                    ->andWhere(['LIKE', 'invoice.reference_number', $q])
                    ->all();
            }

            $out['results'] = $data;
            return $out;
        }

        // For create
        if (!is_null($q)) {
            $query = parent::select(['id' => 'invoice.id', 'text' => 'reference_number'])
                ->where(['LIKE', 'invoice.reference_number', $q])
                ->andWhere([
                    'IS', 'bukti_penerimaan_buku_bank_id', NULL
                ])
                ->asArray();
            $out['results'] = array_values($query->all());
        }
        return $out;
    }
}
