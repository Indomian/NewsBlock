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