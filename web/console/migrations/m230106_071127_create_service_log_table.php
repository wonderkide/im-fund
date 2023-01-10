<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_log}}`.
 */
class m230106_071127_create_service_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_log}}', [
            'id' => $this->primaryKey(),
            'action' => $this->string()->notNull(),
            'detail' => $this->json()->null(),
            'created_at' => $this->timestamp()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(true)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_log}}');
    }
}
