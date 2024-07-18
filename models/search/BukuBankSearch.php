<?php

namespace app\models\search;

use app\models\BukuBank;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BukuBankSearch represents the model behind the search form about `app\models\BukuBank`.
 */
class BukuBankSearch extends BukuBank
{

    public ?string $mutasiKas = null;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'kode_voucher_id', 'bukti_penerimaan_buku_bank_id', 'bukti_pengeluaran_buku_bank_id'], 'integer'],
            [['nomor_voucher', 'tanggal_transaksi', 'keterangan', 'mutasiKas'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = BukuBank::find()
            ->joinWith([
                'buktiPenerimaanBukuBank',
                'mutasiKasPettyCash',
                'buktiPenerimaanPettyCash',
                'buktiPengeluaranBukuBank',
                'transaksiBukuBankLainnya',
            ]);

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
            'kode_voucher_id' => $this->kode_voucher_id,
            'bukti_penerimaan_buku_bank_id' => $this->bukti_penerimaan_buku_bank_id,
            'bukti_pengeluaran_buku_bank_id' => $this->bukti_pengeluaran_buku_bank_id,
            'mutasi_kas_petty_cash.id' => $this->mutasiKas,
        ]);

        if (isset($this->tanggal_transaksi) and !empty($this->tanggal_transaksi)) {
            $query->andFilterWhere([
                'tanggal_transaksi' => \Yii::$app->formatter->asDate($this->tanggal_transaksi, 'php:Y-m-d'),
            ]);
        }

        $query->andFilterWhere(['like', 'buku_bank.nomor_voucher', $this->nomor_voucher])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);
        return $dataProvider;
    }
}
