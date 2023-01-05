<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fund_port_list_detail}}`.
 */
class m210614_091518_create_fund_port_list_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fund_port_list_detail}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'fund_port_list_id' => $this->integer()->null(),
            'date' => $this->date()->notNull(),
            'sale_date' => $this->date()->null(),
            'nav' => $this->double()->notNull(),
            'amount' => $this->double()->notNull(),
            'units' => $this->double()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'type' => $this->tinyInteger()->notNull()->comment('1=ซื้อ,2=ขาย,3=สับเปลี่ยนเข้า,4=สับเปลี่ยนออก'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('1=ปกติ,0=ลบ')
        ]);
        
        $this->addForeignKey("fk-fund_port_list_detail-fund_port_list_id", 'fund_port_list_detail', 'fund_port_list_id', 'fund_port_list', 'id', 'SET NULL');
        $this->addForeignKey("fk-fund_port_list_detail-fund_id", 'fund_port_list_detail', 'user_id', 'user', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fund_port_list_detail}}');
    }
}
