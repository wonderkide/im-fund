<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ServiceLog $model */

$this->title = 'Update Service Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Service Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
