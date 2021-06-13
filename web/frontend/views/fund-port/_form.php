<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FundInvest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-invest-form">

    <?php $form = ActiveForm::begin([
                    'id' => 'activeForm',
                    'enableAjaxValidation' => TRUE,
                    'options' => ['data-pjax' => false],
        ]); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'present_value')->textInput() ?>

    <?= $form->field($model, 'cost_value')->textInput() ?>

    <?= $form->field($model, 'present_nav')->textInput() ?>

    <?= $form->field($model, 'cost_nav')->textInput() ?>

    <?= $form->field($model, 'units')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
