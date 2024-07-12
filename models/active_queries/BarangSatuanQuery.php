<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BarangSatuan;
use app\models\Satuan;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\BarangSatuan]].
 *
 * @see \app\models\BarangSatuan
 */
class BarangSatuanQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BarangSatuan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function mapSatuan(?string $barangId): array
    {
        if (!$barangId) {
            return Satuan::find()->map();
        }
        $data = self::availableSatuan($barangId);
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function availableSatuan(mixed $barangId): array
    {
        return parent::select('barang_satuan.satuan_id as id,satuan.nama as name')
            ->joinWith('satuan', false)
            ->where([
                'barang_id' => $barangId
            ])
            ->orderBy('satuan.nama')
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     * @return BarangSatuan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function mapVendor(int $barangId, $satuanId): array
    {
        $data = self::availableVendor($barangId, $satuanId);
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function availableVendor($barangId, $satuanId): array
    {
        $sql = new Expression("
           
                IF(
                    barang_satuan.harga_beli = NULL,
                    CONCAT(card.nama , ' Harga Beli not available'),
                    CONCAT(
                        card.nama, ' => ', CAST(FORMAT(barang_satuan.harga_beli , 2) AS char)        
                    )
                )
              
        ");
        return parent::select([
                'id' => 'barang_satuan.vendor_id',
                'name' => $sql
            ]
        )
            ->joinWith('vendor', false)
            ->where([
                'barang_id' => $barangId,
                'satuan_id' => $satuanId
            ])
            ->orderBy('card.nama')
            ->asArray()
            ->all();
    }


}