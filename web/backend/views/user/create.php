<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = 'Create Admin';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-create">
    <div class="admin-form">

        <?php $form = ActiveForm::begin([
                    'id' => 'activeForm-admin-form',
                    'enableAjaxValidation' => TRUE,
                    'options' => ['data-pjax' => false],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->radioList([0 => 'Inactive', 1 => 'Active']) ?>

        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <?= Html::button('ปิด', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
