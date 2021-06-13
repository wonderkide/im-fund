<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายชื่อกองทุน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> เพิ่ม', null, [
            'class' => 'btn btn-success activity-create-link text-light',
            'data-title' => 'เพิ่มกองทุน',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fund_type_id',
            'asset_management_id',
            'name',
            'name_th',
            //'risk',
            //'feeder_fund',
            //'currency_policy',
            //'dividend',
            //'frontend_fee',
            //'backend_fee',
            //'fee',
            //'first_invest',
            //'invest',
            //'registration_date',
            //'net_asset_value',
            //'detail:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?php
$url_set_status = Url::to(['ajax_update_status']);
$script = <<< JS
        /*$('#table-dt').DataTable( {
            'lengthMenu': [[100,250,500,-1],[100,250,500,'All']],
            'language': {
                'url': 'dataTables.thai.lang'
            },
            'columnDefs': [
                { targets: 'no-sort', orderable: false, order: []},
            ]
        } );
        
        function set_status(id){
            jQuery.post("$url_set_status", {ids: id}, 
                function (data) {
                });
        }*/
        
JS;
$this->registerJs($script);
?>