<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%asset_management}}`.
 */
class m210607_130019_create_asset_management_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%asset_management}}', [
            'id' => $this->primaryKey(),
            'name_th' => $this->string()->notNull(),
            'name_en' => $this->string()->null(),
            'code' => $this->string()->null(),
        ]);
        
        $this->insert('asset_management', [
            'name_th' => 'แอสเซท พลัส',
            'name_en' => 'ASP'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กรุงศรี',
            'name_en' => 'KSAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'บัวหลวง',
            'name_en' => 'BBLAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'พรินซิเพิล',
            'name_en' => 'PRINCIPAL'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กสิกรไทย',
            'name_en' => 'KASSET'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กรุงไทย',
            'name_en' => 'KTAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'แมนูไลฟ์',
            'name_en' => 'MAMT'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'วรรณ',
            'name_en' => 'ONEAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ฟิลลิป',
            'name_en' => 'PHILLIP'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ไทยพาณิชย์',
            'name_en' => 'SCBAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'อินโนเทค',
            'name_en' => 'S-FUNDS'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เกียรตินาคินภัทร',
            'name_en' => 'KKPAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ธนชาต',
            'name_en' => 'THANACHART'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ทิสโก้',
            'name_en' => 'TISCOAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ทหารไทย',
            'name_en' => 'TMBAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'อเบอร์ดีน สแตนดาร์ด',
            'name_en' => 'ASI'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เอ็มเอฟซี',
            'name_en' => 'MFC'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เรนเนสซานซ์',
            'name_en' => 'LHFUND'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'แลนด์ แอนด์ เฮ้าส์',
            'name_en' => ''
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ยูโอบี',
            'name_en' => 'UOBAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'บางกอกแคปปิตอล',
            'name_en' => 'BCAP'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ทาลิส',
            'name_en' => 'TALISAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'สยาม ไนท์ ฟันด์ แมเนจเม้นท์',
            'name_en' => ''
        ]);
        $this->insert('asset_management', [
            'name_th' => 'วี',
            'name_en' => 'WEASSET'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เอไอเอ',
            'name_en' => 'AIAIMT'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%asset_management}}');
    }
}
