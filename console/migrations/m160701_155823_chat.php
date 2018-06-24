<?php

use yii\db\Migration;

class m160701_155823_chat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->delete('{{%chat}}');
        $this->delete('message');

        $this->dropColumn('message','sender');
        $this->addColumn('message','user_id',$this->integer('11')->notNull());

        $this->addForeignKey('chat_ibfk_1','chat','adv_id','user','id','cascade','cascade');
        $this->addForeignKey('chat_ibfk_2','chat','nadv_id','user','id','cascade','cascade');

        $this->addForeignKey('message_ibfk_1','message','chat_id','chat','id','cascade','cascade');
        $this->addForeignKey('message_ibfk_2','message','user_id','user','id','cascade','cascade');

    }

    public function down()
    {
        echo "m160701_155823_chat cannot be reverted.\n";

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
