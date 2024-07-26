<?php

namespace app\models\search;

use app\models\JobOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JobOrderSearch represents the model behind the search form about `app\models\JobOrder`.
 */
class JobOrderSearch extends JobOrder
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'main_vendor_id', 'main_customer_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'keterangan'], 'safe'],
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
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = JobOrder::find()
            ->joinWith('mainVendor')
            ->joinWith('mainCustomer');

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
            'main_vendor_id' => $this->main_vendor_id,
            'main_customer_id' => $this->main_customer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}