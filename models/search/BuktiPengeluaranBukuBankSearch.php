<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BuktiPengeluaranBukuBank;

/**
 * BuktiPengeluaranBukuBankSearch represents the model behind the search form about `app\models\BuktiPengeluaranBukuBank`.
 */
class BuktiPengeluaranBukuBankSearch extends BuktiPengeluaranBukuBank
{

    public ?string $nomorVoucher = null;

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'rekening_saya_id', 'jenis_transfer_id', 'vendor_id', 'vendor_rekening_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'nomor_bukti_transaksi', 'tanggal_transaksi', 'keterangan','nomorVoucher'], 'safe'],
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
        $query = BuktiPengeluaranBukuBank::find()
            ->joinWith('bukuBank')
            ->joinWith('vendor')
            ->joinWith('rekeningSaya')
        ;

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
            'rekening_saya_id' => $this->rekening_saya_id,
            'jenis_transfer_id' => $this->jenis_transfer_id,
            'vendor_id' => $this->vendor_id,
            'vendor_rekening_id' => $this->vendor_rekening_id,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if(isset($this->tanggal_transaksi) AND $this->tanggal_transaksi != ''){
            $query->andFilterWhere([
                'bukti_pengeluaran_buku_bank.tanggal_transaksi' => Yii::$app->formatter->asDate($this->tanggal_transaksi, 'php:Y-m-d'),
            ]);
        }

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number])
            ->andFilterWhere(['like', 'nomor_bukti_transaksi', $this->nomor_bukti_transaksi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'buku_bank.nomor_voucher', $this->nomorVoucher])
        ;

        return $dataProvider;
    }
}