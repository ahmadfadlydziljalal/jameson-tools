<?php

namespace app\models\search;

use app\components\helpers\ArrayHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MutasiKasPettyCash;

/**
 * MutasiKasPettyCashSearch represents the model behind the search form about `app\models\MutasiKasPettyCash`.
 */
class MutasiKasPettyCashSearch extends MutasiKasPettyCash
{

    public ?string $voucherBukuBank = null;


    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'voucherBukuBank' => 'Voucher BB',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'kode_voucher_id', 'bukti_penerimaan_petty_cash_id', 'bukti_pengeluaran_petty_cash_id'], 'integer'],
            [['nomor_voucher', 'tanggal_mutasi', 'keterangan', 'voucherBukuBank'], 'safe'],
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
        $query = MutasiKasPettyCash::find()
        ->joinWith('bukuBank');

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
            'bukti_penerimaan_petty_cash_id' => $this->bukti_penerimaan_petty_cash_id,
            'bukti_pengeluaran_petty_cash_id' => $this->bukti_pengeluaran_petty_cash_id,
            'tanggal_mutasi' => $this->tanggal_mutasi,
        ]);

        $query->andFilterWhere(['like', 'nomor_voucher', $this->nomor_voucher])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'buku_bank.nomor_voucher', $this->voucherBukuBank])
        ;

        return $dataProvider;
    }
}