<?php

namespace app\controllers;

use kartik\mpdf\Pdf;
use Yii;
use app\models\BuktiPenerimaanPettyCash;
use app\models\search\BuktiPenerimaanPettyCashSearch;
use Throwable;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\web\Response;

/**
* BuktiPenerimaanPettyCashController implements the CRUD actions for BuktiPenerimaanPettyCash model.
*/
class BuktiPenerimaanPettyCashController extends Controller
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
    * Lists all BuktiPenerimaanPettyCash models.
    * @return string
    */
    public function actionIndex() : string {
        $searchModel = new BuktiPenerimaanPettyCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single BuktiPenerimaanPettyCash model.
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
     * Creates a new BuktiPenerimaanPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByRealisasiKasbon(): Response|string
    {
        $model = new BuktiPenerimaanPettyCash();
        $model->scenario = BuktiPenerimaanPettyCash::SCENARIO_REALISASI_KASBON;

        if ($this->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->createByCashAdvanceRealization()){
                Yii::$app->session->setFlash('success',  'BuktiPenerimaanPettyCash: ' . $model->reference_number.  ' berhasil ditambahkan.');
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
     * Updates an existing BuktiPenerimaanPettyCash model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateByRealisasiKasbon(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->scenario = BuktiPenerimaanPettyCash::SCENARIO_REALISASI_KASBON;

        if($this->request->isPost && $model->load($this->request->post()) ){

            if($model->updateByRealisasiKasbon()){
                Yii::$app->session->setFlash('info',  'BuktiPenerimaanPettyCash: ' . $model->reference_number.  ' berhasil dirubah.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger',  'BuktiPenerimaanPettyCash: ' . $model->reference_number.  ' gagal dirubah.');
        }

        return $this->render('kasbon/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BuktiPenerimaanPettyCash model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDeleteByRealisasiKasbon(int $id) : Response {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger',  'BuktiPenerimaanPettyCash: ' . $model->reference_number.  ' berhasil dihapus.');
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
        return BuktiPenerimaanPettyCash::find()->liveSearchById($q, $id);
    }

    /**
    * Finds the BuktiPenerimaanPettyCash model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return BuktiPenerimaanPettyCash the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : BuktiPenerimaanPettyCash {
        if (($model = BuktiPenerimaanPettyCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}