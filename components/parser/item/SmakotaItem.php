<?php
namespace app\components\parser\item;

use app\components\parser\ParserItem;
use app\components\parser\ParserDownload;
use yii\helpers\HtmlPurifier;
use HTMLPurifier_Config;

class SmakotaItem extends ParserItem {
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
        foreach($obXml->xpath('//div[@class=\'title_full\']/following-sibling::div[1]') as $obContent) {
            $this->content=strip_tags($obContent->asXML()).PHP_EOL;
        }
        return true;
    }

    public function load(\SimpleXMLElement $data, $formName = null) {
        $this->oldAttributes=$this->attributes;
        $this->title=trim($data->title->__toString());
        $this->url=trim($data->link->__toString());
        $this->date_create=date('Y-m-d H:i:s',strtotime($data->pubDate->__toString()));
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