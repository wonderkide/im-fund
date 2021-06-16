<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvest */

$this->title = 'Create Fund Invest';
$this->params['breadcrumbs'][] = ['label' => 'Fund Invests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-invest-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
