<?php

namespace backend\controllers;

use Yii;
use app\models\Translation;
use app\models\TranslationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TranslationController implements the CRUD actions for Translation model.
 */
class TranslationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Translation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TranslationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Translation model.
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
     * Creates a new Translation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Translation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Translation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Translation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUpdateTrans()
    {
        $model = Translation::find()->where(['not', ['trans_text' => '']])->all();
        $langs = [];
        foreach ($model as $trans) {
            if (!isset($langs[$trans->lang_code])) {
                $langs[$trans->lang_code] = [];
            }
            if (!isset($langs[$trans->lang_code][$trans->category])) {
                $langs[$trans->lang_code][$trans->category] = [];
            }
            $langs[$trans->lang_code][$trans->category][$trans->org_text] = $trans->trans_text;
        }

        foreach ($langs as $code => $data) {
            foreach ($data as $category => $text) {
              $filename = __DIR__.'/../../frontend/messages/'.$code.'/'.$category.'.php';
              if (file_exists($filename)) {
                  $fileData = include $filename;
              } else {
                  $fileData = [];
                  if (!is_dir(__DIR__.'/../../frontend/messages/'.$code.'/')) {
                      mkdir(__DIR__.'/../../frontend/messages/'.$code.'/');
                  }
              }
              $res = array_merge($fileData, $text);
              file_put_contents($filename, '<?php return ' . var_export($res, true) . ';');
               \Yii::$app->session->setFlash('success', 'Translate for '.strtoupper($code).' updated!');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Translation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Translation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Translation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
