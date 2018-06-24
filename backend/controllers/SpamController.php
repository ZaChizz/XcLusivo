<?php

namespace backend\controllers;

use Yii;
use app\models\SpamReports;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpamController implements the CRUD actions for SpamReports model.
 */
class SpamController extends Controller
{
    const COOKIE_LAST_VIEW = 'spam_last_view';

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
     * Lists all SpamReports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SpamReports::find(),
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $last_view = Yii::$app->request->cookies->getValue(self::COOKIE_LAST_VIEW);

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
           'name' => self::COOKIE_LAST_VIEW,
           'value' => time()
       ]));

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'last_view' => $last_view
        ]);
    }

    /**
     * Displays a single SpamReports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SpamReports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpamReports();
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
//
//    /**
//     * Updates an existing SpamReports model.
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

    /**
     * Deletes an existing SpamReports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionHasNew()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $last_view = Yii::$app->request->cookies->getValue(self::COOKIE_LAST_VIEW);
        if (empty($last_view)) {
            return 1;
        }
        $models = SpamReports::find()->where(['>', 'created_at', $last_view])->all();
        return count($models) > 0 ? 1 : 0;
    }

    /**
     * Finds the SpamReports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpamReports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpamReports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
