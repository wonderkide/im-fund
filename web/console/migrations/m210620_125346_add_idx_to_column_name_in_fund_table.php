<?php

use yii\db\Migration;

/**
 * Class m210620_125346_add_idx_to_column_name_in_fund_table
 */
class m210620_125346_add_idx_to_column_name_in_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_fund_name', 'fund', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210620_125346_add_idx_to_column_name_in_fund_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210620_125346_add_idx_to_column_name_in_fund_table cannot be reverted.\n";

        return false;
    }
    */
}
