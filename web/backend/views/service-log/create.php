<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ServiceLog $model */

$this->title = 'Create Service Log';
$this->params['breadcrumbs'][] = ['label' => 'Service Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
