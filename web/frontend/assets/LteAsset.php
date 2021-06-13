<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LteAsset extends AssetBundle
{
    public $sourcePath = '@LteAsset';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/main.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset'
    ];
    /*public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );*/
    public function init() {
        $this->publishOptions['forceCopy'] = (YII_ENV == 'dev') ? TRUE : FALSE;
        parent::init();
    }
}