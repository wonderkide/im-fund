<?php

use yii\db\Migration;

/**
 * Class m210620_091012_add_as_code_to_asset_table
 */
class m210620_091012_add_as_code_to_asset_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('asset_management', 'amc_code', $this->string(64)->notNull());
        
        $this->update('asset_management', ['amc_code' => '0C00001KVS'], ['name_en' => 'ASP']);
        $this->update('asset_management', ['amc_code' => '0C00001L0D'], ['name_en' => 'KSAM']);
        $this->update('asset_management', ['amc_code' => '0C00001LDR'], ['name_en' => 'BBLAM']);
        $this->update('asset_management', ['amc_code' => '0C00001LQT'], ['name_en' => 'PRINCIPAL']);
        $this->update('asset_management', ['amc_code' => '0C00001OY7'], ['name_en' => 'KASSET']);
        $this->update('asset_management', ['amc_code' => '0C00001P3H'], ['name_en' => 'KTAM']);
        $this->update('asset_management', ['amc_code' => '0C00001PHI'], ['name_en' => 'MAMT']);
        $this->update('asset_management', ['amc_code' => '0C00001Q9P'], ['name_en' => 'ONEAM']);
        $this->update('asset_management', ['amc_code' => '0C00001QII'], ['name_en' => 'PHILLIP']);
        $this->update('asset_management', ['amc_code' => '0C00001RAE'], ['name_en' => 'SCBAM']);
        $this->update('asset_management', ['amc_code' => '0C00001RD5'], ['name_en' => 'S-FUNDS']);
        $this->update('asset_management', ['amc_code' => '0C00001RJ1'], ['name_en' => 'KKPAM']);
        $this->update('asset_management', ['amc_code' => '0C00001S2B'], ['name_en' => 'THANACHART']);
        $this->update('asset_management', ['amc_code' => '0C00001S61'], ['name_en' => 'TISCOAM']);
        $this->update('asset_management', ['amc_code' => '0C00001S64'], ['name_en' => 'TMBAM']);
        $this->update('asset_management', ['amc_code' => '0C000021FE'], ['name_en' => 'ASI']);
        $this->update('asset_management', ['amc_code' => '0C000021G1'], ['name_en' => 'MFC']);
        
        $this->update('asset_management', ['amc_code' => '0C00006JX8', 'name_th' => 'แคปปิตอล ลิ้งค์', 'name_en' => 'CLM'], ['name_en' => 'RENAISSANCE']);

        $this->update('asset_management', ['amc_code' => '0C0000918I'], ['name_en' => 'LHFUND']);
        $this->update('asset_management', ['amc_code' => '0C0000A4C1'], ['name_en' => 'UOBAM']);
        $this->update('asset_management', ['amc_code' => '0C0000B47C'], ['name_en' => 'BCAP']);
        $this->update('asset_management', ['amc_code' => '0C0000B5U7'], ['name_en' => 'TALISAM']);
        $this->update('asset_management', ['amc_code' => '0C0000BBPA'], ['name_en' => 'SKFM']);
        $this->update('asset_management', ['amc_code' => '0C0000BLL7'], ['name_en' => 'WEASSET']);
        $this->update('asset_management', ['amc_code' => '0C0000BYGY'], ['name_en' => 'AIAIMT']);
        
        //$this->delete('asset_management', ['name_en' => 'RENAISSANCE']);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210620_091012_add_as_code_to_asset_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210620_091012_add_as_code_to_asset_table cannot be reverted.\n";

        return false;
    }
    */
}
