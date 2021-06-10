<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_type_in}}`.
 */
class m210607_132522_create_fund_type_in_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_type_in}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->insert('fund_type_in', [
            'name' => 'ทั่วไป',
        ]);
        $this->insert('fund_type_in', [
            'name' => 'LTF',
        ]);
        $this->insert('fund_type_in', [
            'name' => 'RMF',
        ]);
        $this->insert('fund_type_in', [
            'name' => 'SSF',
        ]);
        $this->insert('fund_type_in', [
            'name' => 'SSFX',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_type_in}}');
    }
}
