<?php

namespace app\modules\main\controllers;

use app\modules\user\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function actionView($name)
    {
        $user = $this->findUser(['nickname' => $name]);

        return $this->render('view.twig', [
            'user' => $user
        ]);
    }

    private function findUser($name)
    {
        $user = User::find()->where(['nickname' => $name])->orWhere(['id' => $name])->one();
        if ($user) {
            return $user;
        }
        throw new NotFoundHttpException();
    }
}