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

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
