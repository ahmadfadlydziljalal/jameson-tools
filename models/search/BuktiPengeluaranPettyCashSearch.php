<?php

namespace app\models\search;

use app\models\BuktiPengeluaranPettyCash;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BuktiPengeluaranPettyCashSearch represents the model behind the search form about `app\models\BuktiPengeluaranPettyCash`.
 */
class BuktiPengeluaranPettyCashSearch extends BuktiPengeluaranPettyCash
{

    public ?string $nomorJobOrder = null;
    public ?string $nomorVoucher = null;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'nomorJobOrder', 'tanggal_transaksi', 'nomorVoucher'], 'safe'],
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
        $query = BuktiPengeluaranPettyCash::find()
            ->joinWith(['jobOrderBill' => function ($jobOrderBill) {
                return $jobOrderBill->joinWith(['jobOrder' => function ($jo1) {
                    $jo1->from(['jo1' => 'job_order']);
                }]);
            }])
            ->joinWith(['jobOrderDetailCashAdvance' => function ($jobOrderDetailCashAdvance) {
                return $jobOrderDetailCashAdvance->joinWith(['jobOrder' => function ($jo1) {
                    $jo1->from(['jo2' => 'job_order']);
                }]);
            }])
            ->joinWith('mutasiKasPettyCash');

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

        if (isset($this->tanggal_transaksi)) {
            $query->andFilterWhere([
                'bukti_pengeluaran_petty_cash.tanggal_transaksi' => Yii::$app->formatter->asDate($this->tanggal_transaksi, 'php:Y-m-d'),
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        
        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);
        $query->orFilterWhere(['like', 'jo1.reference_number', $this->nomorJobOrder]);
        $query->orFilterWhere(['like', 'jo2.reference_number', $this->nomorJobOrder]);
        $query->orFilterWhere(['like', 'mutasi_kas_petty_cash.nomor_voucher', $this->nomorVoucher]);

        return $dataProvider;
    }
}