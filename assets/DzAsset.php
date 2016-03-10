<?php

namespace app\assets;

use yii\web\AssetBundle;

class DzAsset extends AssetBundle
{
    public $sourcePath = '@vendor/enyo/dropzone/dist/min';

    public $css = [
        'dropzone.min.css',
    ];
    public $js = [
        'dropzone.min.js'
    ];
    public $depends = [
    ];
}
