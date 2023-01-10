<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\Fund;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\FundPortListDetail */
/* @var $form yii\widgets\ActiveForm */

$l = null;
if($model->fund_id){
    $l = Fund::findOne($model->fund_id)->symbol;
}
?>

<div class="fund-port-list-detail-form">

    <?php $form = ActiveForm::begin([
                    'id' => 'activeForm',
                    'enableAjaxValidation' => TRUE,
                    'options' => ['data-pjax' => false],
        ]); ?>
    
    <?php
        echo $form->field($model, 'fund_id')->widget(Select2::classname(), [
            'initValueText' => $l, // set the initial display text
            'options' => ['placeholder' => 'เลือกกองทุน ...', 'disabled' => $model->isNewRecord ? false:true],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['fund/fund-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
            ],
        ])->label('กองทุน');
    ?>
    <?php
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'วันที่ทำรายการ ...'],
            //'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ]
    ]);
    ?>

    <?= $form->field($model, 'nav')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'note')->textarea() ?>

    <?php // $form->field($model, 'units')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
