<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund_list_detail}}`.
 */
class m230110_093846_add_column_to_fund_list_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port_list_detail', 'note', $this->text()->null()->after('units'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
