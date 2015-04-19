<?php

namespace app\models;

use Yii;
use yii\base\InvalidValueException;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $processor
 * @property string $url
 * @property string $last_call
 */
class Service extends \yii\db\ActiveRecord
{
    public $parsers=[
        'RSS' => 'app\components\RSSParserService'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'string'],
            [['last_call'], 'safe'],
            [['title', 'processor'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/service', 'ID'),
            'title' => Yii::t('app/service', 'Title'),
            'processor' => Yii::t('app/service', 'Processor'),
            'url' => Yii::t('app/service', 'Url'),
            'last_call' => Yii::t('app/service', 'Last Call'),
        ];
    }

    /**
     * @return \app\components\ParserService
     * @throws \yii\base\InvalidValueException
     */
    public function getParser() {
        if(isset($this->parsers[$this->processor])) {
            $class=$this->parsers[$this->processor];
            $obClass=new $class();
            $obClass->url=$this->url;
            return $obClass;
        }
        throw new InvalidValueException('Processor not supported');
    }
}
