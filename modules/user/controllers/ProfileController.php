<?php

namespace app\modules\user\controllers;

use app\modules\user\models\UploadForm;
use app\modules\user\models\User;
use app\modules\user\services\SubscribeService;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

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
        $model = new UploadForm();
        $user = User::findBy($name);
        $currentUser = Yii::$app->user->identity->getUser();
        $subscriptions = $this->subscribeService->getSubscriptions($user);
        $followers = $this->subscribeService->getFollowers($user);
        $countSubscriptions = $this->subscribeService->countSubscription($user);
        $countFollowers = $this->subscribeService->countFollowers($user);
        $recommended = $this->subscribeService->getRecommended($currentUser, $user);
        $isSubscribe = $this->subscribeService->isSubscribe($currentUser, $user);

        return $this->render('view.twig', [
            'user' => $user,
            'currentUser' => $currentUser,
            'subscriptions' => $subscriptions,
            'followers' => $followers,
            'countSubscriptions' => $countSubscriptions,
            'countFollowers' => $countFollowers,
            'recommended' => $recommended,
            'isSubscribe' => $isSubscribe,
            'model' => $model
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

    public function actionUploadFile()
    {
        $model = new UploadForm();
        $model->file = UploadedFile::getInstance($model, 'file');
        if (Yii::$app->request->isPost) {
            $model->upload();
        }
    }
}