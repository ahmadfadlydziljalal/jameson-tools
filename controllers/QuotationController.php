<?php

namespace app\controllers;

use app\components\BarangQuotation;
use app\components\DeliveryReceiptQuotation;
use app\components\helpers\ArrayHelper;
use app\components\ProformaDebitNoteDetailBarangComponent;
use app\components\ProformaDebitNoteDetailServiceComponent;
use app\components\ProformaInvoiceDetailBarangComponent;
use app\components\ProformaInvoiceDetailServiceComponent;
use app\components\ServiceQuotation;
use app\components\TermConditionQuotation;
use app\models\form\LaporanOutgoingQuotation;
use app\models\ProformaDebitNote;
use app\models\ProformaInvoice;
use app\models\Quotation;
use app\models\QuotationBarang;
use app\models\QuotationDeliveryReceipt;
use app\models\QuotationFormJob;
use app\models\search\QuotationSearch;
use JetBrains\PhpStorm\ArrayShape;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
   /**
    * {@inheritdoc}
    */
   #[ArrayShape(['verbs' => "array"])]
   public function behaviors(): array
   {
      return [
         'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
               'delete' => ['POST'],
               'delete-barang-quotation' => ['POST'],
               'delete-service-quotation' => ['POST'],
               'delete-term-and-condition' => ['POST'],
            ],
         ],
      ];
   }

   /**
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new QuotationSearch();
      $dataProvider = $searchModel->search(
         Yii::$app->request->queryParams
      );

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * @param int $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionView(int $id): string
   {
      return $this->render('view', [
         'model' => $this->findModel($id),
      ]);
   }

   /**
    * @throws NotFoundHttpException
    */
   protected function findModel(int $id): Quotation
   {
      if (($model = Quotation::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException(
            'The requested page does not exist.'
         );
      }
   }

   /**
    * @return Response|string
    */
   public function actionCreate(): Response|string
   {
      $model = new Quotation();
      if ($this->request->isPost) {
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Quotation: ' . $model->nomor . ' berhasil ditambahkan.');
            return $this->redirect(['view', 'id' => $model->id]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('create', [
         'model' => $model,
      ]);
   }

   /**
    * @param int $id
    * @return Response|string
    * @throws NotFoundHttpException
    */
   public function actionUpdate(int $id): Response|string
   {
      $model = $this->findModel($id);

      if ($this->request->isPost
         && $model->load($this->request->post())
         && $model->save()
      ) {
         Yii::$app->session->setFlash(
            'info',
            'Quotation: ' . $model->nomor . ' berhasil dirubah.'
         );
         return $this->redirect([
            'quotation/view',
            'id' => $id,
            '#' => 'quotation-tab-tab0'
         ]);
      }

      return $this->render('update', [
         'model' => $model,
      ]);
   }

   /**
    * @param int $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDelete(int $id): Response
   {
      $model = $this->findModel($id);
      $model->delete();

      Yii::$app->session->setFlash(
         'danger',
         'Quotation: ' . $model->nomor . ' berhasil dihapus.'
      );
      return $this->redirect(['index']);
   }


   /**
    * @param $id
    * @return string
    * @throws InvalidConfigException
    * @throws NotFoundHttpException
    * @throws MpdfException
    * @throws CrossReferenceException
    * @throws PdfParserException
    * @throws PdfTypeException
    */
   public function actionPrintToPdf($id): string
   {
      /** @var Pdf $pdf */
      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('preview_print', [
         'model' => $this->findModel($id),
      ]);
      return $pdf->render();
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionCreateBarangQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_BARANG_QUOTATION,
      ]);

      if ($this->request->isPost && $component->quotation->load($this->request->post())) {
         if ($component->create()) {
            return $this->redirect(['quotation/view', 'id' => $id, '#' => 'quotation-tab-tab0']);
         }
      }

      return $this->render('create_barang_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationBarangs,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionUpdateBarangQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_UPDATE_BARANG_QUOTATION,
      ]);

      if ($this->request->isPost
         && $component->quotation->load($this->request->post())
         && $component->update()
      ) {
         return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab1']
         );
      }

      return $this->render('update_barang_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationBarangs,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteBarangQuotation($id): Response
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id
      ]);
      $component->delete();
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab0'
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionCreateServiceQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_SERVICE_QUOTATION,
      ]);
      if ($component->quotation->load($this->request->post())) {
         if ($component->create()) {
            return $this->redirect([
               'quotation/view',
               'id' => $component->quotation->id,
               '#' => 'quotation-tab-tab2'
            ]);
         }
      }
      return $this->render('create_service_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationServices,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionUpdateServiceQuotation($id): Response|string
   {

      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_UPDATE_SERVICE_QUOTATION,
      ]);
      if ($this->request->isPost
         && $component->quotation->load($this->request->post())
         && $component->update()) {
         return $this->redirect([
            'quotation/view',
            'id' => $id,
            '#' => 'quotation-tab-tab2'
         ]);
      }

      return $this->render('update_service_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationServices,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteServiceQuotation($id): Response
   {
      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id
      ]);
      $component->delete();
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab2'
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionCreateTermAndCondition($id): Response|string
   {
      $component = Yii::createObject([
         'class' => TermConditionQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_TERM_AND_CONDITION,
      ]);

      if ($this->request->isPost) {
         if ($component->create()) {
            return $this->redirect([
               'quotation/view',
               'id' => $component->quotation->id,
               '#' => 'quotation-tab-tab3'
            ]);
         }
      }

      return $this->render('create_term_and_condition', [
         'quotation' => $component->quotation,
         'models' => $component->quotationTermAndConditions,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionUpdateTermAndCondition($id): Response|string
   {
      $component = Yii::createObject([
         'class' => TermConditionQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_UPDATE_TERM_AND_CONDITION,
      ]);

      if ($this->request->isPost && $component->update()) {
         return $this->redirect([
            'quotation/view',
            'id' => $id,
            '#' => 'quotation-tab-tab3'
         ]);
      }

      return $this->render('update_term_and_condition', [
         'quotation' => $component->quotation,
         'models' => $component->quotationTermAndConditions,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteTermAndCondition($id): Response
   {
      $component = Yii::createObject(['class' => TermConditionQuotation::class, 'quotationId' => $id]);
      $component->delete();
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab3'
      ]);
   }

   /**
    * @param $id
    * @return string|Response
    * @throws NotFoundHttpException
    */
   public function actionCreateFormJob($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = new QuotationFormJob(['quotation_id' => $id]);
      $model->scenario = $model::SCENARIO_CREATE_UPDATE;

      if ($model->load($this->request->post()) && $model->validate()) {

         if ($model->createFormJob()) {
            Yii::$app->session->setFlash(
               'success',
               'Data sesuai dengan validasi yang ditetapkan'
            );
            return $this->redirect([
               'quotation/view',
               'id' => $quotation->id,
               '#' => 'quotation-tab-tab4'
            ]);
         }

         Yii::$app->session->setFlash(
            'danger',
            'Data tidak sesuai dengan validasi yang ditetapkan'
         );
      }

      return $this->render('create_form_job', [
         'quotation' => $quotation,
         'model' => $model
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    * @throws Throwable
    */
   public function actionUpdateFormJob($id): Response|string
   {
      $quotation = $this->findModel($id);
      if (!empty($quotation->quotationFormJob)) {
         $model = $quotation->quotationFormJob;
         $model->mekaniksId = ArrayHelper::getColumn($model->quotationFormJobMekaniks, 'mekanik_id');
      } else {
         $model = new QuotationFormJob(['quotation_id' => $quotation->id]);
      }
      $model->scenario = $model::SCENARIO_CREATE_UPDATE;

      if ($model->load($this->request->post()) && $model->validate()) {

         if ($model->updateFormJob()) {
            Yii::$app->session->setFlash(
               'success',
               'Data sesuai dengan validasi yang ditetapkan'
            );
            return $this->redirect([
               'quotation/view',
               'id' => $quotation->id,
               '#' => 'quotation-tab-tab4'
            ]);
         }

         Yii::$app->session->setFlash(
            'danger',
            'Data tidak sesuai dengan validasi yang ditetapkan'
         );
      }

      return $this->render('update_form_job', [
         'quotation' => $quotation,
         'model' => $model
      ]);
   }

   /**
    * @param $id
    * @return Response
    */
   public function actionDeleteFormJob($id): Response
   {

      $models = QuotationFormJob::findAll([
         'quotation_id' => $id
      ]);

      array_walk($models, function ($item) {
         $item->delete();
      });

      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus form job ' . Quotation::findOne($id)->nomor,
      ]]);

      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab4'
      ]);
   }

   /**
    * @param $id
    * @return string
    * @throws CrossReferenceException
    * @throws InvalidConfigException
    * @throws MpdfException
    * @throws NotFoundHttpException
    * @throws PdfParserException
    * @throws PdfTypeException
    */
   public function actionPrintFormJob($id): string
   {
      $quotation = $this->findModel($id);
      /** @var Pdf $pdf */
      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('preview_print_form_job', [
         'quotation' => $quotation,
         'quotationFormJob' => $quotation->quotationFormJob
      ]);
      return $pdf->render();
   }

   /**
    * Create Delivery Receipt, dimana Delivery Receipt Detail by default dibentuk dari Quotation Barang
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateDeliveryReceipt($id): Response|string
   {

      $quotationBarangs = QuotationBarang::find()
         ->forCreateDeliveryReceipt($id);

      if (!$quotationBarangs) {
         Yii::$app->session->setFlash('danger', [[
            'title' => 'Pesan Sistem',
            'message' => 'Tidak dapat membuat Delivery Receipt. Sistem mendeteksi masing-masing quantity barang sudah dikirim semua.'
         ]]);
         return $this->redirect([
            'quotation/view',
            'id' => $id,
            '#' => 'quotation-tab-tab5'
         ]);
      }

      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationId' => $id,
         'quotationBarangs' => $quotationBarangs,
         'scenario' => QuotationDeliveryReceipt::SCENARIO_CREATE
      ]);

      if ($this->request->isPost
         && $component->quotationDeliveryReceipt->load($this->request->post())
      ) {
         if ($component->create()) {
            return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab5'
            ]);
         }
      }

      return $this->render('create_delivery_receipt', [
         'quotation' => $component->quotation,
         'model' => $component->quotationDeliveryReceipt,
         'modelsDetail' => $component->quotationDeliveryReceiptDetails,
      ]);
   }

   /**
    * Update Delivery Receipt
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateDeliveryReceipt($id): Response|string
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationDeliveryReceiptId' => $id,
         'scenario' => QuotationDeliveryReceipt::SCENARIO_UPDATE
      ]);

      if ($this->request->isPost
         && $component->quotationDeliveryReceipt->load($this->request->post())
         && $component->update()) {
         return $this->redirect([
            'quotation/view',
            'id' => $component->quotation->id,
            '#' => 'quotation-tab-tab5'
         ]);
      }

      return $this->render('update_delivery_receipt', [
         'quotation' => $component->quotation,
         'model' => $component->quotationDeliveryReceipt,
         'modelsDetail' => $component->quotationDeliveryReceiptDetails,
      ]);
   }

   /**
    * Delete Delivery Receipt
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteDeliveryReceipt($id): Response
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationDeliveryReceiptId' => $id
      ]);
      $component->delete();
      return $this->redirect([
         'quotation/view',
         'id' => $component->quotationDeliveryReceipt->quotation_id,
         '#' => 'quotation-tab-tab5'
      ]);
   }

   /**
    * Delete Delivery Receipts
    * @param $id
    * @return Response
    * @throws Throwable
    */
   public function actionDeleteAllDeliveryReceipt($id): Response
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationId' => $id
      ]);
      $component->deleteAll();
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab5'
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionKonfirmasiDiterimaCustomer($id): Response|string
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationDeliveryReceiptId' => $id,
         'scenario' => QuotationDeliveryReceipt::SCENARIO_KONFIRMASI_DITERIMA_CUSTOMER
      ]);

      if ($this->request->isPost
         && $component->quotationDeliveryReceipt->load($this->request->post())
      ) {
         if ($component->konfirmasiDiterimaCustomer()) {
            return $this->redirect([
               'quotation/view',
               'id' => $component->quotation->id,
               '#' => 'quotation-tab-tab5'
            ]);
         }
      }

      return $this->render('konfirmasi_delivery_receipt_diterima_customer', [
         'quotation' => $component->quotation,
         'model' => $component->quotationDeliveryReceipt,
      ]);
   }

   /**
    * Print HTML Delivery Receipt
    * @param $id
    * @return string
    */
   public function actionPrintDeliveryReceipt($id): string
   {
      $model = QuotationDeliveryReceipt::findOne($id);
      $quotation = $model->quotation;

      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('preview_print_delivery_receipt', [
         'quotation' => $quotation,
         'model' => $model
      ]);
      return $pdf->render();
   }

   /**
    * @return Response|string
    */
   public function actionLaporanOutgoing(): Response|string
   {
      $model = new LaporanOutgoingQuotation();

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect(
            [
               'quotation/preview-laporan-outgoing',
               'tanggal' => $model->tanggal
            ]
         );
      }

      return $this->render('_form_laporan_outgoing', [
         'model' => $model
      ]);
   }

   public function actionPreviewLaporanOutgoing($tanggal): string
   {
      $model = new LaporanOutgoingQuotation([
         'tanggal' => $tanggal
      ]);
      return $this->render('_preview_laporan_outgoing', [
         'model' => $model
      ]);
   }

   /**
    * @param $id
    * @return string|Response
    * @throws NotFoundHttpException
    */
   public function actionCreateProformaInvoice($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = new ProformaInvoice();
      $model->quotation_id = $id;

      if ($this->request->isPost) {
         if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab7'
            ]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('create_proforma_invoice', [
         'model' => $model,
         'quotation' => $quotation,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    */
   public function actionUpdateProformaInvoice($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = $quotation->proformaInvoice;

      if ($this->request->isPost) {
         if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab7'
            ]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('update_proforma_invoice', [
         'model' => $model,
         'quotation' => $quotation,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteProformaInvoice($id): Response
   {
      $quotation = $this->findModel($id);
      $quotation->proformaInvoice->delete();
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab7'
      ]);
   }

   /**
    * Membuat proforma invoice dengan detail barang
    * berdasarkan dari quotation dengan customer sebelumnya
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateProformaInvoiceDetailBarang($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailBarangComponent::class,
         'proformaInvoiceId' => $id,
         'scenario' => ProformaInvoice::SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_BARANG
      ]);

      if ($component->checkThatProformaInvoiceHasNotExist()) {
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaInvoice->quotation->id,
            '#' => 'quotation-tab-tab7'
         ]);
      }

      if ($this->request->isPost && $component->create()) return $this->redirect([
         'quotation/view',
         'id' => $component->proformaInvoice->quotation->id,
         '#' => 'quotation-tab-tab7'
      ]);

      return $this->render('create_proforma_invoice_barang', [
         'quotation' => $component->proformaInvoice->quotation,
         'model' => $component->proformaInvoice,
         'modelsDetail' => $component->proformaInvoiceDetailBarangs
      ]);
   }

   /**
    * Update data proforma invoice detail barang.
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateProformaInvoiceDetailBarang($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailBarangComponent::class,
         'proformaInvoiceId' => $id,
         'scenario' => ProformaInvoice::SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_BARANG
      ]);

      if ($this->request->isPost && $component->update())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaInvoice->quotation->id,
            '#' => 'quotation-tab-tab7'
         ]);

      return $this->render('update_proforma_invoice_detail_barang', [
         'quotation' => $component->proformaInvoice->quotation,
         'model' => $component->proformaInvoice,
         'modelsDetail' => $component->proformaInvoiceDetailBarangs
      ]);
   }

   /**
    * Delete data proforma invoice detail barang%
    * @param $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteProformaInvoiceDetailBarang($id): Response
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailBarangComponent::class,
         'proformaInvoiceId' => $id,
      ]);

      $component->delete();

      return $this->redirect([
         'quotation/view',
         'id' => $component->proformaInvoice->quotation->id,
         '#' => 'quotation-tab-tab7'
      ]);
   }

   /**
    * Membuat proforma invoice dengan detail service
    * berdasarkan dari quotation dengan customer sebelumnya
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateProformaInvoiceDetailService($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailServiceComponent::class,
         'proformaInvoiceId' => $id,
         'scenario' => ProformaInvoice::SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_SERVICE
      ]);

      if ($component->checkThatProformaInvoiceHasNotExist()) {
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaInvoice->quotation->id, '#' => 'quotation-tab-tab7'
         ]);
      }

      if ($this->request->isPost && $component->create())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaInvoice->quotation->id,
            '#' => 'quotation-tab-tab7'
         ]);

      return $this->render('create_proforma_invoice_service', [
         'quotation' => $component->proformaInvoice->quotation,
         'model' => $component->proformaInvoice,
         'modelsDetail' => $component->proformaInvoiceDetailServices
      ]);
   }

   /**
    * Update data proforma invoice detail service.
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateProformaInvoiceDetailService($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailServiceComponent::class,
         'proformaInvoiceId' => $id,
         'scenario' => ProformaInvoice::SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_SERVICE
      ]);

      if ($this->request->isPost && $component->update())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaInvoice->quotation->id,
            '#' => 'quotation-tab-tab7'
         ]);

      return $this->render('update_proforma_invoice_detail_service', [
         'quotation' => $component->proformaInvoice->quotation,
         'model' => $component->proformaInvoice,
         'modelsDetail' => $component->proformaInvoiceDetailServices
      ]);
   }

   /**
    * Delete data proforma invoice detail service
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    * @throws StaleObjectException
    */
   public function actionDeleteProformaInvoiceDetailService($id): Response
   {
      $component = Yii::createObject([
         'class' => ProformaInvoiceDetailServiceComponent::class,
         'proformaInvoiceId' => $id,
      ]);

      $component->delete();

      return $this->redirect([
         'quotation/view',
         'id' => $component->proformaInvoice->quotation->id,
         '#' => 'quotation-tab-tab7'
      ]);
   }

   /**
    * Print proforma invoice dari HTMl ke built in browser
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionPrintProformaInvoice($id): string
   {
      $quotation = $this->findModel($id);
      $model = $quotation->proformaInvoice;

      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('preview_print_proforma_invoice', [
         'quotation' => $quotation,
         'model' => $model
      ]);
      return $pdf->render();
   }

   /**
    * Create master proforma debit note
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    */
   public function actionCreateProformaDebitNote($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = new ProformaDebitNote();
      $model->quotation_id = $id;

      if ($this->request->isPost) {
         if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan Sukses',
               'message' => 'Proforma Debit Note berhasil dibuat dengan nomor ' . $model->nomor . '.'
            ]]);
            return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab8'
            ]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('create_proforma_debit_note', [
         'model' => $model,
         'quotation' => $quotation,
      ]);
   }

   /**
    * Update master proforma debit note
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    */
   public function actionUpdateProformaDebitNote($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = $quotation->proformaDebitNote;

      if ($this->request->isPost) {
         if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan Sukses',
               'message' => 'Proforma Debit Note dengan nomor ' . $model->nomor . ' berhasil di update.'
            ]]);
            return $this->redirect([
               'quotation/view',
               'id' => $id,
               '#' => 'quotation-tab-tab8'
            ]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('update_proforma_debit_note', [
         'model' => $model,
         'quotation' => $quotation,
      ]);
   }

   /**
    * Delete master proforma debit note
    * @param $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteProformaDebitNote($id): Response
   {
      $quotation = $this->findModel($id);
      $quotation->proformaDebitNote->delete();
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sukses',
         'message' => 'Proforma Debit Note dengan nomor ' . $quotation->proformaDebitNote->nomor . ' berhasil di delete.'
      ]]);
      return $this->redirect([
         'quotation/view',
         'id' => $id,
         '#' => 'quotation-tab-tab8'
      ]);
   }

   /**
    * Membuat proforma debit note dengan detail barang
    * berdasarkan dari quotation dengan customer sebelumnya
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateProformaDebitNoteDetailBarang($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailBarangComponent::class,
         'proformaDebitNoteId' => $id,
         'scenario' => ProformaDebitNote::SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG
      ]);

      if ($component->checkThatProformaDebitNoteHasNotExist()) {
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaDebitNote->quotation->id,
            '#' => 'quotation-tab-tab8'
         ]);
      }

      if ($this->request->isPost && $component->create()) return $this->redirect([
         'quotation/view',
         'id' => $component->proformaDebitNote->quotation->id,
         '#' => 'quotation-tab-tab8'
      ]);

      return $this->render('create_proforma_debit_note_barang', [
         'quotation' => $component->proformaDebitNote->quotation,
         'model' => $component->proformaDebitNote,
         'modelsDetail' => $component->proformaDebitNoteDetailBarangs
      ]);

   }

   /**
    * Update data proforma debit note detail barang.
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateProformaDebitNoteDetailBarang($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailBarangComponent::class,
         'proformaDebitNoteId' => $id,
         'scenario' => ProformaDebitNote::SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG
      ]);

      if ($this->request->isPost && $component->update())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaDebitNote->quotation->id,
            '#' => 'quotation-tab-tab8'
         ]);

      return $this->render('update_proforma_debit_note_detail_barang', [
         'quotation' => $component->proformaDebitNote->quotation,
         'model' => $component->proformaDebitNote,
         'modelsDetail' => $component->proformaDebitNoteDetailBarangs
      ]);
   }

   /**
    * Delete data proforma debit note detail barang
    * @param $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteProformaDebitNoteDetailBarang($id): Response
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailBarangComponent::class,
         'proformaDebitNoteId' => $id,
      ]);

      $component->delete();

      return $this->redirect([
         'quotation/view',
         'id' => $component->proformaDebitNote->quotation->id,
         '#' => 'quotation-tab-tab8'
      ]);
   }

   /**
    * Membuat proforma debit note dengan detail service
    * berdasarkan dari quotation dengan customer sebelumnya
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateProformaDebitNoteDetailService($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailServiceComponent::class,
         'proformaDebitNoteId' => $id,
         'scenario' => ProformaDebitNote::SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE
      ]);

      if ($component->checkThatProformaDebitNoteHasNotExist()) {
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaDebitNote->quotation->id, '#' => 'quotation-tab-tab8'
         ]);
      }

      if ($this->request->isPost && $component->create())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaDebitNote->quotation->id,
            '#' => 'quotation-tab-tab8'
         ]);

      return $this->render('create_proforma_debit_note_service', [
         'quotation' => $component->proformaDebitNote->quotation,
         'model' => $component->proformaDebitNote,
         'modelsDetail' => $component->proformaDebitNoteDetailServices
      ]);
   }

   /**
    * Update data proforma debit note detail service.
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateProformaDebitNoteDetailService($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailServiceComponent::class,
         'proformaDebitNoteId' => $id,
         'scenario' => ProformaDebitNote::SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE
      ]);

      if ($this->request->isPost && $component->update())
         return $this->redirect([
            'quotation/view',
            'id' => $component->proformaDebitNote->quotation->id,
            '#' => 'quotation-tab-tab8'
         ]);

      return $this->render('update_proforma_debit_note_detail_service', [
         'quotation' => $component->proformaDebitNote->quotation,
         'model' => $component->proformaDebitNote,
         'modelsDetail' => $component->proformaDebitNoteDetailServices
      ]);
   }

   /**
    * Delete data proforma invoice detail service
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    * @throws StaleObjectException
    */
   public function actionDeleteProformaDebitNoteDetailService($id): Response
   {
      $component = Yii::createObject([
         'class' => ProformaDebitNoteDetailServiceComponent::class,
         'proformaDebitNoteId' => $id,
      ]);

      $component->delete();

      return $this->redirect([
         'quotation/view',
         'id' => $component->proformaDebitNote->quotation->id,
         '#' => 'quotation-tab-tab8'
      ]);
   }


   /**
    * Print proforma debit note dari HTMl ke built in browser
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionPrintProformaDebitNote($id): string
   {
      $quotation = $this->findModel($id);
      $model = $quotation->proformaDebitNote;

      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('preview_print_proforma_debit_note', [
         'quotation' => $quotation,
         'model' => $model
      ]);
      return $pdf->render();
   }


}