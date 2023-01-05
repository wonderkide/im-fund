<?php

use common\models\Fund;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\FundSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

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

            //'id',
            //'user_id',
            //'fund_type_id',
            //'fund_type_in_id',
            'asset_management_id',
            'symbol',
            //'name_en',
            'name_th',
            'nav',
            //'nav_date',
            //'risk',
            //'feeder_fund',
            //'currency_policy',
            //'currency_policy_text',
            //'dividend',
            //'frontend_fee',
            //'backend_fee',
            //'fee',
            //'first_invest',
            //'invest',
            //'registration_date',
            //'registration_date_text',
            //'net_asset_value',
            //'detail:ntext',
            //'content_status',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fund $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
