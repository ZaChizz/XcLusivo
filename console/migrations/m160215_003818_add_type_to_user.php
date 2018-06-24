<?php

use yii\db\Schema;
use yii\db\Migration;

class m160215_003818_add_type_to_user extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `{{%user}}` ADD `type` SMALLINT(1) NOT NULL DEFAULT '0' AFTER `email`;");
    }

    public function down()
    {
        echo "m160215_003818_add_type_to_user cannot be reverted.\n";

        return false;
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
