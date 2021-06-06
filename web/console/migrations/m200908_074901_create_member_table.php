<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%member}}`.
 */
class m200908_074901_create_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'fullname' => $this->string()->null(),
            'phone' => $this->string()->null(),
            'email' => $this->string()->notNull(),
            'detail' => $this->text()->null(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'ip' => $this->string()->null(),
            'status' => $this->smallInteger(),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null)
        ]);

        $this->createIndex('username', 'user', 'username', true);
        
        $security = Yii::$app->security;

        $this->batchInsert('user', ['username', 'fullname', 'phone', 'email', 'auth_key', 'password_hash', 'status', 'created_at'], [
            ['admin', 'admin', '1234567890', 'admin@fund.in.com', $security->generateRandomString(), $security->generatePasswordHash('admin1234'), 1, date("Y-m-d H:i:s")],
            ['tester', 'tester', '1234567890', 'tester@fund.in.com', $security->generateRandomString(), $security->generatePasswordHash('tester1234'), 1, date("Y-m-d H:i:s")],
        ]);
         
         $this->addCommentOnColumn('user', 'status', '0=inactive,1=active');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
