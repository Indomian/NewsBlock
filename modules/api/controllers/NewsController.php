<?php
namespace app\modules\api\controllers;

use app\models\NewsFilter;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\News;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;

class NewsController extends ActiveController
{
    public $modelClass = 'app\models\News';

    public function actions()
    {
        return array();
    }

    public function actionIndex()
    {
        $obFilter=new NewsFilter();
        $obFilter->load(\Yii::$app->request->get(),'');

        if(\Yii::$app->request->getQueryParam('expand',false)) {
            $query=News::find()->joinWith('tags');
        } else {
            $query=News::find();
        }

        if($obFilter->validate()) {
            $obFilter->addFilter($query);
        }

        $pagination=new Pagination();
        $pagination->pageSize=intval(\Yii::$app->request->get('count',10));

        return new ActiveDataProvider([
            'query' => $query,
            'pagination'=>$pagination
        ]);
    }

    public function actionView($id) {
        if($model = News::findOne($id)) {
            $model->setScenario(News::SCENARIO_REST_FULL);
            return $model;
        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
}