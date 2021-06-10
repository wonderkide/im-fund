<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_sector_category}}`.
 */
class m210610_091153_create_fund_sector_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_sector_category}}', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string()->notNull(),
            'name_th' => $this->string()->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);
        
        $this->insert('fund_sector_category', [
           'name_en' => 'Energy', 
           'name_th' => 'กลุ่มอุตสาหกรรมพลังงาน', 
        ]);
        
        $this->insert('fund_sector_category', [
           'name_en' => 'Materials', 
           'name_th' => 'ภาควัสดุ', 
        ]);
        
        $this->insert('fund_sector_category', [
           'name_en' => 'Industrials', 
           'name_th' => 'ภาคอุตสาหกรรม', 
        ]);
        
        $this->insert('fund_sector_category', [
           'name_en' => 'Consumer Discretionary', 
           'name_th' => 'สินค้าอุปโภคบริโภค', 
        ]);
        
        $this->insert('fund_sector_category', [
           'name_en' => 'Consumer Staples', 
           'name_th' => 'กลุ่มอุตสาหกรรมสินค้าจำเป็น', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Health Care', 
           'name_th' => 'สุขภาพ', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Financials', 
           'name_th' => 'กลุ่มอุตสาหกรรมการเงิน', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Information Technology', 
           'name_th' => 'ภาคเทคโนโลยี', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Communications Services', 
           'name_th' => 'กลุ่มอุตสาหกรรมบริการสื่อสาร', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Utilities', 
           'name_th' => 'สาธารณูปโภค', 
        ]);
        $this->insert('fund_sector_category', [
           'name_en' => 'Real Estate', 
           'name_th' => 'ภาคอสังหาริมทรัพย์', 
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_sector_category}}');
    }
}
