<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Fund */

$this->title = 'Create Fund';
$this->params['breadcrumbs'][] = ['label' => 'Funds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
