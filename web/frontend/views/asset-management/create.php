<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AssetManagement */

$this->title = 'Create Asset Management';
$this->params['breadcrumbs'][] = ['label' => 'Asset Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-management-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
