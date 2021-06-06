<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@themeAsset';
    public $css = [
        'datatables/DataTables-1.10.21/css/jquery.dataTables.min.css',
        'datatables/Responsive-2.2.5/css/responsive.dataTables.min.css',
        'css/main.css',
    ];
    public $js = [
        'datatables/DataTables-1.10.21/js/jquery.dataTables.min.js',
        'datatables/Responsive-2.2.5/js/dataTables.responsive.min.js',
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