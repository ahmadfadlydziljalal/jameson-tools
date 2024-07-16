<?php

namespace app\controllers;

use Yii;
use app\models\BuktiPengeluaranBukuBank;
use app\models\search\BuktiPengeluaranBukuBankSearch;
use Throwable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\web\Response;

/**
* BuktiPengeluaranBukuBankController implements the CRUD actions for BuktiPengeluaranBukuBank model.
*/
class BuktiPengeluaranBukuBankController extends Controller
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
    * Lists all BuktiPengeluaranBukuBank models.
    * @return string
    */
    public function actionIndex() : string {
        $searchModel = new BuktiPengeluaranBukuBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single BuktiPengeluaranBukuBank model.
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
     * Creates a new BuktiPengeluaranBukuBank model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreateByCashAdvance(): Response|string
    {
        $model = new BuktiPengeluaranBukuBank();
        $model->scenario = BuktiPengeluaranBukuBank::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON;

        if ($this->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->saveForCashAdvances()){
                Yii::$app->session->setFlash('success',  'BuktiPengeluaranBukuBank: ' . $model->reference_number.  ' berhasil ditambahkan.');
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
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByCashAdvance(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->scenario = BuktiPengeluaranBukuBank::SCENARIO_PENGELUARAN_BY_CASH_ADVANCE_OR_KASBON;

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->saveForCashAdvances()){
                Yii::$app->session->setFlash('info',  'BuktiPengeluaranBukuBank: ' . $model->reference_number.  ' berhasil dirubah.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'Failed');
        }

        return $this->render('kasbon/update', [
            'model' => $model,
        ]);
    }

    public function actionDeleteByCashAdvance(int $id): Response|string{
        $model = $this->findModel($id);
        if($model->deleteByCashAdvance()){
            Yii::$app->session->setFlash('success',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' berhasil dihapus.');
        }else{
            Yii::$app->session->setFlash('danger',  'BuktiPengeluaranPettyCash: ' . $model->reference_number.  ' gagal dihapus!');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return Response|string
     */
    public function actionCreateByBill(): Response|string
    {
        $model = new BuktiPengeluaranBukuBank();
        $model->scenario = BuktiPengeluaranBukuBank::SCENARIO_PENGELUARAN_BY_BILL;

        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->saveForBills()){
                Yii::$app->session->setFlash('success',  'BuktiPengeluaranBukuBank: ' . $model->reference_number.  ' berhasil ditambahkan.');
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
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateByBill(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->scenario = BuktiPengeluaranBukuBank::SCENARIO_PENGELUARAN_BY_BILL;

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->saveForBills()){
                Yii::$app->session->setFlash('info',  'BuktiPengeluaranBukuBank: ' . $model->reference_number.  ' berhasil dirubah.');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('danger', 'Failed');
        }

        return $this->render('bill/update', [
            'model' => $model,
        ]);
    }

    /**
    * Deletes an existing BuktiPengeluaranBukuBank model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return Response
    * @throws NotFoundHttpException if the model cannot be found
    * @throws StaleObjectException
    * @throws Throwable
    */
    public function actionDelete(int $id) : Response {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger',  'BuktiPengeluaranBukuBank: ' . $model->reference_number.  ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
    * Finds the BuktiPengeluaranBukuBank model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return BuktiPengeluaranBukuBank the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : BuktiPengeluaranBukuBank {
        if (($model = BuktiPengeluaranBukuBank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}