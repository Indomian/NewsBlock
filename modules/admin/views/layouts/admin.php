<?php
if(!isset($this->params['breadcrumbs']) || !is_array($this->params['breadcrumbs'])) {
    $this->params['breadcrumbs'][]=\Yii::t('app/admin', 'Admin');
} else {
    array_unshift($this->params['breadcrumbs'],['label' => \Yii::t('app/admin', 'Admin'), 'url' => ['default/index']]);
}
$this->beginContent('@app/views/layouts/main.php');
echo $content;
$this->endContent();