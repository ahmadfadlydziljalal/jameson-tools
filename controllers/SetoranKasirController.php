<?php

namespace app\controllers;

use app\models\Invoice;
use Exception;
use Yii;
use app\models\SetoranKasir;
use app\models\search\SetoranKasirSearch;
use app\models\SetoranKasirDetail;
use app\models\Tabular;
use yii\helpers\Html;

use Throwable;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
* SetoranKasirController implements the CRUD actions for SetoranKasir model.
*/
class SetoranKasirController extends Controller
{
    /**
    * @inheritdoc
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
    * Lists all SetoranKasir models.
    * @return string
    */
    public function actionIndex() : string
    {
        $searchModel = new SetoranKasirSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single SetoranKasir model.
    * @param integer $id
    * @return string
    * @throws HttpException
    */
    public function actionView(int $id) : string{
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
    * Creates a new SetoranKasir model.
    * @return string|Response
    */
    public function actionCreate(): Response|string
    {
        $request = Yii::$app->request;
        $model = new SetoranKasir();
        $modelsDetail = [ new SetoranKasirDetail() ];

        if($model->load($request->post())){

            $modelsDetail = Tabular::createMultiple(SetoranKasirDetail::class);
            Tabular::loadMultiple($modelsDetail, $request->post());

            //validate models
            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if($isValid){

                $transaction = SetoranKasir::getDb()->beginTransaction();

                try{

                    if ($flag = $model->save(false)) {
                        foreach ($modelsDetail as $detail) :
                            $detail->setoran_kasir_id = $model->id;
                            if (!($flag = $detail->save(false))) {break;}
                        endforeach;
                    }

                    if ($flag) {
                        $transaction->commit();
                        $status = ['code' => 1,'message' => 'Commit'];
                    } else {
                        $transaction->rollBack();
                        $status = ['code' => 0,'message' => 'Roll Back'];
                    }

                }catch (Exception $e){
                    $transaction->rollBack();
                    $status = ['code' => 0,'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if($status['code']){
                    Yii::$app->session->setFlash('success','SetoranKasir: ' . Html::a($model->id,  ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger'," SetoranKasir is failed to insert. Info: ". $status['message']);
            }
        }

        return $this->render( 'create', [
            'model' => $model,
            'modelsDetail' => empty($modelsDetail) ? [ new SetoranKasirDetail() ] : $modelsDetail,
        ]);

    }

    /**
    * Updates an existing SetoranKasir model.
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
        $modelsDetail = !empty($model->setoranKasirDetails) ? $model->setoranKasirDetails : [new SetoranKasirDetail()];

        if($model->load($request->post())){

            $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
            $modelsDetail = Tabular::createMultiple(SetoranKasirDetail::class, $modelsDetail);

            Tabular::loadMultiple($modelsDetail, $request->post());
            $deletedDetailsID = array_diff($oldDetailsID,array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

            $isValid = $model->validate();
            $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

            if($isValid){
                $transaction = SetoranKasir::getDb()->beginTransaction();
                try{
                    if ($flag = $model->save(false)) {

                        if (!empty($deletedDetailsID)) {
                            SetoranKasirDetail::deleteAll(['id' => $deletedDetailsID]);
                        }

                        foreach ($modelsDetail as $detail) :
                            $detail->setoran_kasir_id = $model->id;
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
                        $status = ['code' => 0,'message' => 'Roll Back'];
                    }
                }catch (Exception $e){
                    $transaction->rollBack();
                    $status = ['code' => 0,'message' => 'Roll Back ' . $e->getMessage(),];
                }

                if($status['code']){
                    Yii::$app->session->setFlash('info',"SetoranKasir: ".Html::a($model->id, ['view', 'id' => $model->id]) . " berhasil di update.");
                    return $this->redirect(['index']);
                }

                Yii::$app->session->setFlash('danger'," SetoranKasir is failed to updated. Info: ". $status['message']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDetail' => $modelsDetail
        ]);
    }

    /**
    * Delete an existing SetoranKasir model.
    * @param integer $id
    * @return Response
    * @throws HttpException
    * @throws NotFoundHttpException
    * @throws Throwable
    * @throws StaleObjectException
    */
    public function actionDelete(int $id) : Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', " SetoranKasir : " . $model->id. " berhasil dihapus.");
        return $this->redirect(['index']);
    }

    public function actionFindNotInBuktiPenerimaanBukuBankYet($q = null, array $id = []){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return SetoranKasir::find()->notInBuktiPenerimaanBukuBankYet($q, $id);
    }

    /**
    * Finds the SetoranKasir model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return SetoranKasir the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : SetoranKasir    {
      if (($model = SetoranKasir::findOne($id)) !== null) {
            return $model;
      } else {
        throw new NotFoundHttpException('The requested page does not exist.');
      }
    }
}