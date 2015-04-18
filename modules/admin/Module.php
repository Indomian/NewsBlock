<?php

namespace app\modules\admin;

use yii\base\ActionEvent;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_ACTION,function(ActionEvent $event){
                $event->action->controller->layout='admin';

            });
        // custom initialization code goes here
    }
}
