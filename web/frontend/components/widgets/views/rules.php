<?php
use yii\bootstrap4\Modal;

Modal::begin([
    'title' => '<h3>กฏ กติกา และมารยาทในการใช้งานบนเว็บไซต์</h3>',
    'id' => 'rules-modal',
    //'toggleButton' => ['label' => 'Close'],
]);
echo '
<div id="rules-modal" class="fade modal in" role="dialog" tabindex="-1" style="display: block;">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3>กฏ กติกา และมารยาทในการใช้งานบนเว็บไซต์</h3>
</div>
<div class="modal-body">
<p><strong><span style="color:rgb(0, 0, 255)">กรุณาอ่าน กฎ และเงื่อนไขในการใช้งาน Website โดยละเอียด</span></strong></p>

<p><span style="color:rgb(42, 42, 42)">1. ห้ามเผยแพร่ข้อความเนื้อหาที่ทำให้สถาบันชาติ ศาสนา พระมหากษัตริย์และพระบรมวงศานุวงศ์เสื่อมเสีย ไม่ว่าจะเป็นทางข้อความ หรือทางภาพ</span><br>
<span style="color:rgb(42, 42, 42)">2. ห้ามเผยแพร่ข้อความและเนื้อหาที่เป็นการโฆษณาชวนเชื่อและหลอกลวง ไม่ว่าจะเป็นทางข้อความ หรือทางภาพ หากฝ่าฝืนจะผิดกฎหมายในข้อหาโฆษณาหลอกลวงประชาชน</span><br>
<span style="color:rgb(42, 42, 42)">3. ห้ามเผยแพร่ข้อความและเนื้อหาที่ทำให้ผู้อื่นนั้นเสียหาย รำคาญใจ หรือก่อเกิดความรู้สึกไม่ดีต่อผู้อื่น ไม่ว่าจะเกิดด้วยความตั้งใจหรือไม่</span><br>
<span style="color:rgb(42, 42, 42)">4. ห้ามเผยแพร่ข้อความที่ส่อเสียดหรือว่ากล่าวให้ร้ายแก่สมาชิกผู้อื่น ไม่ว่าข้อความนั้นจะมีว่าอย่างไร จะกล่าวถึงชื่อผู้อื่นหรือไม่</span><br>
<span style="color:rgb(42, 42, 42)">5. ห้ามเผยแพร่ข้อความที่ยุยงให้ผู้อื่นเกิดความขัดแย้งซึ่งกันและกัน ไม่ว่าผู้ตั้งกระทู้หรือผู้ตอบนั้นจะตั้งใจหรือไม่</span><br>
<span style="color:rgb(42, 42, 42)">6. ห้ามเผยแพร่ข้อความ รูปภาพ ที่ส่อไปในเรื่องเพศ ลามกอนาจาร หรือขัดต่อศีลธรรมอันดีของไทย</span><br>
<span style="color:rgb(42, 42, 42)">7. ห้ามเผยแพร่ข้อความที่ไม่ก่อให้เกิดประโยชน์แก่ผู้อื่น หรือข้อความที่ซ้ำๆ ในกระทู้เดียวกันหรือหลายกระทู้ ทั้งนี้ขึ้นอยู่กับความเหมาะสม เจตนาของผู้ตั้งกระทู้หรือผู้ตอบ และสถานการณ์ในกระทู้นั้น</span><br>
<span style="color:rgb(42, 42, 42)">8. ห้ามเผยแพร่ข้อความหรือกระทู้ที่ส่อให้เห็นถึงเจตนาในการพนันต่างๆ ไม่ว่าจะวิธีใดก็ตาม</span><br>
<span style="color:rgb(42, 42, 42)">9. ห้ามเผยแพร่ข้อมูลส่วนตัวของตนเองและของผู้อื่น ซึ่งสามารถสร้างความเสียหายให้กับบุคคลผู้เป็นเจ้าของหรือบุคคลที่สาม เช่นหมายเลขโทรศัพท์ หมายเลขบัตรเครดิต ฯลฯ ไม่ว่าผู้เผยแพร่จะมีเจตนาหรือไม่</span><br>
<span style="color:rgb(42, 42, 42)">10. ขอสงวนสิทธิ์ไม่ให้บริการ Username บางคำที่เป็นของผู้ดูแลระบบ ได้แก่ "webmaster", "web editor", "hostmaster", "postmaster", "admin", "member(s)", "customer / customer service" หรือคำอื่นๆ ที่พิจารณาว่าไม่เหมาะสมสำหรับการใช้เป็น Username</span><br>
<span style="color:rgb(42, 42, 42)">11. สมาชิกจะต้องใช้นามแฝงที่เหมาะสม ไม่หยาบคาย หรือส่อไปในทางลามกอนาจาร มิฉะนั้นทีมงานมีสิทธิ์ ไม่ให้สิทธิ์การเป็นสมาชิกได้</span><br>
<span style="color:rgb(42, 42, 42)">12. ทีมงานขอสงวนสิทธิ์ในการยกเลิกความเป็นสมาชิกได้ โดยไม่ต้องบอกกล่าวให้ทราบล่วงหน้า</span><br>
<span style="color:rgb(42, 42, 42)">13. ทีมงานขอสงวนสิทธิ์ในการหยุดให้บริการ เมื่อใดก็ได้ โดยไม่ต้องแจ้งให้สมาชิกทราบล่วงหน้า</span><br>
<span style="color:rgb(42, 42, 42)">14. ทีมงานขอสงวนสิทธิ์ในการลบกระทู้ และความคิดเห็นใน Website&nbsp;โดยมิต้องแจ้งให้ทราบล่วงหน้า</span><br>
<br>
<span style="color:rgb(42, 42, 42)">*** ข้อความ และรูปภาพ ที่ถูกพิมพ์และเผยแพร่ออกจากเว็บบอร์ดแห่งนี้ เกิดขึ้นจากการเขียนโดยสาธารณชน และตีพิมพ์แบบอัตโนมัติ ซึ่งทางเว็บไซต์&nbsp;และทีมงาน ไม่จำเป็นต้องเห็นด้วย และ "ไม่รับผิดชอบ" ต่อข้อความ และรูปภาพใดๆ ผู้อ่านจึงต้องใช้วิจารณญาณในการกลั่นกรองด้วยตนเอง อย่างไรก็ตาม หากท่านพบข้อความ หรือรูปภาพที่ไม่เหมาะสม ได้ถูกเผยแพร่ลงในเว็บไซต์ อาทิเช่น คำพูดที่ลบหลู่ ดูหมิ่นต่อความมั่นคงของชาติ ศาสนา และพระมหากษัตริย์ สิ่งผิดกฎหมาย หรือขัดต่อศีลธรรมต่างๆ กรุณาแจ้งมาที่ webmaster ของแต่ละเว็บไซต์ เพื่อทีมงานจะได้ดำเนินการโดยเร็วที่สุด</span><br>
<br>
<strong><span style="color:rgb(255, 0, 68)">คำแนะนำในการตั้งชื่อ ห้ามใช้ชื่อไม่เหมาะสมดังต่อไปนี้</span></strong><br>
<br>
<span style="color:rgb(42, 42, 42)">1. มีความหมายไม่เหมาะสม หยาบคาย เป็นคำผวน หรือส่อไปในทาง ลามกอนาจาร</span><br>
<span style="color:rgb(42, 42, 42)">2. กล่าวพาดพิง หรือล้อเลียน ถึงสถาบัน ยี่ห้อสินค้า บุคคลอื่น</span><br>
<span style="color:rgb(42, 42, 42)">3. มีข้อมูลส่วนตัว เช่น ชื่อ-นามสกุล อีเมล์ เบอร์โทร ฯลฯ</span><br>
<span style="color:rgb(42, 42, 42)">4. ชื่อคล้ายชื่อสมาชิกที่มีอยู่แล้ว หรือมีข้อความที่ทำให้เกิดความสับสน เช่น ตัวจริง ตัวปลอม</span><br>
<span style="color:rgb(42, 42, 42)">5. ใช้ตัวอักษรซ้ำกันมากๆ หรือไม่มีความหมาย เช่น 55555, adsdsfsd 6. เป็นชื่อ web, ชื่อสินค้าและบริการ, ชื่อหน่วยงาน หรือชื่อเข้าข่ายโฆษณา ส่งเสริมการขาย</span></p>

</div>

</div>
</div>
</div>
';

Modal::end();

$js = <<< JS
$('.rules-modal-button').click( function (e) {
    $('#rules-modal').modal('show');
});

JS;
 
// register your javascript
$this->registerJs($js);