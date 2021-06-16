<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvest */

$this->title = 'Update Fund Invest: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fund Invests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-invest-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
