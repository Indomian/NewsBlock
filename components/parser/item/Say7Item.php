<?php
namespace app\components\parser\item;

use app\components\parser\ParserItem;
use app\components\parser\ParserDownload;
use yii\helpers\HtmlPurifier;
use HTMLPurifier_Config;

class Say7Item extends ParserItem {
    use ParserDownload;

    public $lastRequest;

    private function loadDetailPage() {
        $html=$this->getContent();
        if(!$html) {
            return false;
        }
        $html=HtmlPurifier::process($html,function(HTMLPurifier_Config $config){
                $config->set('Core.Encoding','utf-8');
                $config->set('Attr.EnableID',true);
            });
        $obXml=simplexml_load_string('<div>'.$html.'</div>');
        foreach($obXml->xpath('//span[@class=\'dt-published\']/span') as $obDate) {
            $this->date_create=date('Y-m-d H:i:s',strtotime(trim($obDate->__toString())));
        }
        foreach($obXml->xpath('//div[contains(@class,\'h-recipe\')]') as $obContent) {
            foreach($obContent->xpath('//h2[contains(.,\'Ингредиенты\')]') as $obSource) {
                $this->content.=$obSource->__toString().PHP_EOL;
                foreach($obXml->xpath('//div[contains(@class,\'ingredients\')]/ul/li') as $obSourceItem) {
                    $this->content.=$obSourceItem->__toString().PHP_EOL;
                }
            }
            $this->content.='Приготовление'.PHP_EOL;
            foreach($obXml->xpath('//div[contains(@class,\'stepbystep\')]') as $obRules) {
                $this->content.=strip_tags($obRules->asXML());
            }
        }
        return true;
    }

    public function load(\SimpleXMLElement $data, $formName = null) {
        $this->oldAttributes=$this->attributes;
        $this->title=trim($data->a->__toString());
        $this->url=trim($data->a->attributes()->href->__toString());
        $this->loadDetailPage();
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