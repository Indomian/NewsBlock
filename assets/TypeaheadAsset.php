<?php
namespace app\assets;

use yii\web\AssetBundle;

class TypeaheadAsset extends AssetBundle
{
    public $sourcePath = '@npm/typeahead.js/dist';
    public $js = [
        'typeahead.bundle.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

/*    public function init()
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
    }*/
}