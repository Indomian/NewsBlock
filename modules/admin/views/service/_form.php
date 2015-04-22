<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\TagsInputAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
TagsInputAsset::register($this);
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'processor')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'item_class')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'last_call')->textInput() ?>

    <?= $form->field($model, 'tags',[
            'template' => "{label}\n<div class=\"form-input\">{input}</div>\n{hint}\n{error}"
        ])->textInput([
                'value' => join(',',ArrayHelper::htmlEncode(ArrayHelper::map($model->tagsList,'id','title'),true,Yii::$app->charset)),
            ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app/service', 'Create') : Yii::t('app/service', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<<PHP_EOT
  var tags = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
      url: '/api/tag',
      ttl: 0,
      filter: function(list) {
        return $.map(list, function(item) {
          return {title: item.title};
        });
      }
    }
  });
  tags.initialize();

  $('#service-tags').tagsinput({
    freeInput: false,
    typeaheadjs: {
        name: 'tags',
        displayKey: 'title',
        valueKey: 'title',
        source: tags.ttAdapter()
      }
  });
PHP_EOT
);