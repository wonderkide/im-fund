<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FundSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'fund_type_id') ?>

    <?= $form->field($model, 'fund_type_in_id') ?>

    <?= $form->field($model, 'asset_management_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'name_th') ?>

    <?php // echo $form->field($model, 'risk') ?>

    <?php // echo $form->field($model, 'feeder_fund') ?>

    <?php // echo $form->field($model, 'currency_policy') ?>

    <?php // echo $form->field($model, 'dividend') ?>

    <?php // echo $form->field($model, 'frontend_fee') ?>

    <?php // echo $form->field($model, 'backend_fee') ?>

    <?php // echo $form->field($model, 'fee') ?>

    <?php // echo $form->field($model, 'first_invest') ?>

    <?php // echo $form->field($model, 'invest') ?>

    <?php // echo $form->field($model, 'registration_date') ?>

    <?php // echo $form->field($model, 'net_asset_value') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
