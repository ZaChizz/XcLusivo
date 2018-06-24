<?php

namespace backend\controllers;

use backend\models\Page_Contents;
use Yii;
use backend\models\Pages;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
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
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pages::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $contents = array();
        $contestsModels = Page_Contents::findAll([
            'page_id' => $id,
        ]);

        foreach($contestsModels as $data){
            $contents[$data->lang] = $data;
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'contents' => $contents,
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();
        $model->created_at = time();
        $model->updated_at = time();
        $contents = array();
        $first = true;

        foreach($model->langs as $lang){
            $contents[$lang] = [
                'status' => $first ? 1 : 0 ,
                'name' => Pages::getLangName($lang) . ' title',
                'content' => Pages::getLangName($lang) . ' content',
            ];
            $first = false;
        }

        if ($model->load(Yii::$app->request->post())&& $model->save()) {
            $conts = Yii::$app->request->post('Contents');
            if(!is_null($conts)) {
                foreach ($conts as $lang => $data) {
                    $this->saveContent($lang, $data, $model->id);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'contents' => $contents,
            ]);
        }
    }

    public function saveContent($lang, $data, $id = 0){

        $content = Page_Contents::findOne([
            'page_id' => $id,
            'lang' => $lang,
        ]);

        if(is_null($content)){
            $content = new Page_Contents();
            $content->created_at = time();
            $content->page_id = $id;
            $content->lang = $lang;
        }

        $content->load($data);
        $content->updated_at = time();
        $content->status = $data['status'];
        $content->name = $data['name'];
        $content->content = $data['content'];
        $content->save();
        return $content;
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();
        $contents = array();
        $first = true;
        $contestsModels = Page_Contents::findAll([
            'page_id' => $id,
        ]);

        foreach($contestsModels as $data){
            $contents[$data->lang] = [
                'status' => $data->status,
                'name' => $data->name,
                'content' => $data->content,
            ];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $conts = Yii::$app->request->post('Contents');
            if(!is_null($conts)) {
                foreach ($conts as $lang => $data) {
                    $this->saveContent($lang, $data, $model->id);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'contents' => $contents,
            ]);
        }
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Page_Contents::deleteAll('page_id = :page_id', [':page_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
