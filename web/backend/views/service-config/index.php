<?php

use backend\models\ServiceConfig;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var backend\models\ServiceConfigSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Service Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'description',
            //'setting',
            //'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $s = SwitchInput::widget([
                        'name' => 'status',
                        'value' => $model->status,
                        'containerOptions' => ['style' => 'margin-bottom:0'],
                        'pluginOptions' => [
                            //'labelText'=>'<i class="fas fa-stop"></i>'
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ],
                        'pluginEvents' => [
                            "switchChange.bootstrapSwitch" => "function() { set_status($model->id); }",
                        ],
                    ]);
                    return $s;
                },
            ],
            
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {setting} {delete}',
                'urlCreator' => function ($action, ServiceConfig $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'buttons' => [
                        'setting' => function ($url, $model, $key) {
                        $u_link = Url::to(['service-config/setting', 'id' => $model->id]);
                        return Html::a('<i class="fas fa-cog"></i>', 
                                $u_link, 
                                [
                                    //'class' => 'activity-manage-link cursor-pointer', 
                                    'data-url' => $u_link, 
                                    
                                    'data-title' => 'setting',
                                    //'title' => 'Delete',
                                    //'aria-label' => 'Delete',
                                    //'data-pjax' => '0',
                                    //'data-confirm' => 'Are you sure you want to delete this item?',
                                    //'data-method' => 'post'
                                ]);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
<?php
$url_set_status = Url::to(['ajax_update_status']);

$script = <<< JS
        
        function set_status(id){
            jQuery.post("$url_set_status", {ids: id}, 
                function (data) {
                });
        }
JS;
$this->registerJs($script);
?>