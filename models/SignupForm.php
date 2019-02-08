<?php
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 27.10.17
 * Time: 15:58
 */

namespace app\models;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Полбзователь с таким именем уже существует!'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой email уже существует!'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }

    public function signup()
    {

        if (!$this->validate()) { // Если валидация вернула false то возвращаем null
            return null;
        }
        $user = new User(); // Используем AcriveRecord User
        $user->username = $this->username; // Определяем свойства объекта
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = time();
        return $user->save() ? $user : null; // Сохраняем свойства в таблицу(метод ActivityRecord) user если переменная не равна null
    }
}