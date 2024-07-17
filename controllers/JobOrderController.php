<?php

namespace app\controllers;

use app\components\helpers\ArrayHelper;
use app\models\form\PaymentKasbonForm;
use app\models\JobOrder;
use app\models\JobOrderBill;
use app\models\JobOrderBillDetail;
use app\models\JobOrderDetailCashAdvance;
use app\models\search\JobOrderSearch;
use app\models\Tabular;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * JobOrderController implements the CRUD actions for JobOrder model.
 */
class JobOrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all JobOrder models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new JobOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobOrder model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelPaymentKasbon' => new PaymentKasbonForm(),
        ]);
    }

    /**
     * Creates a new JobOrder model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $model = new JobOrder();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'JobOrder: ' . $model->reference_number . ' berhasil ditambahkan.');
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
     * Updates an existing JobOrder model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'JobOrder: ' . $model->reference_number . ' berhasil dirubah.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JobOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', 'JobOrder: ' . $model->reference_number . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws InvalidConfigException
     */
    public function actionExportToPdf(int $id): string
    {
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_pdf', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * @param $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionCreateCashAdvance($id): Response|string
    {
        $jobOrder = $this->findModel($id);
        $model = new JobOrderDetailCashAdvance([
            'job_order_id' => $id,
        ]);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'JobOrderDetailCashAdvance: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['view', 'id' => $id, '#' => 'quotation-tab-tab1']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('cash-advance/create', [
            'model' => $model,
            'jobOrder' => $jobOrder
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateCashAdvance($id): Response|string
    {
        $model = JobOrderDetailCashAdvance::find()->asModel($id);
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'JobOrderDetailCashAdvance: ' . $model->id . ' berhasil diupdate.');
                return $this->redirect(['view', 'id' => $model->job_order_id, '#' => 'quotation-tab-tab1']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('cash-advance/update', [
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
    public function actionDeleteCashAdvance(int $id): Response
    {
        $model = JobOrderDetailCashAdvance::find()->asModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'JobOrderDetailCashAdvance: ' . $model->id . ' berhasil dihapus.');
        }
        return $this->redirect(['view', 'id' => $model->job_order_id, '#' => 'quotation-tab-tab1']);
    }

    /**
     * @return Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionPaymentCashAdvance(): Response
    {
        $data = Yii::$app->request->post(StringHelper::basename(PaymentKasbonForm::class));
        $model = JobOrderDetailCashAdvance::find()->asModel($data['id']);

        if ($model->markAsPaid()) {
            Yii::$app->session->setFlash('success', 'Payment cash advance berhasil dilakukan.');
        }
        return $this->redirect(['view', 'id' => $model->job_order_id, '#' => 'quotation-tab-tab1']);
    }

    public function actionExportToPdfPaymentCashAdvance(int $id): string
    {
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_pdf_cash_advance', [
            'model' => JobOrderDetailCashAdvance::find()->asModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionCreateBill($id): Response|string
    {
        $jobOrder = $this->findModel($id);

        $model = new JobOrderBill([
            'job_order_id' => $id,
        ]);
        $modelsDetail = [new JobOrderBillDetail()];

        if ($model->load(Yii::$app->request->post())) {

            $modelsDetail = Tabular::createMultiple(JobOrderBillDetail::class);
            Tabular::loadMultiple($modelsDetail, Yii::$app->request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {

                $transaction = JobOrderBill::getDb()->beginTransaction();

                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $detail) :
                            $detail->job_order_bill_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }
                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = ['code' => 1, 'message' => 'Commit'];
                    } else {
                        $transaction->rollBack();
                        $status = ['code' => 0, 'message' => 'Roll Back'];
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('success', 'JobOrderBill: ' . Html::a($model->id, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['view', 'id' => $jobOrder->id, '#' => 'quotation-tab-tab2']);
                }

                Yii::$app->session->setFlash('danger', " JobOrderBill is failed to insert. Info: " . $status['message']);
            }
        }
        return $this->render('bill/create', [
            'jobOrder' => $jobOrder,
            'model' => $model,
            'modelsDetail' => $modelsDetail,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateBill($id): Response|string
    {
        $request = Yii::$app->request;
        $model = JobOrderBill::find()->asModel($id);
        $modelsDetail = !empty($model->jobOrderBillDetails) ? $model->jobOrderBillDetails : [new JobOrderBillDetail()];

        if ($model->load($request->post())) {

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(JobOrderBillDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if ($isValid) {
                $transaction = JobOrderBill::getDb()->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailsID)) {
                            JobOrderBillDetail::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $detail) :
                            $detail->job_order_bill_id = $model->id;
                            if (!($flag = $detail->save(false))) {
                                break;
                            }
                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = ['code' => 1, 'message' => 'Commit'];
                    } else {
                        $transaction->rollBack();
                        $status = ['code' => 0, 'message' => 'Roll Back'];
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if ($status['code']) {
                    Yii::$app->session->setFlash('info', "JobOrderBill: " . Html::a($model->id, ['view', 'id' => $model->id]) . " berhasil di update.");
                    return $this->redirect(['view', 'id' => $model->jobOrder->id, '#' => 'quotation-tab-tab2']);
                }

                Yii::$app->session->setFlash('danger', " JobOrderBill is failed to updated. Info: " . $status['message']);
            }
        }

        return $this->render('bill/update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDeleteBill($id): Response|string
    {
        $model = JobOrderBill::find()->asModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'JobOrderBill berhasil dihapus.');
        }
        return $this->redirect(['view', 'id' => $model->job_order_id, '#' => 'quotation-tab-tab2']);
    }

    /**
     * Expand row column
     * @return string
     */
    public function actionViewBillDetail(): string
    {
        if (isset($_POST['expandRowKey'])) {
            $model = JobOrderBill::findOne($_POST['expandRowKey']);
            return $this->renderPartial('bill/_view_detail', ['model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionCreateForPettyCash(): Response|string
    {
        $model = new JobOrder();
        $model->scenario = JobOrder::SCENARIO_FOR_PETTY_CASH;

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveForPettyCash()) {
                Yii::$app->session->setFlash('success', 'JobOrder: ' . $model->reference_number . ' berhasil ditambahkan.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('petty-cash/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdateForPettyCash($id): Response|string
    {
        $model = JobOrder::findOne($id);
        $model->scenario = JobOrder::SCENARIO_FOR_PETTY_CASH;
        $jobOrderBill = $model->jobOrderBills[0];
        $jobOrderBillDetail = $jobOrderBill->jobOrderBillDetails[0];

        $model->jenisBiayaPettyCash = $jobOrderBillDetail->jenis_biaya_id;
        $model->vendorPettyCash = $jobOrderBill->vendor_id;
        $model->nominalPettyCash = $jobOrderBillDetail->price;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->updateForPettyCash()) {
                Yii::$app->session->setFlash('success', 'JobOrder: ' . $model->reference_number . ' berhasil di-update.');
                return $this->redirect(['view', 'id' => $model->id, '#' => 'quotation-tab-tab1']);
            }
            Yii::$app->session->setFlash('danger', 'JobOrder: ' . $model->reference_number . ' gagal di update.');
        }

        return $this->render('petty-cash/update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the JobOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JobOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): JobOrder
    {
        if (($model = JobOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}