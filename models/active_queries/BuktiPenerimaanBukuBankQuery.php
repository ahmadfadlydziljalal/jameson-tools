<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BuktiPenerimaanBukuBank;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BuktiPenerimaanBukuBank]].
 *
 * @see BuktiPenerimaanBukuBank
 * @method BuktiPenerimaanBukuBank[] all($db = null)
 * @method BuktiPenerimaanBukuBank one($db = null)
 */
class BuktiPenerimaanBukuBankQuery extends ActiveQuery
{

    public function notYetRegisteredInBukuBank(): array
    {
        $data = parent::joinWith('bukuBank')
            ->where([
                'IS', 'buku_bank.id', NULL
            ])
            ->all();
        return ArrayHelper::map($data, 'id', function($model){
            /** @var BuktiPenerimaanBukuBank $model */
            return $model->reference_number . ' -  ' . $model->sumberDana . ' - ' . Yii::$app->formatter->asDecimal($model->jumlah_setor, 2);
        });
    }

    /**
     * @param mixed $q
     * @param mixed $id
     * @return array[]
     */
    public function liveSearchById(mixed $q, mixed $id): array
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
