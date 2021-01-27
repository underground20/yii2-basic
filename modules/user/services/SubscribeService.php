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
        return $this->getUsers($ids);
    }

    public function getFollowers($currentUser)
    {
        $key = "user:{$currentUser->id}:followers";
        $ids = $this->redis->smembers($key);
        return $this->getUsers($ids);
    }

    public function countSubscription($currentUser)
    {
        return $this->redis->scard("user:{$currentUser->id}:subscriptions");
    }

    public function countFollowers($currentUser)
    {
        return $this->redis->scard("user:{$currentUser->id}:followers");
    }

    public function getRecommended($currentUser, $user)
    {
        $key1 = "user:{$currentUser->id}:subscriptions";
        $key2 = "user:{$user->id}:followers";

        $ids = $this->redis->sinter($key1, $key2);
        return $this->getUsers($ids);
    }

    public function isSubscribe($currentUser, $user)
    {
        $key = "user:{$currentUser->id}:subscriptions";
        return $this->redis->sismember($key, $user->id);
    }

    private function getUsers($ids)
    {
        return User::find()->select('id, username, nickname')
            ->where(['id' => $ids])
            ->orderBy('username')
            ->asArray()
            ->all();
    }
}