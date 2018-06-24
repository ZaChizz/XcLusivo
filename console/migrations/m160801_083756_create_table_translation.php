<?php

use yii\db\Migration;

class m160801_083756_create_table_translation extends Migration
{
    public function up()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
          // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%translation}}', [
          'id' => $this->primaryKey(),
          'lang_code' => $this->string('5')->notNull(),
          'category' => $this->string('255')->notNull(),
          'org_text' => $this->text()->notNull(),
          'trans_text' => $this->text()->notNull(),
          'INDEX lang_code (lang_code)'
      ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%translation}}');
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
