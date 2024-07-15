<?php

namespace app\controllers;

use app\models\BuktiPenerimaanBukuBank;
use app\models\search\BuktiPenerimaanBukuBankSearch;
use kartik\mpdf\Pdf;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * BuktiPenerimaanBukuBankController implements the CRUD actions for BuktiPenerimaanBukuBank model.
 */
class BuktiPenerimaanBukuBankController extends Controller
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
     * Lists all BuktiPenerimaanBukuBank models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new BuktiPenerimaanBukuBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BuktiPenerimaanBukuBank model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }


    /**
     * @return Response|string
     */
    public function actionCreateForInvoices(): Response|string
    {
        $model = new BuktiPenerimaanBukuBank();
        $model->scenario = BuktiPenerimaanBukuBank::SCENARIO_FOR_INVOICES;

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->saveForInvoices()){
                Yii::$app->session->setFlash('success', 'BuktiPenerimaanBukuBank berhasil ditambahkan.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('error', 'BuktiPenerimaanBukuBank gagal ditambahkan.');
        }

        return $this->render('invoices/create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateForInvoices(int $id): Response|string{
        $model = $this->findModel($id);
        $model->scenario = BuktiPenerimaanBukuBank::SCENARIO_FOR_INVOICES;

        if ($this->request->isPost && $model->load($this->request->post())) {

            if( $model->saveForInvoices()){
                Yii::$app->session->setFlash('info', 'BuktiPenerimaanBukuBank: ' . $model->reference_number . ' berhasil dirubah.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', 'BuktiPenerimaanBukuBank gagal ditambahkan.');

        }

        return $this->render('invoices/update', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionCreateForSetoranKasir(): Response|string
    {
        $model = new BuktiPenerimaanBukuBank();
        $model->scenario = BuktiPenerimaanBukuBank::SCENARIO_FOR_SETORAN_KASIR;

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->saveForSetoranKasir()){
                Yii::$app->session->setFlash('success', 'BuktiPenerimaanBukuBank berhasil ditambahkan.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('error', 'BuktiPenerimaanBukuBank gagal ditambahkan.');
        }

        return $this->render('setoran-kasir/create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdateForSetoranKasir(int $id): Response|string{
        $model = $this->findModel($id);
        $model->scenario = BuktiPenerimaanBukuBank::SCENARIO_FOR_SETORAN_KASIR;

        if ($this->request->isPost && $model->load($this->request->post())) {

            if( $model->saveForSetoranKasir()){
                Yii::$app->session->setFlash('info', 'BuktiPenerimaanBukuBank: ' . $model->reference_number . ' berhasil dirubah.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('error', 'BuktiPenerimaanBukuBank gagal ditambahkan.');

        }

        return $this->render('setoran-kasir/update', [
            'model' => $model,
        ]);
    }

    public function actionExportToPdf($id){
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_pdf', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * Deletes an existing BuktiPenerimaanBukuBank model.
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

        Yii::$app->session->setFlash('danger', 'BuktiPenerimaanBukuBank: ' . $model->reference_number . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the BuktiPenerimaanBukuBank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BuktiPenerimaanBukuBank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): BuktiPenerimaanBukuBank
    {
        if (($model = BuktiPenerimaanBukuBank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}