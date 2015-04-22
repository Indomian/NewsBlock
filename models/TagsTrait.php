<?php
namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;

trait TagsTrait {
    protected $_tags;
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

    public function validateTags($attribute,$params){
        if(is_string($this->$attribute)) {
            $arTagsInput=explode(',',$this->$attribute);
        } elseif(is_array($this->$attribute)) {
            $arTagsInput=$this->$attribute;
        } else {
            $this->addError($attribute,Yii::t('app/news','Value is unsupported'));
            return;
        }

        $arTags=[];
        $arTagsIDs=[];
        foreach($arTagsInput as $value) {
            if(is_numeric($value)) {
                $value=trim($value);
                $arTagsIDs[]=intval($value);
            } elseif(is_string($value)) {
                $value=trim($value);
                $arTags[]=$value;
            } elseif(is_object($value) && $value instanceof Tag) {
                $arTagsIDs[]=$value->id;
            }
        }
        $count=Tag::find()->where(['title' => $arTags])->orWhere(['id'=>$arTagsIDs])->count();
        if($count!=count($arTags)+count($arTagsIDs)) {
            $this->addError($attribute,Yii::t('app/news','Some tags mismatch available list'));
        }
    }

    /**
     * @param $value
     */
    public function setTags($value) {
        if(is_string($value)) {
            $arTagsInput=explode(',',$value);
        } elseif(is_array($value)) {
            $arTagsInput=$value;
        } else {
            return;
        }
        $arTags=[];
        $arTagsIDs=[];
        $arTagsObjects=[];
        foreach($arTagsInput as $value) {
            if(is_numeric($value)) {
                $value=trim($value);
                $arTagsIDs[]=intval($value);
            } elseif(is_string($value)) {
                $value=trim($value);
                $arTags[]=$value;
            } elseif(is_object($value) && $value instanceof Tag) {
                $arTagsObjects[]=$value;
            }
        }
        $this->_tags=array_merge(
            Tag::find()->where(['title' => $arTags])->orWhere(['id'=>$arTagsIDs])->all(),
            $arTagsObjects
        );
        if(method_exists($this,'markAttributeDirty')) {
            $this->markAttributeDirty('tags');
        }
    }

    public function initTagsEvents() {
        $this->on(static::EVENT_AFTER_INSERT,function(){
                foreach($this->_tags as $obTag) {
                    $this->link('tags',$obTag);
                }
            });
        $this->on(static::EVENT_AFTER_UPDATE,function(){
                $arCurrent=$this->getTags()->all();
                $compareTags=function(Tag $a,Tag $b){
                    if($a->id==$b->id) {
                        return 0;
                    }
                    return $a->id>$b->id?1:-1;
                };
                if(is_array($arCurrent) && is_array($this->_tags)) {
                    $arDelete=array_udiff($arCurrent,$this->_tags,$compareTags);
                    foreach($arDelete as $obTag) {
                        $this->unlink('tags',$obTag,true);
                    }
                } elseif(is_array($arCurrent)) {
                    foreach($arCurrent as $obTag) {
                        $this->unlink('tags',$obTag,true);
                    }
                }
                if(is_array($arCurrent) && is_array($this->_tags)) {
                    $arNew=array_udiff($this->_tags,$arCurrent,$compareTags);
                    foreach($arNew as $obTag) {
                        $this->link('tags',$obTag);
                    }
                } elseif(is_array($this->_tags)) {
                    foreach($this->_tags as $obTag) {
                        $this->link('tags',$obTag);
                    }
                }
            });

    }
}