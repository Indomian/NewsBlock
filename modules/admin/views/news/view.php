<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use app\models\Tag;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/news', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/news', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'date_create',
            'content:ntext',
            'url:ntext',
            'tags'=>array(
                'attribute' => 'tags',
                'format' => 'html',
                'value' => ListView::widget(
                    [
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $model->tags,
                            'pagination' => false
                        ]),
                        'separator' => ', ',
                        'layout' => '{items}',
                        'itemOptions' => array(
                            'tag' => false,
                        ),
                        'emptyText' => '',
                        'itemView' => function (Tag $model, $key, $index, $widget) {
                            return Html::a($model->title, Url::to(['/admin/tag/view', 'id' => $model->id]));
                        }
                    ]
                ),
            )
        ],
    ]) ?>

</div>
