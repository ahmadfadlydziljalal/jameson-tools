<?php

namespace app\controllers;

use app\models\Card;
use app\models\CardPersonInCharge;
use app\models\search\CardSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
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
    * Lists all Card models.
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new CardSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->pagination = [
         'pageSize' => 12
      ];

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Displays a single Card model.
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
    * Finds the Card model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Card the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel(int $id): Card
   {
      if (($model = Card::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Creates a new Card model.
    * If creation is successful, the browser will be redirected to the 'index' page.
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionCreate(): Response|string
   {
      $model = new Card();
      $model->scenario = Card::SCENARIO_CREATE_AND_UPDATE;

      if ($this->request->isPost) {
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->createWithCardBelongsType())
               return $this->redirect(['card/view', 'id' => $model->id]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('create', [
         'model' => $model,
      ]);
   }

   /**
    * Updates an existing Card model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate(int $id): Response|string
   {
      $model = $this->findModel($id);
      $model->scenario = Card::SCENARIO_CREATE_AND_UPDATE;
      $model->cardBelongsTypesForm = $oldCardBelongsTypesFormID = ArrayHelper::map(
         $model->cardBelongsTypes,
         'card_type_id',
         'card_type_id'
      );

      if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {

         $deletedCardBelongsTypeID = array_diff(
            $oldCardBelongsTypesFormID,
            $model->cardBelongsTypesForm
         );

         if ($model->updateWithCardBelongsType($deletedCardBelongsTypeID))
            return $this->redirect(['view', 'id' => $model->id]);
         
      }

      return $this->render('update', [
         'model' => $model,
      ]);
   }

   /**
    * Deletes an existing Card model.
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

      Yii::$app->session->setFlash('danger', 'Card: ' . $model->nama . ' berhasil dihapus.');
      return $this->redirect(['index']);
   }

   /**
    * @return array|string[]
    */
   public function actionDepdropFindMataUangByCardId(): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;

      if (isset($_POST['depdrop_parents'])) {

         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
            $out = Card::find()->mataUang($parents[0]);
            if (isset($out[0])) {
               return ['output' => $out, 'selected' => $out[0]];
            }
            return ['output' => $out, 'selected' => ''];
         }
      }
      return ['output' => '', 'selected' => ''];
   }


   /**
    * @return CardPersonInCharge|array
    */
   public function actionFindPicAsAttendant(): CardPersonInCharge|array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $customerId = Yii::$app->request->post('customerId');
      return CardPersonInCharge::find()->picAsAttendant($customerId);
   }
}