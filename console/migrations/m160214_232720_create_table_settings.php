<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_232720_create_table_settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'pay_account' => $this->string()->notNull()->defaultValue(0),
            'meta_title' => $this->string()->notNull()->defaultValue(''),
            'admin_email' => $this->string()->notNull()->defaultValue(''),
            'percent' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%settings}}');
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
