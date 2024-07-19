<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BuktiPenerimaanBukuBank;

/**
 * BuktiPenerimaanBukuBankSearch represents the model behind the search form about `app\models\BuktiPenerimaanBukuBank`.
 */
class BuktiPenerimaanBukuBankSearch extends BuktiPenerimaanBukuBank
{
    public ?string $nomorVoucher = null;

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'customer_id', 'rekening_saya_id', 'jenis_transfer_id', 'nomor_transaksi_transfer', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'tanggal_transaksi_transfer', 'tanggal_jatuh_tempo', 'keterangan', 'nomorVoucher'], 'safe'],
            //[['jumlah_setor'], 'number'],
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
        $query = BuktiPenerimaanBukuBank::find()
            ->joinWith('customer')
            ->joinWith('rekeningSaya')
            ->joinWith('bukuBank')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'attributes' => [
                    'id',
                    'reference_number'
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
            'customer_id' => $this->customer_id,
            'rekening_saya_id' => $this->rekening_saya_id,
            'jenis_transfer_id' => $this->jenis_transfer_id,
            'nomor_transaksi_transfer' => $this->nomor_transaksi_transfer,
            'tanggal_transaksi_transfer' => $this->tanggal_transaksi_transfer,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            //'jumlah_setor' => $this->jumlah_setor,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'buku_bank.nomor_voucher', $this->nomorVoucher])
        ;

        return $dataProvider;
    }
}