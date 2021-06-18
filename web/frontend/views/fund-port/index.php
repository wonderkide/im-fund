<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundInvestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการพอร์ต';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-invest-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> เพิ่ม', null, [
            'class' => 'btn btn-success activity-create-link text-light',
            'data-title' => 'เพิ่มพอร์ต',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'name',
            'amount',
            'profit_amount',
            //'created_at',
            'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{detail} {update} {delete}',
                'buttons'=>[
                    'detail' => function($url,$model,$key){
                        return Html::a('<i class="fas fa-list"></i>', $url);
                    },
                    'update' => function($url,$model,$key){
                        return Html::a('<i class="fas fa-pencil-alt"></i>', '#', ['class' => 'activity-create-link', 'data-url' => $url, 'data-title' => 'แก้ไข']);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
