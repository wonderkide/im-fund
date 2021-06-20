<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fund}}`.
 */
class m210620_135349_add_column_to_fund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fund', 'content_status', $this->tinyInteger()->null()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
