<?php

namespace app\modules\user\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class],
            ['username', 'string', 'min' => 6, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique', 'targetClass' => User::class]
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $user = User::createBySignup(
                $this->username,
                $this->email,
                $this->password
            );
            return $user->save();
        }
        return false;
    }
}
