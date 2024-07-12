<?php

namespace app\models\search;

use app\models\Card;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * CardSearch represents the model behind the search form about `app\models\Card`.
 */
class CardSearch extends Card
{


   /**
    * @inheritdoc
    */
   public function rules(): array
   {
      return [
         [['id', 'created_at', 'updated_at', 'mata_uang_id'], 'integer'],
         [['nama', 'kode', 'created_by', 'updated_by', 'cardTypeName'], 'safe'],
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
      $query = Card::find()
         ->select([
            'id' => 'card.id',
            'nama' => 'card.nama',
            'kode' => 'card.kode',
            'alamat' => 'card.alamat',
            'npwp' => 'card.npwp',
            'mata_uang_id' => 'card.mata_uang_id',
            'mataUang' => 'mata_uang.singkatan',
            'cardTypeName' => new Expression("GROUP_CONCAT(card_type.nama)")
         ])
         ->joinWith(['cardBelongsTypes' => function ($cbt) {
            return $cbt->joinWith('cardType', false);
         }], false)
         ->joinWith('mataUang', false)
         ->groupBy('card.id');

      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'sort' => [
            'defaultOrder' => [
               'nama' => SORT_ASC
            ]
         ]
      ]);

      $this->load($params);

      if (!$this->validate()) {
         // if you do not want to return any records when validation fails
         // $query->where('0=1');
         return $dataProvider;
      }

      $query->andFilterWhere(['mata_uang_id' => $this->mata_uang_id]);
      $query->andFilterWhere(['card_type.id' => $this->cardTypeName]);
      $query->andFilterWhere(['like', 'card.nama', $this->nama]);
      $query->andFilterWhere(['like', 'card.kode', $this->kode]);
      $query->andFilterWhere(['like', 'card.npwp', $this->npwp]);

      return $dataProvider;
   }
}