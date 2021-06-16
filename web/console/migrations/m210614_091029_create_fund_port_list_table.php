<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_port_list}}`.
 */
class m210614_091029_create_fund_port_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_port_list}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'fund_port_id' => $this->integer()->null(),
            'fund_id' => $this->integer()->null(),
            'present_value' => $this->double()->notNull()->defaultValue(0),
            'cost_value' => $this->double()->notNull()->defaultValue(0),
            'present_nav' => $this->double()->notNull()->defaultValue(0),
            'cost_nav' => $this->double()->notNull()->defaultValue(0),
            'units' => $this->double()->null()->defaultValue(0),
            'percent' => $this->double()->null()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->null(),
        ]);
        
        $this->addForeignKey("fk-fund_port_list-user_id", 'fund_port_list', 'user_id', 'user', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund_port_list-fund_port_id", 'fund_port_list', 'fund_port_id', 'fund_port', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund_port_list-fund_id", 'fund_port_list', 'fund_id', 'fund', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_port_list}}');
    }
}
