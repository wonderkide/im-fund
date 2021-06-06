<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = 'เปลี่ยนรหัสผ่าน : ' . $admin->username;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $admin->id, 'url' => ['view', 'id' => $admin->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-update">

    <h5><u><?= Html::encode($this->title) ?></u></h5>
    <br>

    <div class="admin-form">

        <?php $form = ActiveForm::begin([
                    'id' => 'activeForm-admin-form',
                    'enableAjaxValidation' => TRUE,
                    'options' => ['data-pjax' => false],
        ]); ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 're_password')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <?= Html::button('ปิด', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
