<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Barang;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\Barang]].
 *
 * @see Barang
 */
class BarangQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return Barang|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   public function availableSatuan($barangId, $vendorId): array
   {
      return parent::select('satuan.id as id, satuan.nama as name')
         ->joinWith(['barangSatuans' => function ($bs) {
            return $bs->joinWith('satuan', false);
         }], false)
         ->where('barang.id =:barangId', [':barangId' => $barangId])
         ->andWhere('barang_satuan.vendor_id =:vendorId', [':vendorId' => $vendorId])
         ->asArray()
         ->all();
   }

   /**
    * @inheritdoc
    * @return Barang[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }

   public function map(int $tipePembelian = 0): array
   {
      $data = parent::orderBy('nama');
      if ($tipePembelian) {
         $data->where([
            'tipe_pembelian_id' => $tipePembelian
         ]);
      }

      return ArrayHelper::map($data->all(), 'id', function ($el) {
         return
            (!empty($el->part_number) ? $el->part_number : 'Unknown part number') . ' - ' .
            (!empty($el->merk_part_number) ? $el->merk_part_number : 'Unknown merk') . ' - ' .
            $el->nama;
      });
   }

   public function availableVendor(int $barangId): array
   {
      return parent::select('card.id as id, card.nama as name')
         ->joinWith(['barangSatuans' => function ($bs) {
            return $bs->joinWith('vendor', false);
         }], false)
         ->where('barang.id =:barangId', [':barangId' => $barangId])
         ->asArray()
         ->all();
   }

   /**
    * Mengembalikan list barang sesuai dengan tipe pembelian. Nama Barang bersifat opsional
    * @param $tipePembelianId
    * @param string $namaBarang
    * @return array
    */
   public function byTipePembelian($tipePembelianId, string $namaBarang = ''): array
   {

      $expression = new Expression("
                                    CONCAT(
                                        COALESCE(part_number, 'No Part Number') , ' - ' ,
                                        COALESCE(merk_part_number, 'No Merk') , ' - ' ,
                                        COALESCE(nama, '') , ' - ' ,
                                        COALESCE(ift_number, '')
                                    )
                                    ");
      if (!empty($namaBarang)) {
         $select = [
            'id' => 'id',
            'text' => $expression
         ];
      } else {
         $select = [
            'id' => 'id',
            'name' => $expression
         ];
      }

      $parent = parent::select($select)
         ->where([
            'tipe_pembelian_id' => $tipePembelianId
         ]);

      if (!empty($namaBarang)) {
         $parent->andWhere(['LIKE', 'nama', $namaBarang]);
      }

      return $parent
         ->orderBy('barang.nama')
         ->asArray()
         ->all();
   }

    public function liveSearchById(mixed $q, mixed $id): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = parent::select(['id' => 'id', 'text' => 'nama'])
                ->where(['LIKE', 'nama', $q])
                ->orderBy('nama')
                ->asArray();
            $out['results'] = array_values($query->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => parent::where(['id' => $id])->one()->nama];
        }
        return $out;
    }
}