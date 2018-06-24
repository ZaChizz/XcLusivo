<?php

use yii\db\Migration;

class m160704_183627_user_correction extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%user}} ADD `phone` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `status`");
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'phone');
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
