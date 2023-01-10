<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\FundType;
use common\models\FundTypeIn;
use common\models\AssetManagement;

/** @var yii\web\View $this */
/** @var common\models\Fund $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fund-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'fund_type_id')->dropDownList(ArrayHelper::map(FundType::find()->all(), 'id', 'name'), ['prompt' => ' -- เลือก -- ']) ?>

    <?= $form->field($model, 'fund_type_in_id')->radioList(ArrayHelper::map(FundTypeIn::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'asset_management_id')->dropDownList(ArrayHelper::map(AssetManagement::find()->all(), 'id', 'name_en'), ['prompt' => ' -- เลือก -- ']) ?>
    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nav')->textInput() ?>

    <?= $form->field($model, 'nav_date')->textInput() ?>

    <?= $form->field($model, 'risk')->textInput() ?>

    <?= $form->field($model, 'feeder_fund')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_policy')->textInput() ?>

    <?= $form->field($model, 'currency_policy')->radioList($model->currencyPolicyList) ?>

    <?= $form->field($model, 'dividend')->radioList([0 => 'ไม่จ่าย', 1 => 'จ่าย']) ?>

    <?= $form->field($model, 'frontend_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'backend_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_invest')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invest')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_date')->textInput() ?>

    <?= $form->field($model, 'registration_date_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'net_asset_value')->textInput() ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content_status')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
