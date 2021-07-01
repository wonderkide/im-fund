<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund_port_list}}`.
 */
class m210701_104433_add_column_to_fund_port_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port_list', 'ratio', $this->decimal(12,2)->null()->after('percent'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
