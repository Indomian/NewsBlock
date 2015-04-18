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
 */
class News extends \yii\db\ActiveRecord
{
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
            [['title'], 'string', 'max' => 255]
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
}
