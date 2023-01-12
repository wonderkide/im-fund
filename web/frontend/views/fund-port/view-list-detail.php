<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortListDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fund Port List Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fund-port-list-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            //'fund_port_list_id',
            'date',
            'sale_date',
            'nav',
            'amount',
            'units',
            'note',
            //'created_at',
            //'type',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '-';
                    if($model->type == 1){
                        $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ซื้อ</span>';
                    }
                    elseif($model->type == 2){
                        $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ขาย</span>';
                    }
                    elseif($model->type == 3){
                        $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ย้ายเข้า</span>';
                    }
                    elseif($model->type == 4){
                        $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ย้ายออก</span>';
                    }
                    return $text;
                }
            ],
            //'status',
        ],
    ]) ?>

</div>
