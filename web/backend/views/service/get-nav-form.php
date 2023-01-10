<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin([
                    'id' => 'activeForm-date-form',
                    'enableAjaxValidation' => TRUE,
                    'options' => ['data-pjax' => false],
        //'action' => Url::to(['get-fund-nav']),
        //'method' => 'POST'
        ]); ?>

    <?php
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'วันที่ Nav ...', 'required' => true],
            //'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy',
                'todayHighlight' => true,
            ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$script = <<< JS
        
$(document).on("beforeSubmit", "#activeForm-date-form", function(e){
    e.preventDefault();
    var form = $(this);
    var date = $('#dateform-date');
        //console.log(form.serialize());
    Swal.fire({
        title: form.attr('alert'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#loading-spinner').modal('show');
            $.ajax({
                method:form.attr('method'),
                url: form.attr('action'),
                data : form.serialize() + '&valid=1',
                success: function (data) {
                    $('#loading-spinner').modal('show');
                    if(data.status){
                        alertRedirect(data.message, data.url);
                    }
                    else{
                        alertWarning(data.message);
                    }
                },
                error: function(requestObject, error, errorThrown)
                {
                    console.log("Error with Ajax Post Request:" + error);
                    console.log(errorThrown);
                }
            });
        }     
    });
    return false;
});
        
JS;
$this->registerJs($script);
?>