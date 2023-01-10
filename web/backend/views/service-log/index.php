<?php

use backend\models\ServiceLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ServiceLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Service Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Service Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'action',
            //'detail:ntext',
            [
                'attribute' => 'detail',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = json_encode($model->detail);
                    return $text;
                },
            ],
            'created_at',
            'status',
            /*[
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ServiceLog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],*/
        ],
    ]); ?>


</div>
