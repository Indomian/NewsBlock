<?php
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\News;
use app\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'News';
?>
<div class="site-index">
    <?php
    echo ListView::widget(
        [
            'dataProvider' => new ActiveDataProvider([
                'query' => News::find()->with('tags'),
                'pagination' => [
                    'pageSize' => 20
                ]
            ]),
            'itemView' => function (News $model, $key, $index, $widget) {
                echo Html::beginTag(
                    'div',
                    [
                        'class' => 'panel panel-default'
                    ]
                );
                echo Html::tag(
                    'div',
                    $model->title . ' ' . $model->date_create,
                    [
                        'class' => 'panel-heading'
                    ]
                );
                echo Html::tag(
                    'div',
                    nl2br(Html::encode($model->content)),
                    [
                        'class' => 'panel-body'
                    ]
                );
                echo Html::tag(
                    'div',
                    ListView::widget(
                        [
                            'dataProvider' => new ArrayDataProvider([
                                'allModels' => $model->tags,
                                'pagination' => false
                            ]),
                            'layout' => '{items}',
                            'itemOptions' => array(
                                'tag' => false,
                            ),
                            'separator' => ', ',
                            'emptyText' => '',
                            'itemView' => function (Tag $model, $key, $index, $widget) {
                                return Html::a($model->title, Url::to(['site/index', 'tag' => $model->id]));
                            }
                        ]
                    ),
                    [
                        'class' => 'panel-footer'
                    ]
                );
                echo Html::endTag('div');
            }
        ]
    );
    ?>
</div>
