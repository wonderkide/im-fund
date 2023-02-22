<?php

use yii\db\Migration;

/**
 * Class m230222_062218_add_column_realized_to_prot_and_port_list_table
 */
class m230222_062218_add_column_realized_to_prot_and_port_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port', 'realized', $this->double()->notNull()->defaultValue(0)->after('profit_amount'));
        $this->addColumn('fund_port_list', 'realized', $this->double()->notNull()->defaultValue(0)->after('ratio'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230222_062218_add_column_realized_to_prot_and_port_list_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230222_062218_add_column_realized_to_prot_and_port_list_table cannot be reverted.\n";

        return false;
    }
    */
}
