<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nonAdv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('app', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['nonAdv', 'safe'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;

            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->type = $this->nonAdv ? User::TYPE_NON_ADVERTISER : User::TYPE_ADVERTISER;
            if ($user->save()) {
                // перенесено в модель
                // $auth = Yii::$app->authManager;
                // $AdvetiserRole = $auth->getRole('Advetiser');
                // $NONAdvetiserRole = $auth->getRole('NON Advetiser');
                // if ($this->nonAdv) {
                //     $auth->assign($NONAdvetiserRole, $user->id);
                // } else {
                //     $auth->assign($AdvetiserRole, $user->id);
                // }
                return $user;
            }
        }

        return null;
    }
}
