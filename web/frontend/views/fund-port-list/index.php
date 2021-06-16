<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundPortListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fund Port Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-port-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fund Port List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'fund_port_id',
            'fund_id',
            'present_value',
            //'cost_value',
            //'present_nav',
            //'cost_nav',
            //'units',
            //'percent',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
