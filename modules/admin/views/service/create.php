<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = Yii::t('app/service', 'Create Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/service', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
