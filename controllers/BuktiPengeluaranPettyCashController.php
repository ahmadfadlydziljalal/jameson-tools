<?php

namespace app\controllers;

use kartik\mpdf\Pdf;
use Yii;
use app\models\BuktiPengeluaranPettyCash;
use app\models\search\BuktiPengeluaranPettyCashSearch;
use Throwable;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\web\Response;

/**
* BuktiPengeluaranPettyCashController implements the CRUD actions for BuktiPengeluaranPettyCash model.
*/
class BuktiPengeluaranPettyCashController extends Controller
{
    /**
    * {@inheritdoc}
    */
    public function behaviors() : array
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
    * Lists all BuktiPengeluaranPettyCash models.
    * @return string
    */
    public function actionIndex() : string {
        $searchModel = new BuktiPengeluaranPettyCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single BuktiPengeluaranPettyCash model.
    * @param integer $id
    * @return string
    * @throws NotFoundHttpException
    */
    public function actionView(int $id) : string
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new BuktiPengeluaranPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     */
    public function actionCreateByCashAdvance(): Response|string
    {
        $model = new BuktiPengeluaranPettyCash();
        $model->scenario = BuktiPengeluaranPettyCash::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON;
        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->saveByCashAdvance()){
                Yii::$app->session->setFlash('success',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }
        return $this->render('kasbon/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BuktiPengeluaranPettyCash model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateByCashAdvance(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->scenario = BuktiPengeluaranPettyCash::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON;

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->updateByCashAdvance()){
            Yii::$app->session->setFlash('info',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('kasbon/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BuktiPengeluaranPettyCash model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteByCashAdvance(int $id) : Response {
        $model = $this->findModel($id);

        if($model->deleteByCashAdvance()){
            Yii::$app->session->setFlash('success',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil dihapus.');
        }else{
            Yii::$app->session->setFlash('danger',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' gagal dihapus!');
        }

        return $this->redirect(['index']);
    }

    /**
     * Creates a new BuktiPengeluaranPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     */
    public function actionCreateByBill(): Response|string
    {
        $model = new BuktiPengeluaranPettyCash();
        $model->scenario = BuktiPengeluaranPettyCash::SCENARIO_PENGELUARAN_BY_BILL;

        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->saveByBill()){
                Yii::$app->session->setFlash('success',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('bill/create', [
            'model' => $model,
        ]);
    }

    /**
    * Updates an existing BuktiPengeluaranPettyCash model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdateByBill(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->scenario = BuktiPengeluaranPettyCash::SCENARIO_PENGELUARAN_BY_BILL;

        if($this->request->isPost && $model->load($this->request->post())){
            if($model->updateByBill()){
                Yii::$app->session->setFlash('info',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil dirubah.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('danger',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' gagal dirubah.');
        }

        return $this->render('bill/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BuktiPengeluaranPettyCash model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteByBill(int $id) : Response {
        $model = $this->findModel($id);
        $model->deleteByBill();

        Yii::$app->session->setFlash('danger',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionExportToPdf($id): string
    {
        /** @var Pdf $pdf */
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_pdf', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * @param $q
     * @param $id
     * @return array
     */
    public function actionFindById($q = null, $id = null): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return BuktiPengeluaranPettyCash::find()->liveSearchById($q, $id);
    }

    /**
    * Finds the BuktiPengeluaranPettyCash model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return BuktiPengeluaranPettyCash the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : BuktiPengeluaranPettyCash {
        if (($model = BuktiPengeluaranPettyCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}