<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundPortListDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติ  : ' . $port_list->fund->name;
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
        ],
    ]); ?>


</div>
