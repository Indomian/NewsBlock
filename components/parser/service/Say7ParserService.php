<?php
namespace app\components\parser\service;

use yii\helpers\HtmlPurifier;
use app\components\parser\ParserService;
use app\components\ItemFoundEvent;
use HTMLPurifier_Config;

class Say7ParserService extends ParserService {
    private function getLastPage() {
        $html=$this->getContent();
        if(!$html) {
            return false;
        }
        $html=HtmlPurifier::process($html,function(HTMLPurifier_Config $config){
                $config->set('Core.Encoding','utf-8');
                $config->set('Attr.EnableID',true);
            });

        $obXml=simplexml_load_string('<div>'.$html.'</div>');
        $lastLink=$obXml->xpath('//div[@class=\'nav\']//li[last()]/a');
        if(!empty($lastLink)) {
            $this->url=trim($lastLink[0]->attributes()->href->__toString());
            $this->lastRequest='1970-01-01 00:00:00';
            return true;
        }
        return false;
    }

    public function process()
    {
        if(!$this->getLastPage()) {
            return false;
        }
        $html=$this->getContent();
        if(!$html) {
            return false;
        }
        $html=HtmlPurifier::process($html,function(HTMLPurifier_Config $config){
                $config->set('Core.Encoding','utf-8');
                $config->set('Attr.EnableID',true);
            });
        $obXml=simplexml_load_string('<div>'.$html.'</div>');

        foreach($obXml->xpath('//div[@id=\'content\']/div[@class=\'lst\']/ul/li') as $obItem) {
            $obParserItem=$this->getItemObject();
            if($obParserItem->load($obItem)) {
                $this->trigger('itemFound',new ItemFoundEvent(['parserItem'=>$obParserItem]));
            }
        }
        return true;
    }
}