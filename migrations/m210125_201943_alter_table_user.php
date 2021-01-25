<?php

use yii\db\Migration;

/**
 * Class m210125_201943_alter_table_user
 */
class m210125_201943_alter_table_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'about', $this->text());
        $this->addColumn('{{%user}}', 'type', $this->integer(3));
        $this->addColumn('{{%user}}', 'nickname', $this->string(60));
        $this->addColumn('{{%user}}', 'picture', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'about');
        $this->dropColumn('{{%user}}', 'type');
        $this->dropColumn('{{%user}}', 'nickname');
        $this->dropColumn('{{%user}}', 'picture');
    }
}
