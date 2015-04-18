<?php
namespace app\modules\admin\components;

use yii\web\Controller;
use yii\filters\AccessControl;

abstract class AdminController extends Controller {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }
}