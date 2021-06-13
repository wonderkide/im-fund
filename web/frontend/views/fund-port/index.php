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

            'id',
            'user_id',
            'name',
            'present_value',
            'cost_value',
            //'present_nav',
            //'cost_nav',
            //'units',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
