<?php

namespace app\models;

use app\models\base\Quotation as BaseQuotation;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation".
 * @property $delivery_fee float|int
 * @property $materai_fee float|int
 * @property $quotationBarangsSubtotal float | int
 * @property $quotationBarangsBeforeDiscountSubtotal float | int
 * @property $quotationBarangsDasarPengenaanPajak float|int
 * @property $quotationBarangsTotalVatNominal float|int
 * @property $quotationBarangsTotal float|int
 * @property $quotationServicesBeforeDiscountDasarPengenaanPajak float|int
 * @property $quotationServicesDasarPengenaanPajak float|int
 * @property $quotationServicesTotalVatNominal float|int
 * @property $quotationServicesTotal float|int
 * @property $quotationGrandTotal float|int
 * @property $quotationVatTotal float|int
 * @property $quotationFeeTotal float|int
 * @property $quotationBarangsDiscount float|int
 * @property $quotationServicesDiscount float|int
 * @property $quotationDiscountTotal float|int
 * @property $vatPercentageLabel int
 * @property $quotationDeliveryReceiptDetails QuotationDeliveryReceiptDetail[]
 * @property $listDeliveryReceiptDetails QuotationDeliveryReceiptDetail[]
 */
class Quotation extends BaseQuotation
{

   use NomorSuratTrait;
   use QuotationBarangTrait;
   use QuotationServiceTrait;
   use QuotationDeliveryReceiptTrait;

   const SCENARIO_CREATE_BARANG_QUOTATION = 'create-barang-quotation';
   const SCENARIO_UPDATE_BARANG_QUOTATION = 'update-barang-quotation';

   const SCENARIO_CREATE_SERVICE_QUOTATION = 'create-service-quotation';
   const SCENARIO_UPDATE_SERVICE_QUOTATION = 'update-service-quotation';

   const SCENARIO_CREATE_TERM_AND_CONDITION = 'create-term-and-condition';
   const SCENARIO_UPDATE_TERM_AND_CONDITION = 'update-term-and-condition';

   const SCENARIO_CREATE_FORM_JOB = 'create-form-job';
   const SCENARIO_UPDATE_FORM_JOB = 'update-form-job';

   /**
    * @var QuotationBarang[]|null
    */
   public ?array $modelsQuotationBarang = null;

   /**
    * @var array | null
    * */
   public ?array $deletedQuotationBarangsId = null;

   /**
    * @var QuotationService[] | null
    * */
   public ?array $modelsQuotationService = null;

   /**
    * @var array| null
    */
   public ?array $deletedQuotationServicesId = null;

   /**
    * @var QuotationTermAndCondition[] | null
    * */
   public ?array $modelsQuotationTermAndCondition = null;

   /**
    * @var array| null
    */
   public ?array $deletedQuotationTermAndCondition = null;


   /**
    * @var QuotationFormJob[] | null
    * */
   public ?array $modelFormJob = null;


   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/QUOT/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4,
               'group' => '/IFTJKT/QUOT/' . date('Y')
            ],
         ]
      );
   }


   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            [['modelsQuotationBarang'], 'required', 'on' => self::SCENARIO_CREATE_BARANG_QUOTATION],
            [['delivery_fee', 'catatan_quotation_barang'], 'safe', 'on' => self::SCENARIO_CREATE_BARANG_QUOTATION],

            [['modelsQuotationBarang'], 'required', 'on' => self::SCENARIO_UPDATE_BARANG_QUOTATION],
            [['delivery_fee', 'catatan_quotation_barang', 'deletedQuotationBarangsId'], 'safe', 'on' => self::SCENARIO_UPDATE_BARANG_QUOTATION],

            [['modelsQuotationService'], 'required', 'on' => self::SCENARIO_CREATE_SERVICE_QUOTATION],
            [['catatan_quotation_service'], 'safe', 'on' => self::SCENARIO_CREATE_SERVICE_QUOTATION],

            [['modelsQuotationService'], 'required', 'on' => self::SCENARIO_UPDATE_SERVICE_QUOTATION],
            [['catatan_quotation_service', 'deletedQuotationServicesId'], 'safe', 'on' => self::SCENARIO_UPDATE_SERVICE_QUOTATION],

            [['modelsQuotationTermAndCondition'], 'required', 'on' => self::SCENARIO_CREATE_TERM_AND_CONDITION],
            [['modelsQuotationTermAndCondition'], 'required', 'on' => self::SCENARIO_UPDATE_TERM_AND_CONDITION],
            [['deletedQuotationTermAndCondition'], 'safe', 'on' => self::SCENARIO_UPDATE_TERM_AND_CONDITION],

            [['modelFormJob'], 'required', 'on' => self::SCENARIO_CREATE_FORM_JOB]
         ]
      );
   }

   /**
    * @return array
    */
   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_CREATE_BARANG_QUOTATION] = [
         'modelsQuotationBarang',
         'delivery_fee',
         'catatan_quotation_barang',
      ];
      $scenarios[self::SCENARIO_UPDATE_BARANG_QUOTATION] = [
         'modelsQuotationBarang',
         'deletedQuotationBarangsId',
         'delivery_fee',
         'catatan_quotation_barang',
      ];
      $scenarios[self::SCENARIO_CREATE_SERVICE_QUOTATION] = [
         'modelsQuotationService',
         'catatan_quotation_service'
      ];
      $scenarios[self::SCENARIO_UPDATE_SERVICE_QUOTATION] = [
         'modelsQuotationService',
         'deletedQuotationServicesId',
         'catatan_quotation_service'
      ];

      $scenarios[self::SCENARIO_CREATE_TERM_AND_CONDITION] = [
         'modelsQuotationTermAndCondition'
      ];

      $scenarios[self::SCENARIO_UPDATE_TERM_AND_CONDITION] = [
         'modelsQuotationTermAndCondition',
         'deletedQuotationTermAndCondition',
      ];

      $scenarios[self::SCENARIO_CREATE_FORM_JOB] = [
         'modelFormJob'
      ];


      return $scenarios;
   }

   /**
    * @return array
    */
   public function attributeLabels(): array
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'id' => 'ID',
         'nomor' => 'Nomor',
         'mata_uang_id' => 'Mata Uang',
         'tanggal' => 'Tanggal',
         'customer_id' => 'Customer',
         'tanggal_batas_valid' => 'Tanggal Batas Valid',
         'attendant_1' => 'Attendant 1',
         'attendant_phone_1' => 'Attendant Phone 1',
         'attendant_email_1' => 'Attendant Email 1',
         'attendant_2' => 'Attendant 2',
         'attendant_phone_2' => 'Attendant Phone 2',
         'attendant_email_2' => 'Attendant Email 2',
         'catatan_quotation_barang' => 'Catatan Quotation Barang',
         'catatan_quotation_service' => 'Catatan Quotation Service',
         'delivery_fee' => 'Delivery Fee',
         'materai_fee' => 'Materai Fee',
         'vat_percentage' => '% Vat',
         'rekening_id' => 'Rekening',
         'signature_orang_kantor_id' => 'Signature Orang Kantor',
      ]);
   }

   /**
    * Membuat item-item quotation barang
    * @return bool
    */
   public function createModelsQuotationBarang(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         if ($flag = $this->save(false)) {
            /** @var QuotationBarang $qb */
            foreach ($this->modelsQuotationBarang as $qb) {

               $qb->quotation_id = $this->id;
               $flag = $qb->save(false);
               if (!$flag) {
                  break;
               }

            }
         }


         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
      }
      return false;
   }

   /**
    * Meng-update item-item quotation barang
    * @return bool
    */
   public function updateModelsQuotationBarang(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {


         if ($flag = $this->save(false)) {
            if (!empty($this->deletedQuotationBarangsId)) {
               QuotationBarang::deleteAll(['id' => $this->deletedQuotationBarangsId]);
            }

            /** @var QuotationBarang $qb */
            foreach ($this->modelsQuotationBarang as $qb) {

               $qb->quotation_id = $this->id;
               $flag = $qb->save(false);

               if (!$flag) {
                  break;
               }

            }
         }


         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
      }
      return false;
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function createModelsQuotationService(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         if ($flag = $this->save(false)) {

            /** @var QuotationService $qs */
            foreach ($this->modelsQuotationService as $qs) {
               $qs->quotation_id = $this->id;
               $flag = $qs->save(false);
               if (!$flag) {
                  break;
               }
            }

         }

         if ($flag) {
            $transaction->commit();
            return true;
         }

         $transaction->rollBack();
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new Exception('Transaction gagal');
      }
      return false;
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function updateModelsQuotationService(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         if ($flag = $this->save(false)) {

            if (!empty($this->deletedQuotationServicesId)) {
               QuotationService::deleteAll(['id' => $this->deletedQuotationServicesId]);
            }

            /** @var QuotationService $quotationService */
            foreach ($this->modelsQuotationService as $quotationService) {

               $quotationService->quotation_id = $this->id;
               $flag = $quotationService->save(false);

               if (!$flag) {
                  break;
               }

            }
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new Exception($e->getMessage());
      }
      return false;
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function createModelsTermAndCondition(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         $flag = true;
         /** @var QuotationTermAndCondition $termAndCondition */
         foreach ($this->modelsQuotationTermAndCondition as $termAndCondition) {

            $termAndCondition->quotation_id = $this->id;
            $flag = $termAndCondition->save(false);

            if (!$flag) {
               break;
            }

         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new Exception($e->getMessage());
      }
      return false;
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function updateModelsTermAndCondition(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         $flag = true;

         if (!empty($this->deletedQuotationTermAndCondition)) {
            QuotationTermAndCondition::deleteAll(['id' => $this->deletedQuotationTermAndCondition]);
         }

         /** @var QuotationTermAndCondition $termAndCondition */
         foreach ($this->modelsQuotationTermAndCondition as $termAndCondition) {

            $termAndCondition->quotation_id = $this->id;
            $flag = $termAndCondition->save(false);

            if (!$flag) {
               break;
            }

         }
         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new Exception($e->getMessage());
      }
      return false;
   }

   /**
    * @return float|int
    */
   public function getQuotationGrandTotal(): float|int
   {
      return $this->quotationServicesTotal + $this->materai_fee + $this->quotationBarangsTotal;
   }

   /**
    * @return mixed
    */
   public function getQuotationVatTotal(): mixed
   {
      return $this->quotationBarangsTotalVatNominal + $this->quotationServicesTotalVatNominal;
   }

   /**
    * @return mixed
    */
   public function getQuotationFeeTotal(): mixed
   {
      return
         $this->delivery_fee +
         $this->quotationBarangsBeforeDiscountSubtotal +
         $this->quotationServicesBeforeDiscountDasarPengenaanPajak +
         $this->materai_fee;
   }

   /**
    * @return mixed
    */
   public function getQuotationDiscountTotal(): mixed
   {
      return
         $this->quotationBarangsDiscount +
         $this->quotationServicesDiscount;
   }

   /**
    * @return string
    */
   public function getVatPercentageLabel(): string
   {
      return $this->vat_percentage . ' %';
   }


}