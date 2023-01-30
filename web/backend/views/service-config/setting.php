<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'จัดการตั้งค่าเพิ่มเติม';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'setting')->widget(MultipleInput::className(), [
        'iconSource' => 'fa',
        'min' => 0,
        'max' => 10,
        'columns' => [
            [
                'name'  => 'name',
                'title' => 'ชื่อที่ใช้',
                'type' => 'textInput',
            ],
            [
                'name'  => 'value',
                'title' => 'ข้อมูล',
                'type' => 'textInput',
            ],

        ],
        ])->label(false);
    ?>            
    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <?= Html::a('กลับ', Url::to(['index']), ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>