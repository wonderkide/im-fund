<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund}}`.
 */
class m210610_083355_create_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund}}', [
            'id' => $this->primaryKey(),
            //'user_id' => $this->integer()->null(),
            'fund_type_id' => $this->integer()->null(),
            'fund_type_in_id' => $this->integer()->null(),
            'asset_management_id' => $this->integer()->null(),
            'fund_connext_id' => $this->string()->null(),
            'proj_id' => $this->string()->null(),
            'amc_id' => $this->string()->null(),
            'symbol' => $this->string()->notNull(),
            'name_en' => $this->string()->null(),
            'name_th' => $this->string()->null(),
            'risk' => $this->integer()->null(),
            'feeder_fund' => $this->string()->null(),
            'currency_policy' => $this->tinyInteger()->notNull()->defaultValue(4)->comment('1=ป้องกัน,2=ไม่ป้องกัน,3=ป้องกันบางส่วน,4=ดุลพินิจ'),
            'dividend' => $this->tinyInteger()->null()->comment('0=ไม่จ่าย,1=จ่าย'),
            'frontend_fee' => $this->decimal(12,2)->null()->comment('ค่าธรรมเนียมขาย'),
            'backend_fee' => $this->decimal(12,2)->null()->comment('ค่าธรรมเนียมรับซื้อคืน'),
            'fee' => $this->decimal(12,2)->null()->comment('ค่าธรรมเนียมจัดการ'),
            'first_invest' => $this->decimal(12,2)->null()->comment('ลงทุนครั้งแรก'),
            'invest' => $this->decimal(12,2)->null()->comment('ลงทุนครั้งถัดไป'),
            'registration_date' => $this->date()->null(),
            'net_asset_value' => $this->double()->null(),
            'detail' => $this->text()->null()
        ]);
        
        $this->addForeignKey("fk-fund-fund_type_id", 'fund', 'fund_type_id', 'fund_type', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund-fund_type_in_id", 'fund', 'fund_type_in_id', 'fund_type_in', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund-asset_management_id", 'fund', 'asset_management_id', 'asset_management', 'id', 'SET NULL');
        
        $this->createIndex('idx_fund-symbol', 'fund', 'symbol');
        $this->createIndex('idx_fund_connext_id-app', 'fund', 'fund_connext_id');
        $this->createIndex('idx_proj_id-app', 'fund', 'proj_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund}}');
    }
}
