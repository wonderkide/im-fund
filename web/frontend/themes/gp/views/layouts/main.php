<?php
use frontend\assets\GpAsset;
use yii\helpers\Html;

GpAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicons -->
    <link href="<?= Yii::$app->assetManager->getPublishedUrl('@GpAsset') ?>/img/in-memories-brain.png" rel="icon">
    <link href="<?= Yii::$app->assetManager->getPublishedUrl('@GpAsset') ?>/img/in-memories-brain.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <?php $this->registerCsrfMetaTags() ?>
    <title>FUND MEMORIES</title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column ">
<?php $this->beginBody() ?>

    <?= $this->render('header'); ?>
    
    <?= $content ?>
    
<?php
if(Yii::$app->user->isGuest){
    echo $this->render('_sign_modal');
}
?>

    <?= $this->render('footer'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
