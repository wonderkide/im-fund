<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fund $model */

$this->title = 'Update Fund: ' . $model->symbol;
$this->params['breadcrumbs'][] = ['label' => 'Funds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->symbol, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fund-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
