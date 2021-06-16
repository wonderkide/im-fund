<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortList */

$this->title = 'Update Fund Port List: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fund Port Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-port-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
