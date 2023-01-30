<?php

use common\models\Fund;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\select2\Select2;
use common\models\AssetManagement;
use yii\helpers\ArrayHelper;

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
            //'asset_management_id',
            [
                'attribute' => 'asset_management_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $n = $model->assetManagement->name_th;
                    return $n;
                },
                'filter' => Select2::widget([
                    'name' => 'FundSearch[asset_management_id]',
                    'value' => $searchModel->asset_management_id,
                    'data' => ArrayHelper::map(AssetManagement::find()->all(), 'id', 'name_th'),
                    'options' => ['placeholder' => 'เลือก บลจ.'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
            ],
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
