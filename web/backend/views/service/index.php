<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

/** @var yii\web\View $this */
/** @var backend\models\ServiceLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Service';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Get Amc', ['class' => 'btn btn-success activity-confirm-redirect-link' ,'data-id' => 0, 'data-title' => 'ยืนยันดึงข้อมูล Amc', 'data-url' => Url::to(['get-amc'])]) ?>
        <?= Html::button('Get Fund Nav', ['class' => 'btn btn-success activity-manage-link' ,'data-id' => 0, 'data-title' => 'ดึงข้อมูล Nav', 'data-url' => Url::to(['get-nav-form'])]) ?>
        <?= Html::button('Calculate Nav', ['class' => 'btn btn-success activity-confirm-redirect-link' ,'data-id' => 0, 'data-title' => 'ยืนยันคำนวน Nav', 'data-url' => Url::to(['calculate-nav'])]) ?>
        <?= Html::button('Calculate Nav', ['class' => 'btn btn-danger activity-confirm-redirect-link' ,'data-id' => 0, 'data-title' => 'ยืนยันคำนวน Nav ใหม่', 'data-url' => Url::to(['calculate-nav-all'])]) ?>
    </p>

</div>
<?php 
Modal::begin([
    'id'=>'activity-modal',
    'size'=>'modal-md',
    'title' => 'MANAGEMENT',
    'clientOptions' => ['backdrop' => 'static']
    //'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>',
]);
Modal::end();
?>