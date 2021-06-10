<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fund */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'fund_type_id')->textInput() ?>

    <?= $form->field($model, 'fund_type_in_id')->textInput() ?>

    <?= $form->field($model, 'asset_management_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'risk')->textInput() ?>

    <?= $form->field($model, 'feeder_fund')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_policy')->textInput() ?>

    <?= $form->field($model, 'dividend')->textInput() ?>

    <?= $form->field($model, 'frontend_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'backend_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_invest')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invest')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_date')->textInput() ?>

    <?= $form->field($model, 'net_asset_value')->textInput() ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
