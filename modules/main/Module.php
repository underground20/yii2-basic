<?php

namespace app\modules\main;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'app\modules\main\controllers';
    }
}