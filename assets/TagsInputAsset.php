<?php
namespace app\assets;

use yii\web\AssetBundle;

class TagsInputAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap-tagsinput/dist';
    public $js = [
        'bootstrap-tagsinput.min.js'
    ];
    public $css = [
        'bootstrap-tagsinput.css'
    ];
    public $depends = [
        'app\assets\TypeaheadAsset'
    ];
}