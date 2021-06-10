<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundSectorCategory */

$this->title = 'Update Fund Sector Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fund Sector Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-sector-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
