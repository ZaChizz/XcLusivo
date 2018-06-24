<?php

use yii\db\Migration;

class m160705_172857_user_correction_online_status extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'time_session', $this->integer('11')->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'time_session');
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
