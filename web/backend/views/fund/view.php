<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fund $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Funds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fund-view">

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
            'id',
            'user_id',
            'fund_type_id',
            'fund_type_in_id',
            'asset_management_id',
            'name',
            'name_th',
            'nav',
            'nav_date',
            'risk',
            'feeder_fund',
            'currency_policy',
            'currency_policy_text',
            'dividend',
            'frontend_fee',
            'backend_fee',
            'fee',
            'first_invest',
            'invest',
            'registration_date',
            'registration_date_text',
            'net_asset_value',
            'detail:ntext',
            'content_status',
            'updated_at',
        ],
    ]) ?>

</div>
