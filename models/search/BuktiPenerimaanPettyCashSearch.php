<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BuktiPenerimaanPettyCash;

/**
 * BuktiPenerimaanPettyCashSearch represents the model behind the search form about `app\models\BuktiPenerimaanPettyCash`.
 */
class BuktiPenerimaanPettyCashSearch extends BuktiPenerimaanPettyCash
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [[
                'id',
                'bukti_pengeluaran_petty_cash_cash_advance_id',
                'buku_bank_id',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by'
            ], 'integer'],
            [['reference_number', 'nomorVoucherMutasiKasPettyCash'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() : array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = BuktiPenerimaanPettyCash::find()->joinWith('mutasiKasPettyCash');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'bukti_pengeluaran_petty_cash_cash_advance_id' => $this->bukti_pengeluaran_petty_cash_cash_advance_id,
            'buku_bank_id' => $this->buku_bank_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query
            ->andFilterWhere(['like', 'reference_number', $this->reference_number])
            ->andFilterWhere(['like', 'mutasi_kas_petty_cash.nomor_voucher', $this->nomorVoucherMutasiKasPettyCash]);

        return $dataProvider;
    }
}