<?php
namespace app\components;



abstract class ParserService {
    public $url;

    abstract public function process();
}