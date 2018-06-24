<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 28.04.2016
 * Time: 13:39
 */

namespace frontend\widgets;
use frontend\models\AdvertiserSearch;
use frontend\models\Services;
use frontend\models\Colors;
use frontend\models\Nationality;
use frontend\models\Bra;
use frontend\models\Sex;


class PreciseSearch extends \yii\bootstrap\Widget
{
    public $model=0;

    public function init(){
        parent::init();

    }

    public function run()
    {
        $isFilled = false;
        if(!$this->model)
        {
            $this->model = new AdvertiserSearch();
            $this->model->services = $this->refactorArrayModel(Services::find()->asArray()->all());
            $this->model->receiving();
            $this->model->offering();
            $this->model->color_hair = Colors::find()->where(['type' => Colors::TYPE_HAIR])->asArray()->all();
            $this->model->color_eye = Colors::find()->where(['type' => Colors::TYPE_EYE])->asArray()->all();
            $this->model->color_skin = Colors::find()->where(['type' => Colors::TYPE_SKIN])->asArray()->all();
            $this->model->nationality_data = $this->refactorArrayModel(Nationality::find()->asArray()->all());
            $this->model->bra_groups = Bra::getGroups();
        }
        else
        {
            $isFilled = true;
            $this->model->services = $this->refactorArrayModel(Services::find()->asArray()->all());
            $this->model->receiving_as_id = $this->model->receiving;
            $this->model->offering_as_id = $this->model->offering;
            $this->model->color_hair = Colors::find()->where(['type' => Colors::TYPE_HAIR])->asArray()->all();
            $this->model->color_eye = Colors::find()->where(['type' => Colors::TYPE_EYE])->asArray()->all();
            $this->model->color_skin = Colors::find()->where(['type' => Colors::TYPE_SKIN])->asArray()->all();
            $this->model->nationality_data = $this->refactorArrayModel(Nationality::find()->asArray()->all());
            $this->model->bra_groups = Bra::getGroups();
        }

        return $this->render('PreciseSearch/index', ['model'=>$this->model, 'sex' => Sex::find()->all(), 'isFilled' => $isFilled]);

    }

    protected static function refactorArrayModel($model)
    {
        $rez = array();
        foreach($model as $value)
        {
            $rez[$value['id']] = \Yii::t('app', $value['title']);
        }
        return $rez;
    }
}
?>
