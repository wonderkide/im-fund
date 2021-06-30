<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_type}}`.
 */
class m210607_131154_create_fund_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'name_en' => $this->string()->null(),
            'parent_id' => $this->integer()->null()
        ]);
        $this->insert('fund_type', [
            'id' => 1,
            'name' => 'ตราสารหนี้',
            'name_en' => 'Fixed Income',
            'parent_id' => null
        ]);
        $this->insert('fund_type', [
            'id' => 2,
            'name' => 'กองทุนรวมแบบผสม',
            'name_en' => 'Allocation',
            'parent_id' => null
        ]);
        $this->insert('fund_type', [
            'id' => 3,
            'name' => 'อสังหาริมทรัพย์, REITs และอื่นๆ',
            'name_en' => 'Property, infrastructure, REITs',
            'parent_id' => null
        ]);
        $this->insert('fund_type', [
            'id' => 4,
            'name' => 'สินค้าโภคภัณฑ์',
            'name_en' => 'Commodities',
            'parent_id' => null
        ]);
        $this->insert('fund_type', [
            'id' => 5,
            'name' => 'ตราสารทุน (หุ้น)',
            'name_en' => 'Equity',
            'parent_id' => null
        ]);
        $this->insert('fund_type', [
            'id' => 6,
            'name' => 'อื่นๆ',
            'name_en' => 'Miscellaneous',
            'parent_id' => null
        ]);
        
        // 1
        $this->insert('fund_type', [
            'name' => 'พันธบัตรรัฐบาลระยะสั้น',
            'name_en' => 'Short Term Government Bond',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ระยะสั้น',
            'name_en' => 'Short Term General Bond',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ระยะกลาง',
            'name_en' => 'Mid Term General Bond',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ระยะยาว',
            'name_en' => 'Long Term General Bond',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตลาดเงินภาครัฐ',
            'name_en' => 'Money Market Government',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตลาดเงินทั่วไป',
            'name_en' => 'Money Market General',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ประเทศตลาดเกิดใหม่ แบบป้องกันความเสี่ยงอัตราแลกเปลี่ยนเต็มจำนวน',
            'name_en' => 'Emerging Market Bond Fully F/X Hedge',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ตลาดเกิดใหม่ ทั้งแบบป้องกันหรือไม่ป้องกันความเสี่ยงอัตราแลกเปลี่ยนตามดุลยพินิจของผู้จัดการกองทุน',
            'name_en' => 'Emerging Market Bond Discretionary F/X Hedge or Unhedge',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ทั่วโลก แบบป้องกันความเสี่ยงอัตราแลกเปลี่ยนเต็มจำนวน',
            'name_en' => 'Global Bond Fully F/X Hedge',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ทั่วโลก ทั้งแบบป้องกันหรือไม่ป้องกันความเสี่ยงอัตราแลกเปลี่ยนตามดุลยพินิจของผู้จัดการกองทุน',
            'name_en' => 'Global Bond Discretionary F/X Hedge or Unhedge',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'ตราสารหนี้ที่มีอันดับความน่าเชื่อถือต่ำกว่าระดับลงทุน',
            'name_en' => 'High Yield Bond',
            'parent_id' => 1
        ]);
        $this->insert('fund_type', [
            'name' => 'พันธบัตรรัฐบาลระยะกลาง',
            'name_en' => 'Mid Term Government Bond',
            'parent_id' => 1
        ]);
        
        //2
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมแบบผสมเชิงรุก (Aggressive)',
            'name_en' => 'Aggressive Allocation',
            'parent_id' => 2
        ]);
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมแบบผสมสมดุล (Moderate)',
            'name_en' => 'Moderate Allocation',
            'parent_id' => 2
        ]);
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมแบบผสมเสี่ยงต่ำ (Conservative)',
            'name_en' => 'Conservative Allocation',
            'parent_id' => 2
        ]);
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมแบบผสมลงทุนต่างประเทศ',
            'name_en' => 'Foreign Investment Allocation',
            'parent_id' => 2
        ]);
        
        //3
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมอสังหาริมทรัพย์ไทย',
            'name_en' => 'Fund of Property fund - Thai',
            'parent_id' => 3
        ]);
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมอสังหาริมทรัพย์ และ ทรัสต์เพื่อการลงทุนในอสังหาริมทรัพย์ผสมไทยและต่างประเทศ',
            'name_en' => 'Fund of Property fund - Thai and Foreign',
            'parent_id' => 3
        ]);
        $this->insert('fund_type', [
            'name' => 'กองทุนรวมอสังหาริมทรัพย์ต่างประเทศ',
            'name_en' => 'Fund of Property fund - Foreign',
            'parent_id' => 3
        ]);
        
        //4
        $this->insert('fund_type', [
            'name' => 'ดัชนีสินค้าโภคภัณฑ์',
            'name_en' => 'Broad Composite Commodities index',
            'parent_id' => 4
        ]);
        $this->insert('fund_type', [
            'name' => 'สินค้าโภคภัณฑ์ประเภทพลังงาน',
            'name_en' => 'Commodities Energy',
            'parent_id' => 4
        ]);
        $this->insert('fund_type', [
            'name' => 'สินค้าโภคภัณฑ์ประเภทโลหะมีค่า',
            'name_en' => 'Commodities Precious Metals',
            'parent_id' => 4
        ]);
        $this->insert('fund_type', [
            'name' => 'สินค้าโภคภัณฑ์ประเภทสินค้าเกษตร',
            'name_en' => 'Commodities Agriculture',
            'parent_id' => 4
        ]);
        
        //5
        $this->insert('fund_type', [
            'name' => 'หุ้นไทยขนาดเล็กและกลาง',
            'name_en' => 'Equity Small - Mid Cap',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นไทยขนาดใหญ่',
            'name_en' => 'Equity Large Cap',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นไทยทั่วไป',
            'name_en' => 'Equity General',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นสหรัฐฯ',
            'name_en' => 'US Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นญี่ปุ่น',
            'name_en' => 'Japan Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นยุโรป',
            'name_en' => 'European Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นจีน',
            'name_en' => 'Greater China Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นทั่วโลก',
            'name_en' => 'Global Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นตลาดเกิดใหม่',
            'name_en' => 'Emerging Market',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นเอเซีย แปซิฟิค ยกเว้น ญี่ปุ่น',
            'name_en' => 'Asia Pacific Ex Japan',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นอินเดีย',
            'name_en' => 'India Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นอาเซียน',
            'name_en' => 'ASEAN Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นกลุ่มอุตสาหกรรม Health Care',
            'name_en' => 'Health Care',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'ดัชนีหุ้น SET 50',
            'name_en' => 'SET 50 Index Fund',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นกลุ่มอุตสาหกรรมพลังงาน',
            'name_en' => 'Energy',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นเวียดนาม',
            'name_en' => 'Vietnam Equity',
            'parent_id' => 5
        ]);
        $this->insert('fund_type', [
            'name' => 'หุ้นกลุ่มเทคโนโลยี',
            'name_en' => 'Technology Equity',
            'parent_id' => 5
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_type}}');
    }
}
