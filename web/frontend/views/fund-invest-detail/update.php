<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvestDetail */

$this->title = 'Update Fund Invest Detail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fund Invest Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-invest-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
