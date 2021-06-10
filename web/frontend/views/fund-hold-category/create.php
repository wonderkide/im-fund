<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundHoldCategory */

$this->title = 'Create Fund Hold Category';
$this->params['breadcrumbs'][] = ['label' => 'Fund Hold Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-hold-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
