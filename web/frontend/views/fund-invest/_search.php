<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-invest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'fund_id') ?>

    <?= $form->field($model, 'present_value') ?>

    <?= $form->field($model, 'cost_value') ?>

    <?php // echo $form->field($model, 'present_nav') ?>

    <?php // echo $form->field($model, 'cost_nav') ?>

    <?php // echo $form->field($model, 'units') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
