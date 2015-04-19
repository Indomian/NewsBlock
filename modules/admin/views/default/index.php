<?php
use yii\bootstrap\Nav;
?>
<div class="admin-default-index">
    <h1><?= \Yii::t('app/admin', 'Admin')?></h1>
    <p>
        This is basic admin panel for managing project specific data.
    </p>
    <?php
    echo Nav::widget([
            'items' => [
                ['label' => Yii::t('app/admin','Manage news'), 'url' => ['/admin/news/index']],
                ['label' => Yii::t('app/admin','Manage tags'), 'url' => ['/admin/tag/index']],
                ['label' => Yii::t('app/admin','Manage services'), 'url' => ['/admin/service/index']]
            ]
        ]);
    ?>
</div>
