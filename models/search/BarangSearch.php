<?php

namespace app\models\search;

use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\BarangSatuan;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * BarangSearch represents the model behind the search form about `app\models\Barang`.
 */
class BarangSearch extends Barang
{
   /**
    * @inheritdoc
    */
   public function rules(): array
   {
      return [
         [['id', 'originalitas_id', 'tipe_pembelian_id'], 'integer'],
         [['nama', 'part_number', 'merk_part_number'], 'safe'],
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
      $query = Barang::find();

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
         // uncomment the following line if you do not want to return any records when validation fails
         // $query->where('0=1');
         return $dataProvider;
      }

      $query->andFilterWhere([
         'id' => $this->id,
         'tipe_pembelian_id' => $this->tipe_pembelian_id,
      ]);

      $query
         ->andFilterWhere(['like', 'nama', $this->nama])
      ;

      return $dataProvider;
   }
}