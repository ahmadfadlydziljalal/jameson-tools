<?php

namespace app\controllers;

use app\models\Rekening;
use app\models\search\RekeningSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * RekeningController implements the CRUD actions for Rekening model.
 */
class RekeningController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Rekening models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new RekeningSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rekening model.
     * @param integer $id
     * @return string
     * @throws HttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rekening model.
     * @return string|Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Rekening();

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Rekening: ' . Html::a($model->atas_nama, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', " Rekening is failed to insert.: ");
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Rekening model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Rekening: ' . Html::a($model->atas_nama, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', " Rekening is failed to insert.: ");
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Delete an existing Rekening model.
     * @param integer $id
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', " Rekening : " . $model->atas_nama . " berhasil dihapus.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Rekening model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rekening the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Rekening
    {
        if (($model = Rekening::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}