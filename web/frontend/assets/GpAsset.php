<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GpAsset extends AssetBundle
{
    public $sourcePath = '@GpAsset';
    public $css = [
        //'vendor/bootstrap/css/bootstrap.min.css',
        'vendor/icofont/icofont.min.css',
        'vendor/boxicons/css/boxicons.min.css',
        'vendor/owl.carousel/assets/owl.carousel.min.css',
        'vendor/venobox/venobox.css',
        'vendor/remixicon/remixicon.css',
        'vendor/aos/aos.css',
        'css/style.css',
        'css/update.css',
    ];
    public $js = [
        //'vendor/jquery/jquery.min.js',
        //'vendor/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/jquery.easing/jquery.easing.min.js',
        'vendor/php-email-form/validate.js',
        'vendor/owl.carousel/owl.carousel.min.js',
        'vendor/isotope-layout/isotope.pkgd.min.js',
        'vendor/venobox/venobox.min.js',
        'vendor/waypoints/jquery.waypoints.min.js',
        'vendor/counterup/counterup.min.js',
        'vendor/aos/aos.js',
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