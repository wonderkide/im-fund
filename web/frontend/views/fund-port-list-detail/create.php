<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortListDetail */

$this->title = 'Create Fund Port List Detail';
$this->params['breadcrumbs'][] = ['label' => 'Fund Port List Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-port-list-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
