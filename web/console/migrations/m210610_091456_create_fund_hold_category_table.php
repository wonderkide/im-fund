<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_hold_category}}`.
 */
class m210610_091456_create_fund_hold_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_hold_category}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'name_en' => $this->string()->notNull(),
            'name_th' => $this->string()->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);
        
        $this->addForeignKey("fk-fund_hold_category-user_id", 'fund_hold_category', 'user_id', 'user', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_hold_category}}');
    }
}
