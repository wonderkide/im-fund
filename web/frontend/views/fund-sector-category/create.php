<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundSectorCategory */

$this->title = 'Create Fund Sector Category';
$this->params['breadcrumbs'][] = ['label' => 'Fund Sector Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-sector-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
