<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\models\Member;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */

$user_id = isset($_GET['ReportSearch']['admin_id']) ? $_GET['ReportSearch']['admin_id'] : null;
$username = null;
if($user_id){
    $username = Member::findOne($user_id)->username;
}
?>

<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          <i class="fa fa-search"></i> ค้นหา ...
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">

<div class="report-search">
    <div class="row">
        <div class="col-12 col-md-6">
    <?php $form = ActiveForm::begin([
        'action' => ['report'],
        'method' => 'get',
    ]); ?>
    <?php
        echo $form->field($model, 'admin_id')->widget(Select2::classname(), [
        //'data' => $data,
        'options' => ['placeholder' => 'รหัสพนักงาน ...'],
        'initValueText' => $username,
        //'value' => $user_id,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['member/userlist']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ],
    ]);
    ?>
            <div class="row">
                <div class="col-12 col-md-6">
    <?php echo $form->field($model, 'start_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'วันที่ ...'],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
                </div>
                <div class="col-12 col-md-6">
            
    <?php echo $form->field($model, 'end_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'วันที่ ...'],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
    
    <?php echo $form->field($model, 'start_time')->widget(TimePicker::classname(), [
        //'value' => '00:00',
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
        ]
    ]); ?>
                    </div>
                <div class="col-12 col-md-6">
    
    <?php echo $form->field($model, 'end_time')->widget(TimePicker::classname(), [
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
        ]
    ]); ?>
                    </div>
            </div>

    <?php  echo $form->field($model, 'place') ?>

    <?php  echo $form->field($model, 'travel_by') ?>

    <?php  echo $form->field($model, 'travel_with') ?>

    <?php  echo $form->field($model, 'detail') ?>

    <div class="form-group">
        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?php //echo Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
      </div>
    </div>
  </div>
</div>
