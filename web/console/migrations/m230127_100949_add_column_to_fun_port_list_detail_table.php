<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fun_port_list_detail}}`.
 */
class m230127_100949_add_column_to_fun_port_list_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund_port_list_detail', 'cost_nav', $this->double()->null()->defaultValue(0)->after('units')->comment('ใช้สำหรับ type 2'));
        $this->addColumn('fund_port_list_detail', 'profit_amount', $this->double()->null()->defaultValue(0)->after('cost_nav')->comment('ใช้สำหรับ type 2'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
