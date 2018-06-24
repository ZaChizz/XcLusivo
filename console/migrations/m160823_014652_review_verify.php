<?php

use yii\db\Migration;

class m160823_014652_review_verify extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%reviews}} ADD `verify` INT(1) DEFAULT 0 AFTER `title`");
    }

    public function down()
    {
        $this->dropColumn('{{%reviews}}', 'verify');
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
