<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Funds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fund', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'fund_type_id',
            'fund_type_in_id',
            'asset_management_id',
            //'name',
            //'name_th',
            //'risk',
            //'feeder_fund',
            //'currency_policy',
            //'dividend',
            //'frontend_fee',
            //'backend_fee',
            //'fee',
            //'first_invest',
            //'invest',
            //'registration_date',
            //'net_asset_value',
            //'detail:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
