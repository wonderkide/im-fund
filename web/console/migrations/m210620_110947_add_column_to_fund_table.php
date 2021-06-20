<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund}}`.
 */
class m210620_110947_add_column_to_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund', 'nav', $this->double()->null()->after('name_th'));
        $this->addColumn('fund', 'nav_date', $this->date()->null()->after('nav'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
