<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SetoranKasir;

/**
 * SetoranKasirSearch represents the model behind the search form about `app\models\SetoranKasir`.
 */
class SetoranKasirSearch extends SetoranKasir
{
    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'cashier_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tanggal_setoran', 'staff_name', 'reference_number'], 'safe'],
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
        $query = SetoranKasir::find();

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
            'cashier_id' => $this->cashier_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if(isset($this->tanggal_setoran) and !empty($this->tanggal_setoran)){
            $query->andFilterWhere([
                'tanggal_setoran' => \Yii::$app->formatter->asDate($this->tanggal_setoran, 'php:Y-m-d'),
            ]);
        }

        $query->andFilterWhere(['like', 'staff_name', $this->staff_name]);
        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);

        return $dataProvider;
    }
}