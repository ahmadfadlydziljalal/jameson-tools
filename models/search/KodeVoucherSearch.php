<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KodeVoucher;

/**
 * KodeVoucherSearch represents the model behind the search form about `app\models\KodeVoucher`.
 */
class KodeVoucherSearch extends KodeVoucher
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'code'], 'safe'],
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
        $query = KodeVoucher::find();

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
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}