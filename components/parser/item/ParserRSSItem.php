<?php
namespace app\components\parser\item;

use app\components\parser\ParserItem;

class ParserRSSItem extends ParserItem {
    public function load(\SimpleXMLElement $data, $formName = null) {
        $this->oldAttributes=$this->attributes;
        $this->title=$data->title->__toString();
        $this->content=$data->description->__toString();
        $this->date_create=date('Y-m-d H:i:s',strtotime($data->pubDate->__toString()));
        $this->url=$data->link->__toString();
        if($this->validate()) {
            $this->oldAttributes=null;
            return true;
        } else {
            $this->attributes=$this->getOldAttributes();
            $this->oldAttributes=null;
            return false;
        }
    }
}