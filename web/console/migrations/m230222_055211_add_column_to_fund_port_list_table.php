<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund_port_list}}`.
 */
class m230222_055211_add_column_to_fund_port_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port_list_detail', 'calculate', $this->tinyInteger()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
