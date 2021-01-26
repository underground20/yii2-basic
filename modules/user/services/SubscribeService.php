<?php

namespace app\modules\user\services;

use app\modules\user\models\User;
use Yii;
use yii\redis\Connection;

class SubscribeService
{
    private $redis;

    public function __construct()
    {
        /* @var $redis Connection */
        $this->redis = Yii::$app->redis;
    }

    public function followUser($currentUser, User $user)
    {
        $this->redis->sadd("user:{$currentUser->id}:subscriptions", $user->id);
        $this->redis->sadd("user:{$user->id}:followers", $currentUser->id);
    }

    public function unFollowUser($currentUser, User $user)
    {
        $this->redis->srem("user:{$currentUser->id}:subscriptions", $user->id);
        $this->redis->srem("user:{$user->id}:followers", $currentUser->id);
    }

    public function getSubscriptions($currentUser)
    {
        $key = "user:{$currentUser->id}:subscriptions";
        $ids = $this->redis->smembers($key);

        return User::find()->select('id, username, nickname')
            ->where(['id' => $ids])
            ->orderBy('username')
            ->asArray()
            ->all();
    }

    public function getFollowers($currentUser)
    {
        $key = "user:{$currentUser->id}:followers";
        $ids = $this->redis->smembers($key);

        return User::find()->select('id, username, nickname')
            ->where(['id' => $ids])
            ->orderBy('username')
            ->asArray()
            ->all();
    }
}