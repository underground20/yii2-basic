<?php

namespace app\modules\user;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'app\modules\user\controllers';
    }
}