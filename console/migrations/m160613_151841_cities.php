<?php

use yii\db\Migration;

class m160613_151841_cities extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()
        ], $tableOptions);

        $this->insert('{{%cities}}',array('title'=>'Oslo'));
        $this->insert('{{%cities}}',array('title'=>'Praha'));
        $this->insert('{{%cities}}',array('title'=>'Berlin'));

    }


    public function down()
    {
        $this->dropTable('cities');

        echo "m160613_151841_cities cannot be reverted.\n";

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
