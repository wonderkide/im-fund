<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_invest}}`.
 */
class m210610_091803_create_fund_invest_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_port}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'name' => $this->string()->notNull(),
            'present_value' => $this->double()->notNull()->defaultValue(0),
            'cost_value' => $this->double()->notNull()->defaultValue(0),
            'present_nav' => $this->double()->notNull()->defaultValue(0),
            'cost_nav' => $this->double()->notNull()->defaultValue(0),
            'units' => $this->double()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->null(),
        ]);
        
        $this->addForeignKey("fk-fund_port-user_id", 'fund_port', 'user_id', 'user', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_port}}');
    }
}
