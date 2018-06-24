<?php

use yii\db\Migration;

class m160720_153652_eAuth_user extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%user}} ADD `social_services` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `email`");
    }

    public function down()
    {
        $this->dropColumn('{{%user}}','social_services');
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
