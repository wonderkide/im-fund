<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AssetManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asset Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-management-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Asset Management', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_th',
            'name_en',
            'code',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
