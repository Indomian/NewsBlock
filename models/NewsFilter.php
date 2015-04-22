<?php
namespace app\models;

use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class NewsFilter extends Model {
    use TagsTrait;

    public $date_from;
    public $date_to;

    public function rules() {
        return [
            [['tags'],'validateTags'],
            [['date_from','date_to'],'date','format'=>'php:Y-m-d H:i:s']
        ];
    }

    public function attributes() {
        return [
            'tags',
            'date_from',
            'date_to'
        ];
    }

    public function getTags() {
        return $this->_tags;
    }

    public function addFilter(ActiveQuery $query) {
        if(!empty($this->_tags)) {
            $query->joinWith('tags');
            $query->andWhere(['tag.id'=>ArrayHelper::getColumn($this->_tags,'id')]);
        }
        if(!empty($this->date_from)) {
            $query->andWhere(['>=','date_create',$this->date_from]);
        }
        if(!empty($this->date_to)) {
            $query->andWhere(['<=','date_create',$this->date_to]);
        }
    }
}