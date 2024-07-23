<?php

namespace app\controllers;

use app\models\PettyCash;
use app\models\search\PettyCashSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PettyCashController implements the CRUD actions for PettyCash model.
 */
class PettyCashController extends Controller
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
     * Lists all PettyCash models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PettyCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PettyCash model.
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
     * Creates a new PettyCash model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     */
    public function actionCreate(): Response|string
    {
        $model = new PettyCash();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'PettyCash: ' . $model->id . ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PettyCash model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'PettyCash: ' . $model->id . ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PettyCash model.
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

        Yii::$app->session->setFlash('danger', 'PettyCash: ' . $model->id . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PettyCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PettyCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): PettyCash
    {
        if (($model = PettyCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}