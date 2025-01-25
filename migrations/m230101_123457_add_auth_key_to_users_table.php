<?
use yii\db\Migration;

class m230101_123457_add_auth_key_to_users_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'auth_key', $this->string(32)->notNull()->defaultValue(''));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'auth_key');
    }
}
