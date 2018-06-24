<?php

use yii\db\Migration;

class m160613_153103_nationality extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%nationality}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->insert('{{%nationality}}',array('title'=>'Caucasian'));
        $this->insert('{{%nationality}}',array('title'=>'Cuban'));
        $this->insert('{{%nationality}}',array('title'=>'Italian'));
        $this->insert('{{%nationality}}',array('title'=>'Russian'));
        $this->insert('{{%nationality}}',array('title'=>'Mexican'));

    }

    public function down()
    {

        $this->dropTable('{{%nationality}}');

        echo "m160613_153103_advertiser cannot be reverted.\n";

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
