<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortList */

$this->title = 'Create Fund Port List';
$this->params['breadcrumbs'][] = ['label' => 'Fund Port Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-port-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
