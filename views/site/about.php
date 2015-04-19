<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app','API Documentation');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You can get access to news list using API requests. Follow the documentation bellow
        to find out how.
    </p>

    <h2>Tags</h2>

    <p>Using tags API you can access list of available <em>tags</em>. Basically this is required to
    get full list of <em>Tags</em>.</p>
    <p>API is provided as RESTfull service so you can use standard request parameters.</p>
    <p>Data can be returned as XML or JSON based on <em>Accept</em> header in request.</p>

    <h3>Data format</h3>

    <p>Each <em>tag</em> record contains 2 fields: <b>id</b> and <b>title</b> containing identifier
    and tag name accordingly.</p>

    <h3>Access points</h3>

    <dl class="dl-horizontal">
        <dt>/api/tag</dt>
        <dd>Return list of tags with pagination service. Available parameters:
            <ul>
                <li><b>page</b> &mdash; You can set page for request, for example: <i>/api/tag?page=3</i> will return
                    3-rd page of tags list.</li>
            </ul>
        </dd>
        <dt>/api/tag/all</dt>
        <dd>Return list of all available tags without pagination.</dd>
        <dt>/api/tag/&lt;id&gt;</dt>
        <dd>Return particular record with ID = &lt;id&gt;.</dd>
    </dl>

    <h2>News</h2>

    <p>Using news API you can access news available in system. You can use API to get news binded to particular <em>tag</em>
    or in particular date period or limited amount of returned news.</p>

</div>
