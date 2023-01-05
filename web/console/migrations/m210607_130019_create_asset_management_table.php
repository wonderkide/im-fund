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
            'amc_id' => $this->string(64)->null(),
            'name_th' => $this->string()->notNull(),
            'name_en' => $this->string()->notNull(),
            'codename' => $this->string()->null(),
        ]);
        
        /*$this->insert('asset_management', [
            'name_th' => 'แอสเซท พลัส',
            'name_en' => 'ASSETPLUS',
            'amc_code' => 'C0000005022',
            'tmf_code' => 'ASSETFUND'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กรุงศรี',
            'name_en' => 'KSAM',
            'amc_code' => 'C0000000709',
            'tmf_code' => 'KSAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'บัวหลวง',
            'name_en' => 'BBLAM',
            'amc_code' => 'C0000000329',
            'tmf_code' => 'BBLAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'พรินซิเพิล',
            'name_en' => 'PRINCIPAL',
            'amc_code' => 'C0000005531',
            'tmf_code' => 'PRINCIPAL'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กสิกรไทย',
            'name_en' => 'KASSET',
            'amc_code' => 'C0000000021',
            'tmf_code' => 'KASSET'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'กรุงไทย',
            'name_en' => 'KTAM',
            'amc_code' => 'C0000000460',
            'tmf_code' => 'KTAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'คิง ไว',
            'name_en' => 'KWIAM',
            'amc_code' => 'C0000006185',
            'tmf_code' => 'KWIAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'วรรณ',
            'name_en' => 'ONEAM',
            'amc_code' => 'C0000000569',
            'tmf_code' => 'ONEAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ฟิลลิป',
            'name_en' => 'PHILLIP',
            'amc_code' => 'C0000006122',
            'tmf_code' => 'PAMC'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ไทยพาณิชย์',
            'name_en' => 'SCBAM',
            'amc_code' => '0C00001RAE',
            'tmf_code' => 'SCBAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เอ็กซ์สปริง',
            'name_en' => 'XSpring',
            'amc_code' => 'C0000006099',
            'tmf_code' => 'S-FUNDS'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เกียรตินาคินภัทร',
            'name_en' => 'KKPAM',
            'amc_code' => 'C0000000623',
            'tmf_code' => 'KKPAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ทิสโก้',
            'name_en' => 'TISCOAM',
            'amc_code' => 'C0000000324',
            'tmf_code' => 'TISCOASSET'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'อเบอร์ดีน สแตนดาร์ด',
            'name_en' => 'abrdn',
            'amc_code' => 'C0000000290',
            'tmf_code' => 'ABERDEEN'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เอ็มเอฟซี',
            'name_en' => 'MFC',
            'amc_code' => 'C0000000023',
            'tmf_code' => 'MFC'
        ]);

        $this->insert('asset_management', [
            'name_th' => 'แลนด์ แอนด์ เฮ้าส์',
            'name_en' => 'LHFUND',
            'amc_code' => 'C0000006646',
            'tmf_code' => 'LHFUND'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ยูโอบี',
            'name_en' => 'UOBAM',
            'amc_code' => 'C0000000623',
            'tmf_code' => 'UOBAMTH'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'บางกอกแคปปิตอล',
            'name_en' => 'BCAP',
            'amc_code' => 'C0000021747',
            'tmf_code' => 'BCAP'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ทาลิส',
            'name_en' => 'TALISAM',
            'amc_code' => 'C0000024008',
            'tmf_code' => 'TALISAM'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'ดาโอ',
            'name_en' => 'DAOL',
            'amc_code' => 'C0000028866',
            'tmf_code' => 'DAOLINVESTMENT'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'เอไอเอ',
            'name_en' => 'AIAIM',
            'amc_code' => 'C0000031161',
            'tmf_code' => 'AIA'
        ]);
        $this->insert('asset_management', [
            'name_th' => 'อีสท์สปริง',
            'name_en' => 'Eastspring',
            'amc_code' => 'C0000033452',
            'tmf_code' => 'ESTH'
        ]);*/
        
        $this->createIndex('idx_amc_id-app', 'asset_management', 'amc_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%asset_management}}');
    }
}
