<?php

use yii\db\Migration;

class m160721_124241_add_on_whom extends Migration
{
    public function up()
    {
        $this->addColumn('{{%spam_reports}}', 'on_whom', 'INT(11) UNSIGNED');
    }

    public function down()
    {
          $this->dropColumn('{{%spam_reports}}', 'on_whom');
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
