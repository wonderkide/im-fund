<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Fund */

$this->title = 'Update Fund: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Funds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
