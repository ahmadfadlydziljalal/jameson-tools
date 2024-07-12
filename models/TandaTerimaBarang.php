<?php

namespace app\models;

use app\enums\SVGIconEnum;
use app\enums\TandaTerimaStatusEnum;
use app\models\base\TandaTerimaBarang as BaseTandaTerimaBarang;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "tanda_terima_barang".
 * @property MaterialRequisitionDetailPenawaran[] $materialRequisitionDetailPenawarans
 * @property PurchaseOrder[] $purchaseOrders
 * @property PurchaseOrder $purchaseOrder
 * @property HistoryLokasiBarangs $historyLokasiBarangs[]
 */
class TandaTerimaBarang extends BaseTandaTerimaBarang implements MasterDetailsInterface
{

   use NomorSuratTrait;

   const STATUS_TEMPORARY = 'status-temporary';
   const STATUS_FINAL = 'status-final';

   public ?string $text = '';

   /**
    * @param array $modelsDetail
    * @return array
    */
   #[ArrayShape(['code' => "int", 'message' => "string"])]
   public function createWithDetails(array $modelsDetail): array
   {

      $transaction = self::getDb()->beginTransaction();
      try {

         if ($flag = $this->save(false)) {
            foreach ($modelsDetail as $detail) :

               if ($flag === false) {
                  break;
               }

               $detail->tanda_terima_barang_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }

            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            $status = [
               'code' => 1,
               'message' => 'Commit'
            ];
         } else {
            $transaction->rollBack();
            $status = [
               'code' => 0,
               'message' => 'Roll Back'
            ];
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         $status = [
            'code' => 0,
            'message' => 'Roll Back ' . $e->getMessage(),
         ];
      }

      return $status;
   }

   #[ArrayShape(['code' => "int", 'message' => "string"])]
   public function updateWithDetails($modelsDetail, $deletedDetailsID): array
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         if ($flag = $this->save(false)) {


            if (!empty($deletedDetailsID)) {
               MaterialRequisitionDetailPenawaran::deleteAll(['id' => $deletedDetailsID]);
            }

            foreach ($modelsDetail as $i => $detail) :

               if ($flag === false) {
                  break;
               }

               $detail->tanda_terima_barang_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }

            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            $status = [
               'code' => 1,
               'message' => 'Commit'
            ];
         } else {
            $transaction->rollBack();
            $status = [
               'code' => 0,
               'message' => 'Roll Back'
            ];
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         $status = [
            'code' => 0,
            'message' => 'Roll Back ' . $e->getMessage(),
         ];
      }

      return $status;
   }

   #[ArrayShape(['code' => "int", 'message' => "string"])]
   public function deleteWithTandaTerimaBarangDetails(): array
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         $flag = true;
         foreach ($this->tandaTerimaBarangDetails as $tandaTerimaBarangDetail) :
            if (!($flag = $tandaTerimaBarangDetail->delete())) {
               break;
            }
         endforeach;

         if ($flag) $flag = $this->delete();

         if ($flag) {
            $transaction->commit();
            $status = ['code' => 1, 'message' => 'Berhasil di hapus dan commit'];
         } else {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back'];
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back ' . $e->getMessage(),];
      } catch (Throwable $e) {
         $transaction->rollBack();
         $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back ' . $e->getMessage(),];
      }
      return $status;
   }

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/TRM-BRG/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
         ]
      );
   }

   /**
    * @return string
    */
   public function getStatusPesananYangSudahDiterimaInHtmlFormat(): string
   {
      return $this->getStatusPesananYangSudahDiterima()
         ? Html::tag('span', SVGIconEnum::CHECK->value . ' ' . TandaTerimaStatusEnum::COMPLETED->value, [
            'class' => 'badge bg-primary',
            'title' => $this->nomor
         ])
         : Html::tag('span', SVGIconEnum::X->value . ' ' . TandaTerimaStatusEnum::NOT_COMPLETED->value, [
            'class' => 'badge bg-danger'
         ]);
   }

   public function getStatusPesananYangSudahDiterima(): bool
   {
      $statusTandaTerimaDetail = [];
      foreach ($this->tandaTerimaBarangDetails as $tandaTerimaBarangDetail) {
         $statusTandaTerimaDetail[] = $tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->getStatusPenerimaan();
      }

      return !in_array(false, $statusTandaTerimaDetail);

   }

   /**
    * @return ActiveQuery
    */
   public function getMaterialRequisitionDetailPenawarans(): ActiveQuery
   {
      return $this->hasMany(MaterialRequisitionDetailPenawaran::class, ['id' => 'material_requisition_detail_penawaran_id'])
         ->via('tandaTerimaBarangDetails');
   }

   /**
    * @return ActiveQuery
    */
   public function getPurchaseOrder(): ActiveQuery
   {
      return $this->hasOne(PurchaseOrder::class, ['id' => 'purchase_order_id'])
         ->via('materialRequisitionDetailPenawarans');
   }

   /**
    * @return ActiveQuery
    */
   public function getHistoryLokasiBarangs(): ActiveQuery
   {
      return $this->hasMany(HistoryLokasiBarang::class, ['tanda_terima_barang_detail_id' => 'id'])
         ->via('tandaTerimaBarangDetails');
   }


}