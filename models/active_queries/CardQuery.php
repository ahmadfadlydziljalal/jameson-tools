<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Card;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * This is the ActiveQuery class for [[\app\models\Card]].
 *
 * @see Card
 */
class CardQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Card|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return Card[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param string $mode
     * @return array
     * @throws NotFoundHttpException
     */
    public function map(string $mode = Card::GET_ALL): array
    {

        $q = parent::select('card.id as id, TRIM(card.nama) as nama')
            ->joinWith(['cardBelongsTypes' => function ($cbt) {
                $cbt->joinWith('cardType', false);
            }], false);

        switch ($mode):

            case Card::GET_ALL:
                $q->groupBy('card.id');
                break;

            case Card::GET_ONLY_VENDOR:
                $q->where([
                    'card_type.kode' => 'vendor'
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_TOKO_SAYA:
                $q->where([
                    'card_type.kode' => 'toko-saya'
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_PEJABAT_KANTOR:
                $q->where([
                    'card_type.kode' => 'pejabat-kantor'
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_MEKANIK:
                $q->where([
                    'card_type.kode' => 'mekanik'
                ])->groupBy('card.id');
                break;

            case Card::GET_APART_FROM_TOKO_SAYA:
                $q->where([
                    '!=', 'card_type.kode', 'toko-saya'
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_WAREHOUSE:
                $q->where([
                    '=', 'card_type.kode', Card::GET_ONLY_WAREHOUSE
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_CUSTOMER:
                $q->where([
                    'card_type.kode' => 'customer'
                ])->groupBy('card.id');
                break;

            default:
                throw new NotFoundHttpException('Mode Anda tidak didukung');
        endswitch;
        return ArrayHelper::map($q->orderBy('nama')->all(), 'id', 'nama');
    }
    
    /**
     * @param mixed $id
     * @return Card[] | array
     */
    public function mataUang(mixed $id): array
    {
        return parent::select([
            'id' => 'mata_uang.id',
            'name' => 'mata_uang.singkatan'
        ])
            ->where([
                'card.id' => $id
            ])
            ->joinWith('mataUang')
            ->asArray()
            ->all();
    }

    public function rekening(mixed $id)
    {
        return parent::select([
            'id' => 'rekening.id',
            'name' => 'rekening.atas_nama'
        ])
            ->where([
                'card.id' => $id
            ])
            ->joinWith('rekenings', false)
            ->asArray()
            ->all();
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
            $query = parent::select(['id' => 'id', 'text' => 'nama'])
                ->where(['LIKE', 'nama', $q])
                ->orderBy('nama')
                ->asArray();
            $out['results'] = array_values($query->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->nama];
        }
        return $out;
    }

    public function onlyTokoSaya()
    {
        $q = parent::select('card.id as id, TRIM(card.nama) as nama')
            ->joinWith(['cardBelongsTypes' => function ($cbt) {
                $cbt->joinWith('cardType', false);
            }], false);

        $q->where([
            'card_type.kode' => 'toko-saya'
        ])->groupBy('card.id');
        return $q->all();
    }


}