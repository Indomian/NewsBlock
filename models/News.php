<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\helpers\Url;
use yii\web\Linkable;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $date_create
 * @property string $content
 * @property string $url
 * @property string $hash
 *
 * @property News2tags[] $news2tags
 * @property Tag[] $tags
 * @property Tag[] $tagsList
 */
class News extends \yii\db\ActiveRecord implements Linkable
{
    const SCENARIO_REST_FULL=1;

    use TagsTrait;

    const PREVIEW_SIZE=5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_create'], 'safe'],
            [['content', 'url'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['tags'],'validateTags'],
            [['hash'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/news', 'ID'),
            'title' => Yii::t('app/news', 'Title'),
            'date_create' => Yii::t('app/news', 'Date Create'),
            'content' => Yii::t('app/news', 'Content'),
            'url' => Yii::t('app/news', 'Url'),
            'tags' => Yii::t('app/news', 'Tags'),
            'hash' => Yii::t('app/news', 'Hash'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews2tags()
    {
        return $this->hasMany(News2tags::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%news2tags}}', ['news_id' => 'id']);
    }

    public function init() {
        parent::init();
        $this->initTagsEvents();
        $this->on(self::EVENT_BEFORE_VALIDATE,function(){
                $this->hash=$this->makeHash();
            });
    }

    public function makeHash() {
        return sha1($this->title.'|'.$this->content);
    }

    public function fields() {
        $fields = parent::fields();
        if($this->scenario==self::SCENARIO_REST_FULL) {
            $fields[]='tags';
            return $fields;
        }

        unset($fields['content']);

        $fields['preview'] = function($model) {
            if(preg_match('#^((.*\s){10})#mu',$model->content,$matches)) {
                return trim($matches[1]);
            }
            return $model->content;
        };

        return $fields;
    }

    public function extraFields()
    {
        return ['tags','content'];
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
            Link::REL_SELF => Url::to(['/api/news/view', 'id' => $this->id], true),
        ];
    }
}
