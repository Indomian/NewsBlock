<?php
namespace app\components;

use cebe\markdown\Parser;
use yii\base\Event;

class ItemFoundEvent extends Event {
    /**
     * @var ParserItem
     */
    public $parserItem;
}