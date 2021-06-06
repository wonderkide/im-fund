<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin}}`.
 */
class m200830_171731_create_admin_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'role' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => $this->timestamp()->defaultValue(null)
        ]);

        $this->createIndex('username', 'admin', 'username', true);
        
        $security = Yii::$app->security;

        $this->batchInsert('admin', ['username', 'auth_key', 'password_hash', 'role', 'status', 'created_at'], [
            ['admin', $security->generateRandomString(), $security->generatePasswordHash('admin'), 10, 1, date("Y-m-d H:i:s")],
            //['demo', $security->generateRandomString(), $security->generatePasswordHash('demo'), 10, 1, date("Y-m-d H:i:s")],
        ]);
        
        $this->addCommentOnColumn('admin', 'status', '0=inactive,1=active');
        $this->addCommentOnColumn('admin', 'role', '1=user,5=superuser,10=admin');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%admin}}');
    }

}
