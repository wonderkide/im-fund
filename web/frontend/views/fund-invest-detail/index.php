<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundInvestDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fund Invest Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-invest-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fund Invest Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fund_id',
            'fund_invest_id',
            'date',
            'nav',
            //'amount',
            //'units',
            //'created_at',
            //'type',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
