<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\FundPort;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundInvestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการพอร์ต';
$this->params['breadcrumbs'][] = $this->title;

$fp = new FundPort();
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
        'filterModel' => null,
        'tableOptions' => ['class' => 'table table-striped table-bordered text-center'],
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'name',
            //'amount',
            [
                'attribute' => 'amount',
                'format' => 'raw',
                'value' => function ($model) {
                    $amount = number_format($model->amount, 2);
                    $text = '<span class="text-bold">'.$amount.'</span>';
                    return $text;
                },
                'footer' => $fp->getTotalTextNumber($dataProvider->models, 'amount'),
            ],
            //'profit_amount',
            [
                'attribute' => 'profit_amount',
                'format' => 'raw',
                'value' => function ($model) {
                    $profit = number_format($model->profit_amount, 2);
                    if($model->profit_amount > 0){
                        $text = '<span class="text-bold text-success">'.$profit.'</span>';
                    }
                    elseif($model->profit_amount < 0){
                        $text = '<span class="text-bold text-danger">'.$profit.'</span>';
                    }
                    else{
                        $text = '<span class="text-bold text-dark">'.$profit.'</span>';
                    }
                    return $text;
                },
                'footer' => $fp->getTotalTextColor($dataProvider->models, 'profit_amount'),
            ],
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
                        return Html::a('<i class="fas fa-pencil-alt"></i>', '#', ['class' => 'activity-manage-link', 'data-url' => $url, 'data-title' => 'แก้ไข']);
                    }
                ]
            ],          
        ],
    ]); ?>


</div>
