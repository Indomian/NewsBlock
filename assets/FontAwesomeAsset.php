<?php
namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@npm/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];

    public function init()
    {
        parent::init();
        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            if(is_file($from)) {
                $dirname = basename(dirname($from));
            } else {
                $dirname = basename($from);
            }
            return $dirname === 'fonts' || $dirname === 'css';
        };
    }
}