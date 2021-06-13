<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Modal;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
\hail812\adminlte3\assets\PluginAsset::register($this)->add(['sweetalert2', 'toastr']);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

use frontend\assets\LteAsset;
LteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="scroll-smooth">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= $this->title ? $this->title : Yii::$app->name ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-footer-fixed ">
<?php $this->beginBody() ?>
<?= \lavrentiev\widgets\toastr\NotificationFlash::widget() ?>
<div class="wrapper">
    <!-- Navbar -->
    <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
    
<?php 
Modal::begin([
    'id'=>'activity-modal',
    'size'=>'modal-lg',
    'title' => 'MANAGEMENT',
    'clientOptions' => ['backdrop' => 'static']
    //'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>',
]);
Modal::end();
?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
