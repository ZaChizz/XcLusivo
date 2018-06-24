<?php

use yii\db\Migration;

class m160730_142126_create_table_currency extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string('3')->notNull(),
            'symbol_left' => $this->string('12')->notNull().' DEFAULT ""',
            'symbol_right' => $this->string('12')->notNull().' DEFAULT ""',
            'value' => $this->float(15, 8),
            'status' => 'TINYINT(1) NOT NULL DEFAULT 1',
            'date_modified' => 'INT(11)'
        ], $tableOptions);

        $this->insert('{{%currency}}',array('code'=>'XBT', 'symbol_left' => '', 'symbol_right' => '', 'value' => 1, 'status' => 1, 'date_modified' => time()));
        $this->insert('{{%currency}}',array('code'=>'EUR', 'symbol_left' => '€', 'symbol_right' => '', 'value' => 595.78, 'status' => 1, 'date_modified' => time()));
        $this->insert('{{%currency}}',array('code'=>'GBP', 'symbol_left' => '£', 'symbol_right' => '', 'value' => 499.83, 'status' => 1, 'date_modified' => time()));
        $this->insert('{{%currency}}',array('code'=>'NOK', 'symbol_left' => '', 'symbol_right' => '', 'value' => 5544, 'status' => 1, 'date_modified' => time()));
    }

    public function down()
    {
          $this->dropTable('{{%currency}}');
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
