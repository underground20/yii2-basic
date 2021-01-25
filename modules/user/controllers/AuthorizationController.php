<?php

namespace app\modules\user\controllers;

use app\modules\user\models\Auth;
use app\modules\user\models\LoginForm;
use app\modules\user\models\SignupForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthorizationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionSignup()
    {
        $signupForm = new SignupForm();

        if ($signupForm->load(Yii::$app->request->post()) && $user = $signupForm->save()) {
            Yii::$app->user->login(new Auth($user));
            $this->redirect('/');
            Yii::$app->session->setFlash('success', 'User registered');
        }

        return $this->render('signup', [
            'model' => $signupForm
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}