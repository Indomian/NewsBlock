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

    <section>
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
            <dt><a href="/api/tag" target="_blank">/api/tag</a></dt>
            <dd>Return list of tags with pagination service. Available parameters:
                <ul>
                    <li><b>page</b> &mdash; You can set page for request, for example:
                        <a href="/api/tag?page=3" target="_blank">/api/tag?page=3</a> will return
                        3-rd page of tags list.</li>
                </ul>
            </dd>
            <dt><a href="/api/tag/all" target="_blank">/api/tag/all</a></dt>
            <dd>Return list of all available tags without pagination.</dd>
            <dt><a href="/api/tag/1" target="_blank">/api/tag/&lt;id&gt;</a></dt>
            <dd>Return particular record with ID = &lt;id&gt;.</dd>
        </dl>
    </section>

    <section>
        <h2>News</h2>

        <p>Using news API you can access news available in system. You can use API to get news binded to particular <em>tag</em>
        or in particular date period or limited amount of returned news.</p>

        <h3>Data format</h3>

        <p>Each <em>news</em> record contains 6 base fields: <b>id</b>,
            <b>title</b>, <b>date_create</b>, <b>url</b>, <b>hash</b> and <b>preview</b>.
        </p>
        <p>Also using <em>extend</em> field in request you can receive 2 additional fields: <b>content</b>, <b>tags</b></p>

        <h3>Access points</h3>

        <dl class="dl-horizontal">
            <dt><a href="/api/news" target="_blank">/api/news</a></dt>
            <dd>Return list of tags with pagination service. Available parameters:
                <ul>
                    <li><b>page</b> &mdash; You can set page for request, for example:<ul><li>
                        <a href="/api/news?page=2">/api/news?page=2</a> will return
                        2-nd page of tags list.</li></ul></li>
                    <li><b>tags</b> &mdash; You can set which tags to use to filter result. You can
                    set this parameter as array of <em>tag</em> IDs or as as string divided with comma ",".
                    Also you can use string values of tags. For example:
                    <ul>
                        <li><a href="/api/news?tags=4" target="_blank">/api/news?tags=4</a> will return all news
                        having tag with ID=4</li>
                        <li><a href="/api/news?tags=4,5" target="_blank">/api/news?tags=4,5</a> will return all news
                            having tags with ID=4 OR ID=5</li>
                        <li><a href="/api/news?tags[]=4&tags[]=5" target="_blank">/api/news?tags[]=4&tags[]=5</a> same as above</li>
                    </ul></li>
                    <li><b>date_from</b> and <b>date_to</b> &mdash; You can set date filter for returned records. Value format is: <b>Y-m-d H:i:s</b>.
                    You should set full time format. You can use one parameter or both in one time. For example:<ul>
                            <li><a href="/api/news?date_to=2015-04-20%2000:00:00" target="_blank">/api/news?date_to=2015-04-20%2000:00:00</a> will
                                return all news before 2015-04-20 00:00:00.</li>
                            <li><a href="/api/news?date_from=2015-04-20%2000:00:00" target="_blank">/api/news?date_from=2015-04-20%2000:00:00</a> will
                                return all news after 2015-04-20 00:00:00.</li>
                        </ul>
                    </li>
                    <li><b>count</b> &mdash; You can limit answer page size. For example:<ul>
                            <li><a href="/api/news?count=1" target="_blank">/api/news?count=1</a> will return only one record.</li>
                    </ul></li>
                    <li><b>expand</b> &mdash; Allow you to get additional fields. Available values: <b>tags</b> and <b>content</b>. To get both fields
                        use comma "," to separate then. For example:<ul>
                            <li><a href="/api/news?expand=tags" target="_blank">/api/news?expand=tags</a> will return records and their tags.</li>
                            <li><a href="/api/news?expand=tags,content" target="_blank">/api/news?expand=tags,content</a> will return records, their tags and full content.</li>
                        </ul></li>
                </ul>
            </dd>
            <dt><a href="/api/news/2" target="_blank">/api/news/&lt;id&gt;</a></dt>
            <dd>Return particular record with ID = &lt;id&gt;.</dd>
        </dl>
    </section>
    <section>
        <h2>Database scheme</h2>
        <img src="/db.jpg" alt="DB"/>
    </section>
</div>
