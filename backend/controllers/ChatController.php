<?php

namespace backend\controllers;

use app\models\Message;
use Yii;
use app\models\Chat;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Chat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chat::find()->where('created_at != updated_at'),
            'sort'=> ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->request->post()) {
            $message = new Message();
            $message->chat_id = $id;
            $message->content = Yii::$app->request->post('message');
            $message->user_id = Chat::CHAT_WITH_ADMIN;
            $message->created_at = time();
            if ($message->validate()) {
                $message->save();
            } else {
                foreach ($message->errors as $errors) {
                  Yii::$app->getSession()->setFlash('error', implode('<br>', $errors));
                }
            }
        }
        $chat_model = $this->findModel($id);
        $messages = Message::find()->where(['chat_id' => $id])->orderBy('created_at')->all();
        $output = $this->render('view', [
            'model' => $chat_model,
            'messages' => $messages,
        ]);
        if ($chat_model && $chat_model->nadv_id == Chat::CHAT_WITH_ADMIN) {
            foreach ($messages as $message) {
              if ($message->user_id != Chat::CHAT_WITH_ADMIN && $message->read_at == 0) {
                $message->read_at = time();
                $message->save();
              }
            }
        }
        return $output;
    }

    public function actionHasNew()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Chat::hasNewMessagesForAdmin() ? 1 : 0;
    }


//    /**
//     * Creates a new Chat model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new Chat();
//        $model->created_at = time();
//        $model->updated_at = time();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Updates an existing Chat model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Deletes an existing Chat model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
