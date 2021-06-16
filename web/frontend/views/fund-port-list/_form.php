<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-port-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'fund_port_id')->textInput() ?>

    <?= $form->field($model, 'fund_id')->textInput() ?>

    <?= $form->field($model, 'present_value')->textInput() ?>

    <?= $form->field($model, 'cost_value')->textInput() ?>

    <?= $form->field($model, 'present_nav')->textInput() ?>

    <?= $form->field($model, 'cost_nav')->textInput() ?>

    <?= $form->field($model, 'units')->textInput() ?>

    <?= $form->field($model, 'percent')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
