<?php

namespace app\modules\main\controllers;

use app\modules\user\models\User;
use yii\web\Controller;

class ProfileController extends Controller
{
    public function actionView($id)
    {
        $user = User::findOne(['id' => $id]);

        return $this->render('view.twig', [
            'user' => $user
        ]);
    }
}