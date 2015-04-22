<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%service2tag}}".
 *
 * @property integer $service_id
 * @property integer $tag_id
 *
 * @property Service $service
 * @property Tag $tag
 */
class Service2tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service2tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'tag_id'], 'required'],
            [['service_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app/service2tag', 'Service ID'),
            'tag_id' => Yii::t('app/service2tag', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
