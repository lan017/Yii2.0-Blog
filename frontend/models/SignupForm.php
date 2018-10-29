<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\UserModel;

/**
 * Signup form（model 跟form的区别：表单模型和数据库模型）
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $verifyCode;

    /**
     * {@inheritdoc} 属性的验证规则
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\UserModel', 'message' => '邮箱已被注册'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['rePassword', 'required'],
            ['rePassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('common', '两次密码不一致')],
            ['verifyCode', 'captcha']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' =>'用户名',
            'email' => '邮箱',
            'password' => '密码',
            'rePassword' => '重复密码',
            'verifyCode' => '验证码'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
