<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AssetManagement $model */

$this->title = 'Update Asset Management: ' . $model->name_th;
$this->params['breadcrumbs'][] = ['label' => 'Asset Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asset-management-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
