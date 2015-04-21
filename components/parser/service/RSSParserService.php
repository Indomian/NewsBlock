<?php
namespace app\components\parser\service;

use app\components\parser\ParserService;
use app\components\events\ItemFoundEvent;

class RSSParserService extends ParserService {

    public function process()
    {
        $xml=$this->getContent();
        if(!$xml) {
            return false;
        }
        $xml=str_replace('<?xml version="1.0" encoding="windows-1251"?>','<?xml version="1.0" encoding="utf-8"?>',$xml);
        $obXml=simplexml_load_string($xml);
        foreach($obXml->xpath('//item') as $obItem) {
            $obParserItem=$this->getItemObject();
            if($obParserItem->load($obItem)) {
                $this->trigger('itemFound',new ItemFoundEvent(['parserItem'=>$obParserItem]));
            }
        }
        return true;
    }
}