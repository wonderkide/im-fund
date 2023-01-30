<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_config}}`.
 */
class m230127_065423_create_service_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_config}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'setting' => $this->json()->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)
        ]);
        
        $this->insert('service_config', [
            'name' => 'get_amc',
            'description' => 'ดึงข้อมูล asset management'
        ]);
        
        $this->insert('service_config', [
            'name' => 'get_fund_nav',
            'description' => 'ดึงข้อมูล nav ประจำวัน'
        ]);
        
        $this->insert('service_config', [
            'name' => 'calculate_port',
            'description' => 'คำนวณมูลค่าพอร์ต'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_config}}');
    }
}
