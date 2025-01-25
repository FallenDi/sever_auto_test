<?php
use yii\db\Migration;

class m250125_160431_create_notifications_table_and_user extends Migration
{
    public function safeUp()
    {
        // Создание таблицы пользователей
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание таблицы уведомлений
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(240)->notNull(),
            'content' => $this->text()->notNull(),
            'views_count' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'user_id' => $this->integer()->notNull(),
        ]);

        // Индекс и связь для user_id в таблице уведомлений
        $this->createIndex(
            '{{%idx-notifications-user_id}}',
            '{{%notifications}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-notifications-user_id}}',
            '{{%notifications}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Удаление связи и индекса
        $this->dropForeignKey('{{%fk-notifications-user_id}}', '{{%notifications}}');
        $this->dropIndex('{{%idx-notifications-user_id}}', '{{%notifications}}');

        // Удаление таблиц
        $this->dropTable('{{%notifications}}');
        $this->dropTable('{{%users}}');
    }
}
