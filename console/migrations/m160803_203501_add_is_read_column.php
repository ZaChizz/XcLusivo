<?php

use yii\db\Migration;

class m160803_203501_add_is_read_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%message}}', 'read_at', 'INT(11) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('{{%message}}', 'read_at');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
