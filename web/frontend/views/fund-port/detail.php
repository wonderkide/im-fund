<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundInvestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'พอร์ต : ' . $port->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-invest-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> ซื้อกองทุน', null, [
            'class' => 'btn btn-success activity-manage-link text-light',
            'data-title' => 'ซื้อกองทุน',
            //'data-url' => Url::to(['fund-port-list-detail/create', 'redirect' => Url::to(['fund-port', 'id' => $port->id])])
            'data-url' => 'buy'
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'user_id',
            //'fund_port_id',
            //'fund_id',
            'present_value',
            'cost_value',
            'present_nav',
            'cost_nav',
            'units',
            'percent',
            //'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
