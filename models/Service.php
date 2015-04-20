<?php

namespace app\models;

use app\components\parser\ParserItem;
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
 * @property string $item_class
 */
class Service extends \yii\db\ActiveRecord
{
    public $parsers=[
        'RSS' => 'app\components\parser\service\RSSParserService',
        'Say7' => 'app\components\parser\service\Say7ParserService'
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
            [['title', 'processor'], 'string', 'max' => 255],
            [['item_class'],function($attribute,$name){
                if(!class_exists($this->$attribute)) {
                    $this->addError($attribute,Yii::t('app/service','Item class should be existing class'));
                    return;
                }
                $className=$this->$attribute;
                $obTest=new $className;
                if(!$obTest instanceof ParserItem) {
                    $this->addError($attribute,Yii::t('app/service','Item class should be inherited from ParserItem'));
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
            'id' => Yii::t('app/service', 'ID'),
            'title' => Yii::t('app/service', 'Title'),
            'processor' => Yii::t('app/service', 'Processor'),
            'url' => Yii::t('app/service', 'Url'),
            'last_call' => Yii::t('app/service', 'Last Call'),
            'item_class' => Yii::t('app/service', 'Item class'),
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
            $obClass->parserItemClass=$this->item_class;
            $obClass->lastRequest=$this->last_call;
            return $obClass;
        }
        throw new InvalidValueException('Processor not supported');
    }
}
