<?php
namespace app\components\parser;

use Curl\Curl;
use yii\base\Component;

abstract class ParserService extends Component {
    use ParserDownload;

    public $url;
    public $lastRequest=null;
    public $parserItemClass='app\components\ParserItem';

    /**
     * @return ParserItem
     */
    protected function getItemObject() {
        $itemClass=$this->parserItemClass;
        return new $itemClass();
    }

    abstract public function process();
}