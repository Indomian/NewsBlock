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
        //TODO FIXME!
        /*$html=HtmlPurifier::process($html,function(HTMLPurifier_Config $config){
                $config->set('Core.Encoding','utf-8');
                $config->set('Attr.EnableID',true);
                $config->set('HTML.DefinitionID', 'say7page');
                $config->set('HTML.DefinitionRev', '1');
                //$def = $config->getHTMLDefinition(true);
                if ($def = $config->maybeGetRawHTMLDefinition()) {
                    $def->addAttribute('span', 'itemprop', 'Enum#datePublished');
                    $def->addAttribute('span', 'content', 'Text');
                }
                $config->set('HTML.AllowedAttributes',[
                       'span.itemprop','span.content','img.src','a.href','*.class','*.id'
                    ]);
                $config->finalize();
            });*/
        $obXml=simplexml_load_string('<div>'.$html.'</div>');
        foreach($obXml->xpath('//span[@itemprop=\'datePublished\']') as $obDate) {
            $this->date_create=strtotime(trim($obDate->attributes()->content->__toString()));
        }
        return true;
    }

    public function load(\SimpleXMLElement $data, $formName = null) {
        $this->oldAttributes=$this->attributes;
        $this->title=trim($data->a->__toString());
        $this->url=trim($data->a->attributes()->href->__toString());
        $this->loadDetailPage();
        /*$this->content=$data->description->__toString();
        $this->date_create=date('Y-m-d H:i:s',strtotime($data->pubDate->__toString()));
        $this->url=$data->link->__toString();*/
        print_r($this->attributes);return false;
        if($this->validate()) {
            $this->oldAttributes=null;
            return true;
        } else {
            $this->attributes=$this->getOldAttributes();
            $this->oldAttributes=null;
            return false;
        }
        return false;
    }
}