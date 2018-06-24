<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_233820_add_settings extends Migration
{
    public function up()
    {
        $upd = time();
        $this->execute("INSERT INTO `xclusivo`.`{{%settings}}` (`pay_account`, `meta_title`, `admin_email`, `percent`, `updated_at`) VALUES ('0', '', '', '0', $upd);");
    }

    public function down()
    {
        echo "m160214_233820_add_settings cannot be reverted.\n";

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
