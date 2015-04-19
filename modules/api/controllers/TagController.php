<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Tag;

class TagController extends ActiveController
{
    public $modelClass = 'app\models\Tag';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['update']);

        return $actions;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Tag::find(),
        ]);
    }

    public function actionAll() {
        return new ActiveDataProvider([
            'query' => Tag::find(),
            'pagination' => false
        ]);
    }
}