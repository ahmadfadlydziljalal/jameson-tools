<?php

namespace app\controllers;

use app\models\KodeVoucher;
use app\models\MutasiKasPettyCash;
use app\models\search\MutasiKasPettyCashSearch;
use app\models\TransaksiMutasiKasPettyCashLainnya;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MutasiKasPettyCashController implements the CRUD actions for MutasiKasPettyCash model.
 */
class MutasiKasPettyCashController extends Controller
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
     * Lists all MutasiKasPettyCash models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new MutasiKasPettyCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MutasiKasPettyCash model.
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
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByBuktiPenerimaanPettyCash(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->pettyCashIn();

        $model = new MutasiKasPettyCash();
        $model->scenario = MutasiKasPettyCash::SCENARIO_BUKTI_PENERIMAAN_PETTY_CASH;
        $model->kode_voucher_id = $kodeVoucher->id;

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->saveByBuktiPenerimaanPettyCash()) {
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('bukti-penerimaan/create', [
            'model' => $model,
            'kodeVoucher' => $kodeVoucher,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByBuktiPengeluaranPettyCash(): Response|string
    {

        $kodeVoucher = KodeVoucher::find()->pettyCashOut();

        $model = new MutasiKasPettyCash();
        $model->scenario = MutasiKasPettyCash::SCENARIO_BUKTI_PENGELUARAN_PETTY_CASH;
        $model->kode_voucher_id = $kodeVoucher->id;

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->saveByBuktiPengeluaranPettyCash()) {
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('bukti-pengeluaran/create', [
            'model' => $model,
            'kodeVoucher' => $kodeVoucher,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByPenerimaanLainnya(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->pettyCashIn();
        $model = new MutasiKasPettyCash([
            'kode_voucher_id' => $kodeVoucher->id,
        ]);
        $modelTransaksiLainnya = new TransaksiMutasiKasPettyCashLainnya([
            'scenario' => TransaksiMutasiKasPettyCashLainnya::SCENARIO_PENERIMAAN
        ]);

        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)){
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('penerimaan-lainnya/create', [
            'model' => $model,
            'modelTransaksiLainnya' => $modelTransaksiLainnya,
            'kodeVoucher' => $kodeVoucher,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByPengeluaranLainnya(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->pettyCashOut();
        $model = new MutasiKasPettyCash([
            'kode_voucher_id' => $kodeVoucher->id,
        ]);
        $modelTransaksiLainnya = new TransaksiMutasiKasPettyCashLainnya([
            'scenario' => TransaksiMutasiKasPettyCashLainnya::SCENARIO_PENGELUARAN
        ]);

        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)){
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('pengeluaran-lainnya/create', [
            'model' => $model,
            'modelTransaksiLainnya' => $modelTransaksiLainnya,
            'kodeVoucher' => $kodeVoucher,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByBuktiPenerimaanPettyCash($id): Response|string
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveByBuktiPenerimaanPettyCash()) {
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil di update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'MutasiKasPettyCash: ' . $model->id . ' failed di update.');
        }

        return $this->render('bukti-penerimaan/update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByBuktiPengeluaranPettyCash($id): Response|string
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveByBuktiPenerimaanPettyCash()) {
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil di update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'MutasiKasPettyCash: ' . $model->id . ' failed di update.');
        }

        return $this->render('bukti-pengeluaran/update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByPenerimaanLainnya($id): Response|string
    {
        $model = $this->findModel($id);
        $modelTransaksiLainnya = $model->transaksiMutasiKasPettyCashLainnya;
        $modelTransaksiLainnya->scenario = TransaksiMutasiKasPettyCashLainnya::SCENARIO_PENERIMAAN;

        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)){
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ' berhasil di update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'MutasiKasPettyCash: ' . $model->id . ' failed di update.');
        }

        return $this->render('penerimaan-lainnya/update', [
            'model' => $model,
            'modelTransaksiLainnya' => $modelTransaksiLainnya,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByPengeluaranLainnya($id): Response|string
    {
        $model = $this->findModel($id);
        $modelTransaksiLainnya = $model->transaksiMutasiKasPettyCashLainnya;
        $modelTransaksiLainnya->scenario = TransaksiMutasiKasPettyCashLainnya::SCENARIO_PENGELUARAN;

        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)){
                Yii::$app->session->setFlash('success', 'MutasiKasPettyCash: ' . $model->id . ', pengeluaran lainnya berhasil di update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'MutasiKasPettyCash: ' . $model->id . ', pengeluaran lainnya failed di update.');
        }

        return $this->render('pengeluaran-lainnya/update', [
            'model' => $model,
            'modelTransaksiLainnya' => $modelTransaksiLainnya,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws InvalidConfigException
     */
    public function actionExportToPdf($id): string
    {
        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('_pdf', [
            'model' => $this->findModel($id),
        ]);
        return $pdf->render();
    }

    /**
     * Updates an existing MutasiKasPettyCash model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'MutasiKasPettyCash: ' . $model->nomor_voucher . ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MutasiKasPettyCash model.
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

        Yii::$app->session->setFlash('danger', 'MutasiKasPettyCash: ' . $model->nomor_voucher . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionFindById($q = null, $id = null): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return MutasiKasPettyCash::find()->liveSearchById($q, $id);
    }

    /**
     * Finds the MutasiKasPettyCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MutasiKasPettyCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): MutasiKasPettyCash
    {
        if (($model = MutasiKasPettyCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}