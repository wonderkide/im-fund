<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvestDetail */

$this->title = 'Create Fund Invest Detail';
$this->params['breadcrumbs'][] = ['label' => 'Fund Invest Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-invest-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
