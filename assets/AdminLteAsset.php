<?php

namespace app\assets;

use yii\web\AssetBundle;


class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin-lte/AdminLTE.css',
		'css/admin-lte/skins/skin-blue.css',
		'css/styles.css',
    ];
    public $js = [
		'js/admin-lte/adminlte.js',
		'js/custom.js',		
    ];
    public $depends = [
		'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
