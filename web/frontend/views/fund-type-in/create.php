<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundTypeIn */

$this->title = 'Create Fund Type In';
$this->params['breadcrumbs'][] = ['label' => 'Fund Type Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-type-in-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
