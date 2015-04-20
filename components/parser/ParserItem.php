<?php
namespace app\components\parser;

use app\models\News;
use yii\base\Model;
use yii\web\MethodNotAllowedHttpException;

abstract class ParserItem extends News {
    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null) {
        return false;
    }
}