<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ServiceConfig $model */

$this->title = 'Update Service Config: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Service Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
