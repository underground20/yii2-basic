<?php

namespace app\controllers;

use yii\web\Controller;

class ViewController extends Controller
{
    public function actionIndex()
    {
        $name = 'test';
        return $this->render('render.twig', [
            'name' => $name
        ]);
    }
}