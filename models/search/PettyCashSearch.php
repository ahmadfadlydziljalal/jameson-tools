<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PettyCash;

/**
 * PettyCashSearch represents the model behind the search form about `app\models\PettyCash`.
 */
class PettyCashSearch extends PettyCash
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'card_id', 'created_at', 'updated_at'], 'integer'],
            [['saldo_awal'], 'number'],
            [['created_by', 'updated_by'], 'safe'],
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
        $query = PettyCash::find();

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
            'card_id' => $this->card_id,
            'saldo_awal' => $this->saldo_awal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}