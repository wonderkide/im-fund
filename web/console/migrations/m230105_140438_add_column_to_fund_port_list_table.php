<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund_port_list}}`.
 */
class m230105_140438_add_column_to_fund_port_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port_list', 'profit', $this->double()->null()->defaultValue(0)->after('units'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
