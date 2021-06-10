<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundType */

$this->title = 'Create Fund Type';
$this->params['breadcrumbs'][] = ['label' => 'Fund Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
