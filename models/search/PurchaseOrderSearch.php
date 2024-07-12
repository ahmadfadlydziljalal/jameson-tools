<?php

namespace app\models\search;

use app\models\PurchaseOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PurchaseOrderSearch represents the model behind the search form about `app\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{

    public ?string $nomorMaterialRequest = null;
    public ?string $nomorTandaTerimaBarang = null;
    public ?string $vendorPurchaseOrder = null;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['nomor', 'tanggal', 'remarks', 'approved_by_id', 'acknowledge_by_id', 'created_by', 'updated_by',
                'nomorMaterialRequest',
                'nomorTandaTerimaBarang',
                'vendorPurchaseOrder'
            ], 'safe'],
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
        $query = PurchaseOrder::find()
            ->joinWith(['materialRequisitionDetail' => function ($mrd) {
                $mrd->joinWith('materialRequisition');
            }])
//            ->joinWith('tandaTerimaBarangs')
//            ->joinWith('vendor')
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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,

            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'approved_by_id', $this->approved_by_id])
            ->andFilterWhere(['like', 'acknowledge_by_id', $this->acknowledge_by_id])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'tanda_terima_barang.nomor', $this->nomorTandaTerimaBarang])
            ->andFilterWhere(['like', 'material_requisition.nomor', $this->nomorMaterialRequest])
            ->andFilterWhere(['like', 'card.id', $this->vendorPurchaseOrder]);

        return $dataProvider;
    }
}