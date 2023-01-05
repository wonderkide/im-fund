<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h5 class="text-bold mb-0">จัดการผู้ใช้งาน</h5>
        </div>
    <div class="card-body">
<div class="admin-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?php echo Html::a('<i class="fa fa-plus"></i> เพิ่มผู้ใช้งาน', null, [
            'class' => 'btn btn-success activity-create-link text-light',
            'data-title' => 'เพิ่มผู้ใช้งาน',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <table id="table-dt" class="table table-striped table-bordered dt-responsive nowrap text-center font-size-08" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อผู้ใช้งาน</th> 
                <th>สร้างเมื่อ</th>
                <th>แก้ไขเมื่อ</th>
                <th>สถานะ</th>
                <th colspan="" class="no-sort">การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $adminAll = $dataProvider->query->all();
            foreach ($adminAll as $value) {
                if($value->status){
                    $status_text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">Active</span>';
                }
                else{
                    $status_text = '<span class="text-light bg-secondary p-1 pl-2 pr-2  rounded">Inactive</span>';
                }
            ?>
                <tr>
                    <td><?= $value['id'] ?></td>
                    <td><?= $value['username'] ?></td>
                    <td><?= !is_null($value['created_at']) ? $value['created_at'] : "-" ?></td>
                    <td><?= !is_null($value['updated_at']) ? $value['updated_at'] : "-" ?></td>
                    <td><?= $status_text ?></td>
                    <td colspan="2">
                        <?php if(Yii::$app->user->identity->role || Yii::$app->user->id == 1): ?>
                        <?= Html::button('<i class="fa fa-pencil-alt"></i>', [
                            'class' => 'btn btn-sm btn-success activity-manage-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-id' => $value['id'],
                            'data-url' => 'update',
                            'data-title' => 'แก้ไขข้อมูลผู้ใช้งาน',
                        ]) ?>
                        
                        <?= Html::button('<i class="fa fa-key"></i>', [
                            'class' => 'btn btn-sm btn-warning activity-manage-link',
                            'title' => 'เปลี่ยนรหัสผ่าน',
                            'data-id' => $value['id'],
                            'data-url' => 'change-password',
                            'data-title' => 'เปลี่ยนรหัสผ่าน',
                        ]) ?>
                        <?= Html::button('<i class="fa fa-trash-alt"></i>', [
                            'class' => 'btn btn-sm btn-danger activity-delete-link',
                            'title' => 'ลบข้อมูล',
                            'data-id' => $value['id'],
                            'data-url' => Url::to(['admin/delete', 'id' => $value['id']]),
                            'data-title' => 'ลบข้อมูล',
                        ]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
          <?php
            }
            ?>
        </tbody>
    </table>

</div>
    </div>
</div>
<?php 
Modal::begin([
    'id'=>'activity-modal',
    'size'=>'modal-lg',
    'title' => 'MANAGEMENT',
    'clientOptions' => ['backdrop' => 'static']
    //'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>',
]);
Modal::end();
?>

<?php
$script = <<< JS
        $('#table-dt').DataTable( {
            'lengthMenu': [[100,250,500,-1],[100,250,500,'All']],
            "autoWidth": true,
        "responsive": true,
        'columnDefs': [
                { targets: 'no-sort', orderable: false, order: []},
                { targets: 'data-hide', bVisible: false, searchable: true},
            ]
        } );
        
JS;
$this->registerJs($script);
?>
