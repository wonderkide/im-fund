<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Member;
use kartik\export\ExportMenu;
use coderius\lightbox2\Lightbox2;
use app\models\Images;

echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
        'fitImagesInViewport' => true,
        'showImageNumberLabel' => false,
        'disableScrolling' => true
    ]
]);

$user_id = isset($_GET['ReportSearch']['user_code']) ? $_GET['ReportSearch']['user_code'] : null;
$username = null;
if($user_id){
    $username = Member::findOne($user_id)->username;
}

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บันทึกทั้งหมด';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'admin_id',
                //'header' => 'รหัสพนักงาน',
                //'options' => ['style' => 'width:70px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
                'format' => 'raw',
                'value' => function($data) {
                    $admin = $data->admin;
                    if($admin){
                        return $admin->username;
                    }
                    return '-';
                }
            ],
            [
                'attribute' => 'date',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'start_time',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'end_time',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'place',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'travel_by',
                //'header' => 'สร้างเมื่อ',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'travel_with',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'detail',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'created_at',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'updated_at',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
];
?>
<style>
    .pagination > li > a, .pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}
.pagination > li:first-child > a, .pagination > li:first-child > span {
    margin-left: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}
.pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
    color: #777777;
    cursor: not-allowed;
    background-color: #fff;
    border-color: #ddd;
}
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #337ab7;
    border-color: #337ab7;
}
.pagination > li:last-child > a, .pagination > li:last-child > span {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
</style>
<div class="card">
    <div class="card-header">
        <h5 class="text-bold mb-0"><?= $this->title ?></h5>
        </div>
    <div class="card-body">
<div class="report-index">

    <?php echo $this->render('_report_search', ['model' => $searchModel]); ?>
    
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputName2">Export menu</label>
            <?php 
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,

                ]
                ,
                'filename' => 'export_report_'. time()
            ]);
            ?>
        </div>
    </div>
    
    
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'admin_id',
                //'header' => 'รหัสพนักงาน',
                //'options' => ['style' => 'width:70px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
                'format' => 'raw',
                'value' => function($data) {
                    $admin = $data->admin;
                    if($admin){
                        return $admin->username;
                    }
                    return '-';
                }
            ],
            /*[
                'attribute' => 'admin_id',
                'headerOptions' => ['class' => 'text-center'],
                //'label' => 'Phone',
                'filter' => Select2::widget([
                        'name' => 'ReportSearch[user_code]',
                        'options' => ['placeholder' => 'รหัสพนักงาน ...'],
                        'initValueText' => $username,
                        'value' => $user_id,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 2,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => \yii\helpers\Url::to(['admin/userlist']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                        ],
                    ]),
                'value' => function ($data) {
                    $user = $data->admin;
                    return $user ? $user->username : '';
                },
            ],*/
            [
                'attribute' => 'date',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'start_time',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'end_time',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'place',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'travel_by',
                //'header' => 'สร้างเมื่อ',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'travel_with',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'detail',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
                    [
                'attribute' => 'id',
                'header' => 'รูป',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
                'format' => 'raw',
                'value' => function($data) {
                    $img = Images::findOne(['report_id' => $data->id]);
                    $text = '-';
                    if($img){
                        $text = '<a href="'. $img->path.'" data-lightbox="roadtrip" data-title="'. $data->id .'" data-alt="'. $data->id .'">'. Html::img($img->path, ["class" => "img-preview"]) .'</a>';
                    }
                    return $text;
                }
            ],
            /*[
                'attribute' => 'created_at',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'updated_at',
                //'options' => ['style' => 'width:90px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle;'],
            ],*/
        ],
    ]); ?>

    </div>
</div>
    </div>
</div>