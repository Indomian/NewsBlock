<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
class News extends \yii\db\ActiveRecord
{
    const PREVIEW_SIZE=5;
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
            [['tags'],function($attribute,$params){
                if(is_string($this->$attribute)) {
                    $arTags=explode(',',$this->$attribute);
                    array_walk($arTags,function(&$value,$index){
                            $value=trim($value);
                        });
                } elseif(is_array($this->$attribute)) {
                    $arTags=ArrayHelper::getColumn($this->$attribute,'title');
                } else {
                    $this->addError($attribute,Yii::t('app/news','Value is unsupported'));
                    return;
                }
                $count=Tag::find()->where(
                    [
                        'title' => $arTags
                    ]
                )->count();
                if($count!=count($arTags)) {
                    $this->addError($attribute,Yii::t('app/news','Some tags mismatch available list'));
                }
            }],
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

    /**
     * @param bool $refresh
     * @return Tag[]
     */
    public function getTagsList($refresh=false) {
        if($refresh || empty($this->_tags)) {
            $this->_tags=$this->getTags()->all();
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
        $this->on(self::EVENT_BEFORE_VALIDATE,function(){
                $this->hash=$this->makeHash();
            });
        $this->on(self::EVENT_AFTER_INSERT,function(){
                foreach($this->_tags as $obTag) {
                    $this->link('tags',$obTag);
                }
            });
        $this->on(self::EVENT_AFTER_UPDATE,function(){
                $arCurrent=$this->getTags()->all();
                $compareTags=function(Tag $a,Tag $b){
                    if($a->id==$b->id) {
                        return 0;
                    }
                    return 1;
                };
                $arDelete=array_udiff($arCurrent,$this->_tags,$compareTags);
                foreach($arDelete as $obTag) {
                    $this->unlink('tags',$obTag,true);
                }
                $arNew=array_udiff($this->_tags,$arCurrent,$compareTags);
                foreach($arNew as $obTag) {
                    $this->link('tags',$obTag);
                }
            });
    }

    public function makeHash() {
        return sha1($this->title.'|'.$this->content);
    }

    public function fields() {
        $fields = parent::fields();

        unset($fields['content']);

        $fields['preview'] = function($model) {
            return $model->content; //TODO Make word striped from start;
        };

        return $fields;
    }

    public function extraFields()
    {
        return ['tags','content'];
    }
}
