<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CropAsset extends AssetBundle
{
    public $sourcePath = '@themeAsset';
    public $css = [
        'css/croppie.min.css',
        'css/croppie-style.css',
    ];
    public $js = [
        'js/croppie.min.js',
        'js/croppie.script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\ThemeAsset',
    ];
    /*public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );*/
    public function init() {
        $this->publishOptions['forceCopy'] = (YII_ENV == 'dev') ? TRUE : FALSE;
        parent::init();
    }
}
