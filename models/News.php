<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $date_create
 * @property string $content
 * @property string $url
 *
 * @property News2tags[] $news2tags
 * @property Tag[] $tags
 * @property Tag[] $tagsList
 */
class News extends \yii\db\ActiveRecord
{
    private $_tags;
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
            [['tags'], 'string'],
            [['tags'],function($attribute,$params){
                $arTags=explode(',',$this->$attribute);
                array_walk($arTags,function(&$value,$index){
                        $value=trim($value);
                    });
                $count=Tag::find()->where(
                    [
                        'title' => $arTags
                    ]
                )->count();
                if($count!=count($arTags)) {
                    $this->addError($attribute,Yii::t('app/news','Some tags mismatch available list'));
                }
            }]
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

    /**
     * @param bool $refresh
     * @return Tag[]
     */
    public function getTagsList($refresh=false) {
        if($refresh || empty($this->_tags)) {
            $this->_tags=$this->getTags()->asArray();
        }
        return $this->_tags;
    }

    /**
     * @param $value
     */
    public function setTags($value) {
        if(is_array($value)) {
            $this->_tags=$value;
            $this->markAttributeDirty('tags');
        } elseif(is_string($value)) {
            $arTags=explode(',',$value);
            array_walk($arTags,function(&$value,$index){
                    $value=trim($value);
                });
            $this->_tags=Tag::find()->where(
                [
                    'title' => $arTags
                ]
            )->all();
            $this->markAttributeDirty('tags');
        }
    }

    public function init() {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT,function($changedAttributes){
                if(in_array('tags',$changedAttributes)) {
                    foreach($this->_tags as $obTag) {
                        $this->link('tags',$obTag);
                    }
                }
            });
        $this->on(self::EVENT_AFTER_UPDATE,function(){
                foreach($this->_tags as $obTag) {
                    $this->link('tags',$obTag);
                }
            });
    }
}
