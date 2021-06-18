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
            'data-url' => Url::to(['fund-port/buy', 'id' => $port->id])
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            //'fund_port_id',
            //'fund_id',
            [
                'attribute' => 'fund_id',
                'value' => function ($model) {
                    return $model->fund->name;
                }
            ],
            'present_value',
            'cost_value',
            'present_nav',
            'cost_nav',
            'units',
            'percent',
            //'created_at',
            'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'min-width:100px;'],
                'contentOptions' => ['class' => 'text-center'],
                'template'=>'{detail} {list-buy} {list-sell}',
                'buttons'=>[
                    'detail' => function($url,$model,$key){
                        return Html::a('<i class="fas fa-list"></i>', 
                                Url::to(['fund-port/list-detail', 'id' => $model->id]), 
                                [
                                    //'class' => 'activity-create-link', 
                                    'data-url' => Url::to(['fund-port/list-detail', 'id' => $model->id]), 
                                    'data-title' => 'ประวัติ',
                                    'title' => 'ประวัติ'
                                ]);
                    },
                    'list-buy' => function($url,$model,$key){
                        return Html::a('<i class="fas fa-plus"></i>', 
                                '#', 
                                [
                                    'class' => 'activity-manage-link', 
                                    'data-url' => Url::to(['fund-port/list-buy', 'id' => $model->id]), 
                                    'data-title' => 'ซื้อเพิ่ม',
                                    'title' => 'ซื้อเพิ่ม'
                                ]);
                    },
                    'list-sell' => function($url,$model,$key){
                        return Html::a('<i class="fas fa-minus"></i>', 
                                '#', 
                                [
                                    'class' => 'activity-manage-link', 
                                    'data-url' => $url, 
                                    'data-title' => 'ขาย',
                                    'title' => 'ขาย'
                                ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
