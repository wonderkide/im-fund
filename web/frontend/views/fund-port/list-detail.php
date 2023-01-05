<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundPortListDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติ  : ' . $port_list->fund->symbol;
$this->params['breadcrumbs'][] = ['label' => $port_list->fundPort->name, 'url' => ['/fund-port', 'id' => $port_list->fund_port_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-port-list-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            //'fund_port_list_id',
            'date',
            'nav',
            'amount',
            'units',
            'created_at',
            //'type',
            //'status',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '-';
                    if($model->type == 1){
                        $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ซื้อ</span>';
                    }
                    elseif($model->type == 2){
                        $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ขาย</span>';
                    }
                    elseif($model->type == 3){
                        $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ย้ายเข้า</span>';
                    }
                    elseif($model->type == 4){
                        $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ย้ายออก</span>';
                    }
                    return $text;
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'min-width:100px;'],
                'contentOptions' => ['class' => 'text-center'],
                'template'=>'{delete}',
                'buttons'=>[
                    'delete' => function ($url, $model, $key) {
                        $u_link = Url::to(['fund-port/list-detail-delete', 'id' => $model->id]);
                        return Html::a('<i class="fas fa-trash"></i>', 
                                $u_link, 
                                [
                                    'class' => '', 
                                    'data-url' => $u_link, 
                                    'data-title' => 'Delete',
                                    'title' => 'Delete',
                                    'aria-label' => 'Delete',
                                    'data-pjax' => '0',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    //'data-method' => 'post'
                                ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
