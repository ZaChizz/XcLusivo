<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_221009_fix_contents_table extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `{{%page_contents}}` CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';");
    }

    public function down()
    {
        echo "m160214_221009_fix_contents_table cannot be reverted.\n";

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
