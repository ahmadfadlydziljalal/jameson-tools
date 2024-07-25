<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\form\BukuBankReportPerSpecificDate;
use app\models\Rekening;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * This is the ActiveQuery class for [[\app\models\Rekening]].
 *
 * @see \app\models\Rekening
 */
class RekeningQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Rekening|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function mapOnlyTokoSaya($label = null): array
    {
        $card = Card::find()->map(Card::GET_ONLY_TOKO_SAYA);
        $data = parent::where(['IN', 'card_id', array_keys($card)])->orderBy('nama_bank')->all();
        return ArrayHelper::map($data, 'id', fn($model) => is_null($label) ? $model->nama_bank . ' ' . $model->nomor_rekening : $model->$label);
    }

    public function map()
    {
        return ArrayHelper::map(parent::all(), 'id', 'atas_nama');
    }

    /**
     * @inheritdoc
     * @return Rekening[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function onlyTokoSaya()
    {
        $card = Card::find()->map(Card::GET_ONLY_TOKO_SAYA);
        return parent::where(['IN', 'card_id', array_keys($card)])->orderBy('nama_bank')->all();
    }

    /**
     * @return BukuBankReportPerSpecificDate[]
     */
    public function actualBalanceOnlyTokoSaya(string $date): array
    {
        $cards = Card::find()->onlyTokoSaya();

        $accounts  = [];
        foreach ($cards as $card) {
            foreach ($card->rekenings as $rekening) {
                $model = new BukuBankReportPerSpecificDate([
                    'rekening' =>  $rekening->id,
                    'date' => $date
                ]);
                $model->find();
                $accounts[] = $model;
            }
        }
        return $accounts;
    }


}