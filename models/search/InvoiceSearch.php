<?php

namespace app\models\search;

use app\models\Invoice;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InvoiceSearch represents the model behind the search form about `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'customer_id', 'nomor_rekening_tagihan_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'tanggal_invoice'], 'safe'],
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
        $query = Invoice::find()
            ->joinWith('nomorRekeningTagihan')
            ->joinWith('customer')
            ->joinWith('buktiPenerimaanBukuBank');

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'invoice.customer_id' => $this->customer_id,
            'nomor_rekening_tagihan_id' => $this->nomor_rekening_tagihan_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if (isset($this->tanggal_invoice) and !empty($this->tanggal_invoice)) {
            $query->andFilterWhere([
                'tanggal_invoice' => Yii::$app->formatter->asDate($this->tanggal_invoice, 'php:Y-m-d'),
            ]);
        }

        $query->andFilterWhere(['like', 'invoice.reference_number', $this->reference_number]);

        return $dataProvider;
    }
}