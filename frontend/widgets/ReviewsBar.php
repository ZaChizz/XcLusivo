<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 09.06.2016
 * Time: 1:36
 */

namespace frontend\widgets;

use Yii;
use frontend\models\Reviews;
use yii\helpers\Html;  //Html::a('',['site/advertiser', 'id'=>$model->id],['class'=>'cover-link'])
use yii\web\NotFoundHttpException;
use common\models\User;


class ReviewsBar extends \yii\bootstrap\Widget
{
    public $id=0;
    public $reply = true;
    public $action = 'non-advertiser';

    private $models = array();
    private $template = array();


    public function init(){

        parent::init();

    }

    public function run(){

        $this->models['from'] = Reviews::loadModelFrom($this->id);
        $this->models['to'] = Reviews::loadModelTo($this->id);
        $this->template['from'] = array();
        $this->template['to'] = array();

        if ($this->getTemplate()) {
            return $this->render(
              'ReviewsBar/index',
              [
                'template' => $this->template,
                'reply' => $this->reply,
                'username' => User::findOne($this->id)->username
              ]);
        } else {
            throw new NotFoundHttpException('Reviews bar not work');
        }
    }

    protected function getTemplate()
    {
        if(!empty($this->models['from']))
        {
            $model = $this->models['from'][0];
            if(isset($model->idto->params))//if Advertiser profile
            {

                foreach($this->models['from'] as $model)
                {
                    $rez['href'] = Html::a($model->idto->username.', '.$model->idto->params->age, ['site/advertiser', 'id'=>$model->idto->params->id]);
                    $rez['title'] = Html::encode($model->title);
                    $rez['online'] = $model->idto->params->online?'':'offline';
                    $rez['reply'] = $this->getReply($model,false);
                    $this->template['from'][] = $rez;
               }
            }
            else{

                foreach($this->models['from'] as $model)
                {
                    $rez['href'] = Html::a($model->idto->username, ['advertiser/non-advertiser-profile', 'id'=>$model->id_to]);
                    $rez['title'] = Html::encode($model->title);
                    $rez['online'] = '';
                    $rez['reply'] = $this->getReply($model,false);
                    $this->template['from'][] = $rez;
                }

            }


        }

        if($this->models['to'])
        {
            $model = $this->models['to'][0];
            if(isset($model->idfrom->params))//if Advertiser profile
            {
                foreach($this->models['to'] as $model)
                {
                    $rez['href'] = Html::a($model->idfrom->username.', '.$model->idfrom->params->age,['site/advertiser', 'id'=>$model->idfrom->params->id]);
                    $rez['title'] = Html::encode($model->title);
                    $rez['online'] = $model->idfrom->params->online?'':'offline';
                    $rez['reply'] = $this->getReply($model,$this->reply);
                    $this->template['to'][] = $rez;
                }
            }
            else{

                foreach($this->models['to'] as $model)
                {
                    $rez['href'] = Html::a($model->idfrom->username, ['advertiser/non-advertiser-profile', 'id'=>$model->id_from]);
                    $rez['title'] = Html::encode($model->title);
                    $rez['online'] = '';
                    $rez['reply'] = $this->getReply($model,$this->reply);
                    $this->template['to'][] = $rez;
                }
            }
        }

        return true;

    }

    protected function getReply($model,$flag)
    {
        $rez = array();
        $return = array();
        if(!empty($model->replys))
        {
            $cur = $model->replys[0];
            if(isset($cur->params))//if Advertiser profile
            {
                foreach($model->replys as $reply)
                {
                    $rez['href'] = Html::a($reply->idfrom->username.', '.$reply->idfrom->params->age, ['site/advertiser', 'id'=>$reply->idfrom->params->id]);
                    $rez['title'] = Html::encode($reply->title);
                    $rez['online'] = $reply->idfrom->params->online?'':'offline';
                    $rez['reply'] = false;
                    $return[] = $rez;
                }
            }
            else
            {
                foreach($model->replys as $reply)
                {
                    $rez['href'] = Yii::t('app', '{username} replied:', ['username' => $reply->idfrom->username]);
                    $rez['title'] = Html::encode($reply->title);
                    $rez['online'] = '';
                    $rez['reply'] = false;
                    $return[] = $rez;
                }
            }
        }
        else
        {
            if($flag)
            {
                $rez['reply'] = Html::a(Yii::t('app','Reply'), [$this->action.'/reply', 'id'=>$model->id],['class'=>'fancy fancybox.ajax']);
                $return[] = $rez;
            }

        }

        return $return;
    }
}
