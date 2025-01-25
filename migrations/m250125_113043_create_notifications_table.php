<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m250125_113043_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notifications}}');
    }

    public function up()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'title' => $this->string(240)->notNull(),
            'text' => $this->text()->notNull(),
            'view_count' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('notifications');
    }
}
