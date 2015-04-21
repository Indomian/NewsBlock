<?php
namespace app\components\events;

use yii\base\Event;
use app\components\parser\ParserItem;

class ItemFoundEvent extends Event {
    /**
     * @var ParserItem
     */
    public $parserItem;
}