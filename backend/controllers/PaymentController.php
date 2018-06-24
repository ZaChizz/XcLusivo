<?php

namespace backend\controllers;

use Yii;
use app\models\Pages;
use app\models\PaymentsList;
use app\models\PaymentsCountry;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Payment controller
 */
class PaymentController extends Controller
{

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PaymentsList::find(),
            'sort'=> ['defaultOrder' => ['payment_id' => SORT_ASC]]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
       $model = new PaymentsList();
       $countries = new PaymentsCountry();

       if ($model->load(Yii::$app->request->post()) && $model->save()) {
          if (Yii::$app->request->post('PaymentsCountry')) {
            foreach (Yii::$app->request->post('PaymentsCountry')['country_id'] as $country_id) {
              $pc = new PaymentsCountry();
              $pc->payment_id = $model->payment_id;
              $pc->country_id = $country_id;
              $pc->save();
            }
          }
          return $this->redirect(['index']);
       } else {
           return $this->render('create', [
              'model' => $model,
              'countries' => $countries
           ]);
       }
    }

    public function actionUpdate($id)
    {
       $model = $this->findModel($id);
       $countries = PaymentsCountry::find()->where(['payment_id' => $id])->asArray()->all();
       $tmp = [];
       foreach ($countries as $data) {
         $tmp[] = $data['country_id'];
       }
       $countries = $tmp;
       //var_dump($countries);return;
       if ($model->load(Yii::$app->request->post()) && $model->save()) {
          PaymentsCountry::deleteAll('payment_id = :payment_id', ['payment_id' => $id]);
          if (Yii::$app->request->post('PaymentsCountry')) {
            foreach (Yii::$app->request->post('PaymentsCountry')['country_id'] as $country_id) {
              $pc = new PaymentsCountry();
              $pc->payment_id = $model->payment_id;
              $pc->country_id = $country_id;
              $pc->save();
            }
          }
          return $this->redirect(['index']);
       } else {
           return $this->render('update', [
              'model' => $model,
              'countries' => $countries
           ]);
       }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PaymentsList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
