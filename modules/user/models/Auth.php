<?php

namespace app\modules\user\models;

use yii\web\IdentityInterface;

class Auth implements IdentityInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get($name)
    {
        return $this->user->$name;
    }

    public function __call($method, $args)
    {
        $this->user->$method($args);
    }

    public static function findIdentity($id)
    {
        $user = User::findOne(['id' => $id]);
        return $user ? new self($user): null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getUser()
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->user->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->user->auth_key;
    }

    public function getUsername()
    {
        return$this->user->username;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}