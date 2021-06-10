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
        $this->createTable('{{%fund_invest}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'fund_id' => $this->integer()->null(),
            'present_value' => $this->double()->notNull()->defaultValue(0),
            'cost_value' => $this->double()->notNull()->defaultValue(0),
            'present_nav' => $this->double()->notNull()->defaultValue(0),
            'cost_nav' => $this->double()->notNull()->defaultValue(0),
            'units' => $this->double()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->null(),
        ]);
        
        $this->addForeignKey("fk-fund_invest-user_id", 'fund_invest', 'user_id', 'user', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund_invest-fund_id", 'fund_invest', 'fund_id', 'fund', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_invest}}');
    }
}
