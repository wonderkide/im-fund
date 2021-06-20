<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund}}`.
 */
class m210620_125227_add_column_to_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund', 'registration_date_text', $this->string()->null()->after('registration_date'));
        $this->addColumn('fund', 'currency_policy_text', $this->string(512)->null()->after('currency_policy'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
