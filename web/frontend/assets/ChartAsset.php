<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    public $css = [
        'chart.js/Chart.min.css'
    ];

    public $js = [
        'chart.js/Chart.min.js'
    ];

    public $depends = [
        'hail812\adminlte3\assets\BaseAsset',
        'hail812\adminlte3\assets\PluginAsset'
    ];
}