<?php
use yii\helpers\Url;
?>

<div class="fund-invest-index p-4 bg-white">
    <?php if($history): ?>
    <div class="accordion" id="accordionH">
        <?php foreach ($history as $key => $value): //var_dump($value['date']);exit(); ?>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <p class="mb-0 co-get-his" data-key="<?= $key ?>" data-id="<?= $port->id ?>" data-date="<?= $value['date'] ?>" type="button" data-toggle="collapse" data-target="#collapse-<?= $key ?>" aria-expanded="true" aria-controls="collapse-<?= $key ?>">
                        <?= $value['date'] ?> (<?= number_format($value['amount']) ?>฿)
                    </p>
                </h5>
            </div>

            <div id="collapse-<?= $key ?>" class="collapse" aria-labelledby="heading-<?= $key ?>" data-parent="#accordionH">
                <div class="card-body">
                    <div id="text-collapse-<?= $key ?>">
                        <?= $this->render('_history_table', ['history' => $value['data']]) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="mb-0 alert bg-no-content text-center">ไม่มีข้อมูล</p>
    <?php endif; ?>
    
</div>

<?php

/*
$url_get_history = Url::to(['get-history']);
$script = <<< JS
    $(document).on('click', '.co-get-his', function(e){ 
        var id = $(this).data("id");
        var key = $(this).data("key");
        var date = $(this).data("date");
        $.get(
            '$url_get_history',
            {
                date: date,
                id: id
            },
            function (data)
            {
                if(data.status){
                    console.log(data.data);
                    $('#text-collapse-'+key).html(data.data);
                }
            }
        );
    });
        
JS;
$this->registerJs($script);
?>*/