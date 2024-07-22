<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BuktiPengeluaranPettyCash;

/**
 * BuktiPengeluaranPettyCashSearch represents the model behind the search form about `app\models\BuktiPengeluaranPettyCash`.
 */
class BuktiPengeluaranPettyCashSearch extends BuktiPengeluaranPettyCash
{

    public ?string $nomorJobOrder = null;

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['reference_number', 'nomorJobOrder'], 'safe'],
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
        $query = BuktiPengeluaranPettyCash::find()
            ->joinWith(['jobOrderBill' => function ($jobOrderBill) {
                return $jobOrderBill->joinWith(['jobOrder' => function($jo1){
                    $jo1->from(['jo1' => 'job_order']);
                }]);
            }])
            ->joinWith(['jobOrderDetailCashAdvance' => function ($jobOrderDetailCashAdvance) {
                return $jobOrderDetailCashAdvance->joinWith(['jobOrder' => function($jo1){
                    $jo1->from(['jo2' => 'job_order']);
                }]);
            }])
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);

        $query->orFilterWhere(['like', 'jo1.reference_number', $this->nomorJobOrder]);
        $query->orFilterWhere(['like', 'jo2.reference_number', $this->nomorJobOrder]);

        return $dataProvider;
    }
}