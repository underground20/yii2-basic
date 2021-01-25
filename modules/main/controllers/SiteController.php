<?php

namespace app\modules\main\controllers;

use app\modules\user\models\User;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    public function actionIndex()
    {
        $users = User::find()->all();
        return $this->render('index.twig', [
            'users' => $users
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
