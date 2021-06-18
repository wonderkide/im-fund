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
            'type',
            //'status',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
