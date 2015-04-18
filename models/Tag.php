<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $title
 *
 * @property News2tags[] $news2tags
 * @property News[] $news
 */
class Tag extends \yii\db\ActiveRecord
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
}
