<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fund $model */

$this->title = 'Create Fund';
$this->params['breadcrumbs'][] = ['label' => 'Funds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
