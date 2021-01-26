<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use app\modules\user\services\SubscribeService;
use Yii;
use yii\web\Controller;

class ProfileController extends Controller
{
    private $subscribeService;

    public function __construct($id, $module, SubscribeService $subscribeService, $config = [])
    {
        $this->subscribeService = $subscribeService;
        parent::__construct($id, $module, $config);
    }

    public function actionView($name)
    {
        $user = User::findBy($name);
        $subscriptions = $this->subscribeService->getSubscriptions($user);
        $followers = $this->subscribeService->getFollowers($user);

        return $this->render('view.twig', [
            'user' => $user,
            'subscriptions' => $subscriptions,
            'followers' => $followers
        ]);
    }

    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/authorization/login');
        }
        /* @var $currentUser \app\modules\user\models\User */
        $currentUser = Yii::$app->user->identity->getUser();
        $user = User::findBy($id);
        $this->subscribeService->followUser($currentUser, $user);
        return $this->redirect(['/user/profile/view', 'name' => $currentUser->getNickName()]);
    }

    public function actionUnSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/authorization/login');
        }
        /* @var $currentUser \app\modules\user\models\User */
        $currentUser = Yii::$app->user->identity->getUser();
        $user = User::findBy($id);
        $this->subscribeService->unFollowUser($currentUser, $user);

        return $this->redirect(['/user/profile/view', 'name' => $currentUser->getNickName()]);

    }
}