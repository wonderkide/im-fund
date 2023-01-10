<?php

?>
<table class="table table-striped table-bordered text-center">
    <thead class="">
        <tr>
            <th scope="col">วันที่</th>
            <th scope="col">กองทุน</th>
            <th scope="col">จำนวนเงิน</th>
            <th scope="col">ทำรายการ</th>
        </tr>
    </thead>
    <tbody>
        <?php if($history): ?>
        <?php foreach ($history as $value): 
            $text = '-';
            if($value['type'] == 1){
                $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ซื้อ</span>';
            }
            elseif($value['type'] == 2){
                $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ขาย</span>';
            }
            elseif($value['type'] == 3){
                $text = '<span class="text-light bg-success p-1 pl-2 pr-2 rounded">ย้ายเข้า</span>';
            }
            elseif($value['type'] == 4){
                $text = '<span class="text-light bg-danger p-1 pl-2 pr-2 rounded">ย้ายออก</span>';
            }

        ?>
        <tr>
            <td>
                <?= $value['date'] ?>
            </td>
            <td>
                <?= $value['symbol'] ?>
            </td>
            <td>
                <?= number_format($value['amount']) ?>
            </td>
            <td>
                <?= $text ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="3"><p class="mb-0 alert bg-no-content text-center">ไม่มีข้อมูล</p></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>