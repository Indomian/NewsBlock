<?php

namespace app\models;

use Yii;
use yii\web\Linkable;
use yii\web\Link;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $title
 *
 * @property News2tags[] $news2tags
 * @property News[] $news
 */
class Tag extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/tag', 'ID'),
            'title' => Yii::t('app/tag', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews2tags()
    {
        return $this->hasMany(News2tags::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('{{%news2tags}}', ['tag_id' => 'id']);
    }

    /**
     * Returns a list of links.
     *
     * Each link is either a URI or a [[Link]] object. The return value of this method should
     * be an array whose keys are the relation names and values the corresponding links.
     *
     * If a relation name corresponds to multiple links, use an array to represent them.
     *
     * For example,
     *
     * ```php
     * [
     *     'self' => 'http://example.com/users/1',
     *     'friends' => [
     *         'http://example.com/users/2',
     *         'http://example.com/users/3',
     *     ],
     *     'manager' => $managerLink, // $managerLink is a Link object
     * ]
     * ```
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/api/tag/view', 'id' => $this->id], true),
            'news' => Url::to(['/site/index', 'tag' => $this->id],true),
            'apiNews' => Url::to(['/api/news/index', 'tag' => $this->id],true),
        ];
    }
}
