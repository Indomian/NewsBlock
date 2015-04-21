<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\News;

class NewsController extends ActiveController
{
    public $modelClass = 'app\models\News';

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => News::find(),
        ]);
    }
}