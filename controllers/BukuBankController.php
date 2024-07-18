<?php

namespace app\controllers;

use app\models\BukuBank;
use app\models\KodeVoucher;
use app\models\search\BukuBankSearch;
use app\models\TransaksiBukuBankLainnya;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * BukuBankController implements the CRUD actions for BukuBank model.
 */
class BukuBankController extends Controller
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
     * Lists all BukuBank models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new BukuBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BukuBank model.
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
     * Creates a new BukuBank model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new BukuBank();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateByBuktiPenerimaanBukuBank(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->bukuBankIn();

        $model = new BukuBank();
        $model->scenario = BukuBank::SCENARIO_BUKTI_PENERIMAAN_BUKU_BANK;
        $model->kode_voucher_id = $kodeVoucher->id;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
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
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdateByBuktiPenerimaanBukuBank(int $id): string| Response{
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->save()){
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil di-update.');
                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('danger', 'BukuBank: ' . $model->nomor_voucher . ' gagal di-update.');
        }

        return $this->render('bukti-penerimaan/update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByBuktiPengeluaranBukuBank(): Response|string
    {

        $kodeVoucher = KodeVoucher::find()->bukuBankIn();

        $model = new BukuBank();
        $model->scenario = BukuBank::SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK;
        $model->kode_voucher_id = $kodeVoucher->id;

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->saveWithoutMutasiKasPettyCash()) {
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
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
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateByBuktiPengeluaranBukuBank(int $id): string| Response{
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->saveWithoutMutasiKasPettyCash()){
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil di-update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'BukuBank: ' . $model->nomor_voucher . ' gagal di-update.');
        }

        return $this->render('bukti-pengeluaran/update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByBuktiPengeluaranBukuBankToMutasiKas(): Response|string
    {

        $kodeVoucher = KodeVoucher::find()->bukuBankIn();

        $model = new BukuBank();
        $model->scenario = BukuBank::SCENARIO_BUKTI_PENGELUARAN_BUKU_BANK;
        $model->kode_voucher_id = $kodeVoucher->id;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveWithMutasiKasPettyCash()) {
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('bukti-pengeluaran-to-mutasi-kas/create', [
            'model' => $model,
            'kodeVoucher' => $kodeVoucher,
        ]);
    }

    /**
     * @param $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByBuktiPengeluaranBukuBankToMutasiKas($id): Response|string
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->saveWithMutasiKasPettyCash()) {
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil di-update.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'BukuBank: ' . $model->nomor_voucher . ' gagal di-update.');
        }

        return $this->render('bukti-pengeluaran-to-mutasi-kas/update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByPenerimaanLainnya(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->bukuBankIn();
        $model = new BukuBank([
            'kode_voucher_id' => $kodeVoucher->id,
        ]);
        $modelTransaksiLainnya = new TransaksiBukuBankLainnya([
            'scenario' => TransaksiBukuBankLainnya::SCENARIO_PENERIMAAN
        ]);

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)) {
                Yii::$app->session->setFlash('success', 'Buku Bank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
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
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByPenerimaanLainnya(int $id): Response|string{

        $model = $this->findModel($id);
        $modelTransaksiLainnya = $model->transaksiBukuBankLainnya;

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)) {
                Yii::$app->session->setFlash('success', 'Buku Bank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'Buku Bank: ' . $model->nomor_voucher . ' gagal ditambahkan.');
        }

        return $this->render('penerimaan-lainnya/update',[
            'kodeVoucher' => $model->kodeVoucher,
            'model' => $model,
            'modelTransaksiLainnya' => $model->transaksiBukuBankLainnya,

        ]);
    }


    /**
     * Creates a new MutasiKasPettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByPengeluaranLainnya(): Response|string
    {
        $kodeVoucher = KodeVoucher::find()->bukuBankIn();
        $model = new BukuBank([
            'kode_voucher_id' => $kodeVoucher->id,
        ]);
        $modelTransaksiLainnya = new TransaksiBukuBankLainnya([
            'scenario' => TransaksiBukuBankLainnya::SCENARIO_PENGELUARAN
        ]);

        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $modelTransaksiLainnya->load(Yii::$app->request->post()) && $model->saveTransaksiLainnya($modelTransaksiLainnya)){
                Yii::$app->session->setFlash('success', 'BukuBank: ' . $model->nomor_voucher . ' berhasil ditambahkan.');
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
     * Updates an existing BukuBank model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'BukuBank: ' . $model->nomor_voucher . ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BukuBank model.
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

        Yii::$app->session->setFlash('danger', 'BukuBank: ' . $model->nomor_voucher . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the BukuBank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BukuBank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): BukuBank
    {
        if (($model = BukuBank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}