<?php

use yii\db\Migration;

class m160822_130032_create_table_favorits extends Migration
{
    public function up()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%favorits}}', [
          'user_id' => 'INT(11) NOT NULL',
          'advertiser_id' => 'INT(11) NOT NULL',
          'PRIMARY KEY (`user_id`, `advertiser_id`)'
      ]);

      $this->addForeignKey('fk-favorits-user_id', '{{%favorits}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
      $this->addForeignKey('fk-favorits-advertiser_id', '{{%favorits}}', 'advertiser_id', '{{%advertiser}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-favorits-user_id', '{{%favorits}}');
        $this->dropForeignKey('fk-favorits-advertiser_id', '{{%favorits}}');
        $this->dropTable('{{%favorits}}');
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
