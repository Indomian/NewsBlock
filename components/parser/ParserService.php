<?php
namespace app\components\parser;

use Curl\Curl;
use yii\base\Component;

abstract class ParserService extends Component {
    use ParserDownload;

    public $url;
    public $lastRequest=null;
    public $parserItemClass='app\components\ParserItem';
    public $tags=array();

    /**
     * @return ParserItem
     */
    protected function getItemObject() {
        $itemClass=$this->parserItemClass;
        $obItem=new $itemClass();
        if(!empty($this->tags)) {
            $obItem->setTags($this->tags);
        }
        return $obItem;
    }

    abstract public function process();
}