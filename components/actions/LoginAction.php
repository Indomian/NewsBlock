<?php
namespace app\components\actions;

use yii\base\Action;
use app\models\LoginForm;
use Yii;

class LoginAction extends Action
{
    public function run()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        } else {
            return $this->controller->render('login', [
                    'model' => $model,
                ]);
        }
    }
}