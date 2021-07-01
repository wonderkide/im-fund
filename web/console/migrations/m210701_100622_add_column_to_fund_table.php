<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund}}`.
 */
class m210701_100622_add_column_to_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund', 'updated_at', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
